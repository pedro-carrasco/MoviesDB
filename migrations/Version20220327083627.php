<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327083627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX genre_name_idx ON genre (name)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, producer_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1D5EF26F89B658FE ON movie (producer_id)');
        $this->addSql('CREATE TABLE movie_genre (movie_id INT NOT NULL, genre_id INT NOT NULL, PRIMARY KEY(movie_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_FD1229648F93B6FC ON movie_genre (movie_id)');
        $this->addSql('CREATE INDEX IDX_FD1229644296D31F ON movie_genre (genre_id)');
        $this->addSql('CREATE TABLE movie_actors (movie_id INT NOT NULL, person_id INT NOT NULL, PRIMARY KEY(movie_id, person_id))');
        $this->addSql('CREATE INDEX IDX_26EC6D908F93B6FC ON movie_actors (movie_id)');
        $this->addSql('CREATE INDEX IDX_26EC6D90217BBB47 ON movie_actors (person_id)');
        $this->addSql('CREATE TABLE movie_directors (movie_id INT NOT NULL, person_id INT NOT NULL, PRIMARY KEY(movie_id, person_id))');
        $this->addSql('CREATE INDEX IDX_3578A4C28F93B6FC ON movie_directors (movie_id)');
        $this->addSql('CREATE INDEX IDX_3578A4C2217BBB47 ON movie_directors (person_id)');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, death_date DATE DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX person_name_idx ON person (name)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F89B658FE FOREIGN KEY (producer_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229644296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_actors ADD CONSTRAINT FK_26EC6D908F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_actors ADD CONSTRAINT FK_26EC6D90217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_directors ADD CONSTRAINT FK_3578A4C28F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie_directors ADD CONSTRAINT FK_3578A4C2217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movie_genre DROP CONSTRAINT FK_FD1229644296D31F');
        $this->addSql('ALTER TABLE movie_genre DROP CONSTRAINT FK_FD1229648F93B6FC');
        $this->addSql('ALTER TABLE movie_actors DROP CONSTRAINT FK_26EC6D908F93B6FC');
        $this->addSql('ALTER TABLE movie_directors DROP CONSTRAINT FK_3578A4C28F93B6FC');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26F89B658FE');
        $this->addSql('ALTER TABLE movie_actors DROP CONSTRAINT FK_26EC6D90217BBB47');
        $this->addSql('ALTER TABLE movie_directors DROP CONSTRAINT FK_3578A4C2217BBB47');
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_genre');
        $this->addSql('DROP TABLE movie_actors');
        $this->addSql('DROP TABLE movie_directors');
        $this->addSql('DROP TABLE person');
    }
}
