<?php
declare(strict_types=1);

namespace App\Command;

use App\Repository\DTO\ImportedCSVData;
use App\Service\ImportCSVDataService;
use DateTime;
use Exception;
use Iterator;
use League\Csv\Reader;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'filmsdb:loadcsv',
    description: 'Load data from CSV file.',
    hidden: false
)]
final class LoadCSVDataCommand extends Command
{


    public function __construct(
        private ImportCSVDataService $dataService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'CSV file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        try {
            $this->checkFileExists($file);
            $content = $this->readFile($file);

            $data = $this->importContentToDB($content, $output);



            for($i = 0; $i <= $totalSteps; $i++) {
                $dataToProcess = array_slice($data, $i * 1000, 1000);

                $progressBar->advance();
            }
            $progressBar->finish();

            return Command::SUCCESS;
        } catch (RuntimeException $e) {
            $this->writeError($output, $e->getMessage());

            return Command::FAILURE;
        }
    }

    private function checkFileExists(string $file): void
    {
        if(false === file_exists($file)) {
            throw new RuntimeException('CSV File not found');
        }
    }

    private function readFile(string $file): Iterator
    {
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);

        return $csv->getRecords();
    }

    /**
     * @param OutputInterface $output
     * @param Exception|RuntimeException $e
     * @return void
     */
    protected function writeError(OutputInterface $output, string $error): void
    {
        $output->writeln([
            '',
            '<error>Error</error>',
            '',
            $error
        ]);
    }

    /**
     * @return ImportedCSVData[]
     */
    private function importContentToDB(Iterator $content, OutputInterface $output)
    {
        $output->writeln('Importando datos');

        $progressBar = new ProgressBar($output);
        $progressBar->start();

        $dataToProcess = [];
        $i = 0;
        foreach ($content as $film) {
            if(22 === count($film)) {
                $importedCSVData = new ImportedCSVData(
                    $film['title'],
                    $this->getDate($film['date_published']),
                    explode(',', $film['genre']),
                    (int)$film['duration'],
                    explode(',', $film['director']),
                    $film['production_company'],
                    explode(',', $film['actors'])
                );

                $dataToProcess[] = $importedCSVData;
                $i++;

                if(0 === ($i % 1000)) {
                    $i = 0;
                    $this->dataService->execute($dataToProcess);
                    $dataToProcess = [];
                }
            }
            $progressBar->advance();
        }

        $this->dataService->execute($dataToProcess);
    }

    private function getDate(string $date): ?DateTime
    {
        $dateFields = explode('-', $date);

        $result = new DateTime();
        $result->setTime(0,0,0);
        $result->setDate(
            (int)$dateFields[0],
            (int)($dateFields[1] ?? 1),
            (int)($dateFields[2] ?? 1)
        );

        return $result;
    }
}