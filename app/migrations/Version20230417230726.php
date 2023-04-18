<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20230417230726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE product (id BIGSERIAL PRIMARY KEY, name VARCHAR(255) NOT NULL, price INT NOT NULL)');
        $this->addSql('CREATE TABLE tax_number (id BIGSERIAL PRIMARY KEY, country VARCHAR(255) NOT NULL, prefix VARCHAR(2) DEFAULT NULL, tax DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO product (name, price) VALUES (\'Pods\', 100), (\'Case\', 20)');
        $this->addSql('INSERT INTO tax_number (country, prefix, tax) VALUES (\'Germany\', \'DE\', 0.19), (\'Italy\', \'IT\', 0.22), (\'Greece\', \'GR\', 0.24)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tax_number_id_seq CASCADE');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE tax_number');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
