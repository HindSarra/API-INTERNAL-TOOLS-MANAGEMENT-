<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251129100213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_request (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, color_hex VARCHAR(7) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, vendor VARCHAR(255) NOT NULL, website_url VARCHAR(255) NOT NULL, monthly_cost NUMERIC(10, 2) NOT NULL, active_users_count INT NOT NULL, owner_department VARCHAR(100) NOT NULL, status VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, category_id INT NOT NULL, INDEX IDX_20F33ED112469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE usage_log (id INT AUTO_INCREMENT NOT NULL, session_date DATE NOT NULL, usage_minutes INT NOT NULL, actions_count INT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, tool_id INT NOT NULL, INDEX IDX_F4102AEAA76ED395 (user_id), INDEX IDX_F4102AEA8F7B22CC (tool_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, department VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, hire_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE usage_log ADD CONSTRAINT FK_F4102AEAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE usage_log ADD CONSTRAINT FK_F4102AEA8F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id)');
        $this->addSql('ALTER TABLE access_requests DROP FOREIGN KEY `access_requests_ibfk_1`');
        $this->addSql('ALTER TABLE access_requests DROP FOREIGN KEY `access_requests_ibfk_2`');
        $this->addSql('ALTER TABLE access_requests DROP FOREIGN KEY `access_requests_ibfk_3`');
        $this->addSql('ALTER TABLE tools DROP FOREIGN KEY `tools_ibfk_1`');
        $this->addSql('ALTER TABLE usage_logs DROP FOREIGN KEY `usage_logs_ibfk_1`');
        $this->addSql('ALTER TABLE usage_logs DROP FOREIGN KEY `usage_logs_ibfk_2`');
        $this->addSql('DROP TABLE access_requests');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE tools');
        $this->addSql('DROP TABLE usage_logs');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE cost_tracking DROP FOREIGN KEY `cost_tracking_ibfk_1`');
        $this->addSql('DROP INDEX unique_tool_month ON cost_tracking');
        $this->addSql('DROP INDEX idx_cost_month_tool ON cost_tracking');
        $this->addSql('DROP INDEX IDX_1E5C21A98F7B22CC ON cost_tracking');
        $this->addSql('ALTER TABLE cost_tracking DROP tool_id, DROP month_year, DROP total_monthly_cost, DROP active_users_count, DROP created_at');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY `user_tool_access_ibfk_1`');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY `user_tool_access_ibfk_2`');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY `user_tool_access_ibfk_3`');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY `user_tool_access_ibfk_4`');
        $this->addSql('DROP INDEX unique_user_tool_active ON user_tool_access');
        $this->addSql('DROP INDEX revoked_by ON user_tool_access');
        $this->addSql('DROP INDEX idx_access_status ON user_tool_access');
        $this->addSql('DROP INDEX idx_access_granted_date ON user_tool_access');
        $this->addSql('DROP INDEX granted_by ON user_tool_access');
        $this->addSql('ALTER TABLE user_tool_access CHANGE granted_at granted_at DATETIME NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE granted_by granted_by_id INT NOT NULL, CHANGE revoked_by revoked_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT FK_CA23EEDDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT FK_CA23EEDD8F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id)');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT FK_CA23EEDD3151C11F FOREIGN KEY (granted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT FK_CA23EEDDFB8FE773 FOREIGN KEY (revoked_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CA23EEDD3151C11F ON user_tool_access (granted_by_id)');
        $this->addSql('CREATE INDEX IDX_CA23EEDDFB8FE773 ON user_tool_access (revoked_by_id)');
        $this->addSql('ALTER TABLE user_tool_access RENAME INDEX idx_access_user TO IDX_CA23EEDDA76ED395');
        $this->addSql('ALTER TABLE user_tool_access RENAME INDEX idx_access_tool TO IDX_CA23EEDD8F7B22CC');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_requests (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tool_id INT NOT NULL, business_justification TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, status ENUM(\'pending\', \'approved\', \'rejected\') CHARACTER SET utf8mb4 DEFAULT \'pending\' COLLATE `utf8mb4_0900_ai_ci`, requested_at DATETIME DEFAULT CURRENT_TIMESTAMP, processed_at DATETIME DEFAULT NULL, processed_by INT DEFAULT NULL, processing_notes TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX idx_requests_status (status), INDEX idx_requests_user (user_id), INDEX processed_by (processed_by), INDEX tool_id (tool_id), INDEX idx_requests_date (requested_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, color_hex VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT \'#6366f1\' COLLATE `utf8mb4_0900_ai_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX name (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tools (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, vendor VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, website_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, category_id INT NOT NULL, monthly_cost NUMERIC(10, 2) NOT NULL, active_users_count INT DEFAULT 0 NOT NULL, owner_department ENUM(\'Engineering\', \'Sales\', \'Marketing\', \'HR\', \'Finance\', \'Operations\', \'Design\') CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, status ENUM(\'active\', \'deprecated\', \'trial\') CHARACTER SET utf8mb4 DEFAULT \'active\' COLLATE `utf8mb4_0900_ai_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX idx_tools_active_users (active_users_count), INDEX idx_tools_category (category_id), INDEX idx_tools_cost_desc (monthly_cost), INDEX idx_tools_department (owner_department), INDEX idx_tools_status (status), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usage_logs (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tool_id INT NOT NULL, session_date DATE NOT NULL, usage_minutes INT DEFAULT 0, actions_count INT DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX idx_usage_date_tool (session_date, tool_id), INDEX tool_id (tool_id), INDEX idx_usage_user_date (user_id, session_date), INDEX IDX_5B25D447A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, email VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, department ENUM(\'Engineering\', \'Sales\', \'Marketing\', \'HR\', \'Finance\', \'Operations\', \'Design\') CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, role ENUM(\'employee\', \'manager\', \'admin\') CHARACTER SET utf8mb4 DEFAULT \'employee\' COLLATE `utf8mb4_0900_ai_ci`, status ENUM(\'active\', \'inactive\') CHARACTER SET utf8mb4 DEFAULT \'active\' COLLATE `utf8mb4_0900_ai_ci`, hire_date DATE DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX email (email), INDEX idx_users_department (department), INDEX idx_users_status (status), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE access_requests ADD CONSTRAINT `access_requests_ibfk_1` FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE access_requests ADD CONSTRAINT `access_requests_ibfk_2` FOREIGN KEY (tool_id) REFERENCES tools (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE access_requests ADD CONSTRAINT `access_requests_ibfk_3` FOREIGN KEY (processed_by) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tools ADD CONSTRAINT `tools_ibfk_1` FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE usage_logs ADD CONSTRAINT `usage_logs_ibfk_1` FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usage_logs ADD CONSTRAINT `usage_logs_ibfk_2` FOREIGN KEY (tool_id) REFERENCES tools (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED112469DE2');
        $this->addSql('ALTER TABLE usage_log DROP FOREIGN KEY FK_F4102AEAA76ED395');
        $this->addSql('ALTER TABLE usage_log DROP FOREIGN KEY FK_F4102AEA8F7B22CC');
        $this->addSql('DROP TABLE access_request');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE tool');
        $this->addSql('DROP TABLE usage_log');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE cost_tracking ADD tool_id INT NOT NULL, ADD month_year DATE NOT NULL, ADD total_monthly_cost NUMERIC(10, 2) NOT NULL, ADD active_users_count INT DEFAULT 0 NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE cost_tracking ADD CONSTRAINT `cost_tracking_ibfk_1` FOREIGN KEY (tool_id) REFERENCES tools (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX unique_tool_month ON cost_tracking (tool_id, month_year)');
        $this->addSql('CREATE INDEX idx_cost_month_tool ON cost_tracking (month_year, tool_id)');
        $this->addSql('CREATE INDEX IDX_1E5C21A98F7B22CC ON cost_tracking (tool_id)');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY FK_CA23EEDDA76ED395');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY FK_CA23EEDD8F7B22CC');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY FK_CA23EEDD3151C11F');
        $this->addSql('ALTER TABLE user_tool_access DROP FOREIGN KEY FK_CA23EEDDFB8FE773');
        $this->addSql('DROP INDEX IDX_CA23EEDD3151C11F ON user_tool_access');
        $this->addSql('DROP INDEX IDX_CA23EEDDFB8FE773 ON user_tool_access');
        $this->addSql('ALTER TABLE user_tool_access CHANGE granted_at granted_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE status status ENUM(\'active\', \'revoked\') DEFAULT \'active\', CHANGE granted_by_id granted_by INT NOT NULL, CHANGE revoked_by_id revoked_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT `user_tool_access_ibfk_1` FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT `user_tool_access_ibfk_2` FOREIGN KEY (tool_id) REFERENCES tools (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT `user_tool_access_ibfk_3` FOREIGN KEY (granted_by) REFERENCES users (id) ON UPDATE NO ACTION');
        $this->addSql('ALTER TABLE user_tool_access ADD CONSTRAINT `user_tool_access_ibfk_4` FOREIGN KEY (revoked_by) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_user_tool_active ON user_tool_access (user_id, tool_id, status)');
        $this->addSql('CREATE INDEX revoked_by ON user_tool_access (revoked_by)');
        $this->addSql('CREATE INDEX idx_access_status ON user_tool_access (status)');
        $this->addSql('CREATE INDEX idx_access_granted_date ON user_tool_access (granted_at)');
        $this->addSql('CREATE INDEX granted_by ON user_tool_access (granted_by)');
        $this->addSql('ALTER TABLE user_tool_access RENAME INDEX idx_ca23eedda76ed395 TO idx_access_user');
        $this->addSql('ALTER TABLE user_tool_access RENAME INDEX idx_ca23eedd8f7b22cc TO idx_access_tool');
    }
}
