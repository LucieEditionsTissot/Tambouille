<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223181241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE "group" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE ingredient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ingredient_family_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_6BAF7870C92CFE1D FOREIGN KEY (ingredient_family_id) REFERENCES ingredient_family (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6BAF7870C92CFE1D ON ingredient (ingredient_family_id)');
        $this->addSql('CREATE TABLE ingredient_family (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE ingredient_quantity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, unit_id INTEGER DEFAULT NULL, ingredient_id INTEGER DEFAULT NULL, recipe_id INTEGER DEFAULT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_EDF546B8F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EDF546B8933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EDF546B859D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EDF546B8F8BD700D ON ingredient_quantity (unit_id)');
        $this->addSql('CREATE INDEX IDX_EDF546B8933FE08C ON ingredient_quantity (ingredient_id)');
        $this->addSql('CREATE INDEX IDX_EDF546B859D8A214 ON ingredient_quantity (recipe_id)');
        $this->addSql('CREATE TABLE preparation_step (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, recipe_id INTEGER DEFAULT NULL, description VARCHAR(255) NOT NULL, ordre INTEGER NOT NULL, CONSTRAINT FK_F144A8FF59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F144A8FF59D8A214 ON preparation_step (recipe_id)');
        $this->addSql('CREATE TABLE preparation_step_ingredient (preparation_step_id INTEGER NOT NULL, ingredient_id INTEGER NOT NULL, PRIMARY KEY(preparation_step_id, ingredient_id), CONSTRAINT FK_18EF1758CFB64244 FOREIGN KEY (preparation_step_id) REFERENCES preparation_step (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_18EF1758933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_18EF1758CFB64244 ON preparation_step_ingredient (preparation_step_id)');
        $this->addSql('CREATE INDEX IDX_18EF1758933FE08C ON preparation_step_ingredient (ingredient_id)');
        $this->addSql('CREATE TABLE recipe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, recipe_type_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cooking_time INTEGER NOT NULL, images CLOB NOT NULL --(DC2Type:array)
        , nb_persons INTEGER NOT NULL, CONSTRAINT FK_DA88B137F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DA88B13789A882D3 FOREIGN KEY (recipe_type_id) REFERENCES recipe_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DA88B137F675F31B ON recipe (author_id)');
        $this->addSql('CREATE INDEX IDX_DA88B13789A882D3 ON recipe (recipe_type_id)');
        $this->addSql('CREATE TABLE recipe_equipement (recipe_id INTEGER NOT NULL, equipement_id INTEGER NOT NULL, PRIMARY KEY(recipe_id, equipement_id), CONSTRAINT FK_F1CA409059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F1CA4090806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F1CA409059D8A214 ON recipe_equipement (recipe_id)');
        $this->addSql('CREATE INDEX IDX_F1CA4090806F0F5C ON recipe_equipement (equipement_id)');
        $this->addSql('CREATE TABLE recipe_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE unit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE user_group (user_id INTEGER NOT NULL, group_id INTEGER NOT NULL, PRIMARY KEY(user_id, group_id), CONSTRAINT FK_8F02BF9DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8F02BF9DFE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8F02BF9DA76ED395 ON user_group (user_id)');
        $this->addSql('CREATE INDEX IDX_8F02BF9DFE54D947 ON user_group (group_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_family');
        $this->addSql('DROP TABLE ingredient_quantity');
        $this->addSql('DROP TABLE preparation_step');
        $this->addSql('DROP TABLE preparation_step_ingredient');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_equipement');
        $this->addSql('DROP TABLE recipe_type');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
