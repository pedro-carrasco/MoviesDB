<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326193436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE actor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE director_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE film_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE producer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE actor (id INT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, death_date DATE DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE director (id INT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE film (id INT NOT NULL, producer_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8244BE2289B658FE ON film (producer_id)');
        $this->addSql('CREATE TABLE film_genre (film_id INT NOT NULL, genre_id INT NOT NULL, PRIMARY KEY(film_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_1A3CCDA8567F5183 ON film_genre (film_id)');
        $this->addSql('CREATE INDEX IDX_1A3CCDA84296D31F ON film_genre (genre_id)');
        $this->addSql('CREATE TABLE film_actor (film_id INT NOT NULL, actor_id INT NOT NULL, PRIMARY KEY(film_id, actor_id))');
        $this->addSql('CREATE INDEX IDX_DD19A8A9567F5183 ON film_actor (film_id)');
        $this->addSql('CREATE INDEX IDX_DD19A8A910DAF24A ON film_actor (actor_id)');
        $this->addSql('CREATE TABLE film_director (film_id INT NOT NULL, director_id INT NOT NULL, PRIMARY KEY(film_id, director_id))');
        $this->addSql('CREATE INDEX IDX_BC171C99567F5183 ON film_director (film_id)');
        $this->addSql('CREATE INDEX IDX_BC171C99899FB366 ON film_director (director_id)');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE producer (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2289B658FE FOREIGN KEY (producer_id) REFERENCES producer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_genre ADD CONSTRAINT FK_1A3CCDA8567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_genre ADD CONSTRAINT FK_1A3CCDA84296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_actor ADD CONSTRAINT FK_DD19A8A9567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_actor ADD CONSTRAINT FK_DD19A8A910DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_director ADD CONSTRAINT FK_BC171C99567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_director ADD CONSTRAINT FK_BC171C99899FB366 FOREIGN KEY (director_id) REFERENCES director (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE film_actor DROP CONSTRAINT FK_DD19A8A910DAF24A');
        $this->addSql('ALTER TABLE film_director DROP CONSTRAINT FK_BC171C99899FB366');
        $this->addSql('ALTER TABLE film_genre DROP CONSTRAINT FK_1A3CCDA8567F5183');
        $this->addSql('ALTER TABLE film_actor DROP CONSTRAINT FK_DD19A8A9567F5183');
        $this->addSql('ALTER TABLE film_director DROP CONSTRAINT FK_BC171C99567F5183');
        $this->addSql('ALTER TABLE film_genre DROP CONSTRAINT FK_1A3CCDA84296D31F');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE2289B658FE');
        $this->addSql('DROP SEQUENCE actor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE director_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE film_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE producer_id_seq CASCADE');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_genre');
        $this->addSql('DROP TABLE film_actor');
        $this->addSql('DROP TABLE film_director');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE producer');
    }
}
