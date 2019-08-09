<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190801085937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->platform->getName() !== 'postgresql');

        $this->addSql('CREATE TABLE schools (
            id uuid NOT NULL,
            name VARCHAR(255) NOT NULL,
            has_wifi boolean NOT NULL,
            address VARCHAR(255) NOT NULL,
            zip VARCHAR(11) NOT NULL,
            district VARCHAR(255) NOT NULL,
            coordinate_lat FLOAT NOT NULL ,
            coordinate_lng FLOAT NOT NULL,
            management_conn_bandwidth INT NOT NULL,
            management_conn_type VARCHAR(255) NOT NULL,
            management_conn_is_symmetric boolean NOT NULL,
            education_conn_bandwidth INT NOT NULL,
            education_conn_type VARCHAR(255) NOT NULL,
            education_conn_is_symmetric boolean NOT NULL,
            
            PRIMARY KEY (id)
        )');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->platform->getName() !== 'postgresql');

        $this->addSql('DROP TABLE schools');
        $this->addSql('DROP DOMAIN GEOPOINT');
    }
}
