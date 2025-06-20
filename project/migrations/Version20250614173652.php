<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614173652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE aeroport (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE affectation_personnel (id SERIAL NOT NULL, role_vol VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE affectation_personnel_personnel (affectation_personnel_id INT NOT NULL, personnel_id INT NOT NULL, PRIMARY KEY(affectation_personnel_id, personnel_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_150B25DD3CFA254C ON affectation_personnel_personnel (affectation_personnel_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_150B25DD1C109075 ON affectation_personnel_personnel (personnel_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE avion (id SERIAL NOT NULL, type_avion VARCHAR(255) NOT NULL, capacite INT NOT NULL, date_mise_en_service DATE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE billet (id SERIAL NOT NULL, commande_id INT DEFAULT NULL, vol_id INT DEFAULT NULL, client_id INT DEFAULT NULL, prix_effectif NUMERIC(10, 0) NOT NULL, classe VARCHAR(255) NOT NULL, nb_bagages_soute SMALLINT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1F034AF682EA2E54 ON billet (commande_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1F034AF69F2BFB7A ON billet (vol_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1F034AF619EB6921 ON billet (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE carte_fidelite (id SERIAL NOT NULL, id_client_id INT DEFAULT NULL, date_obtention DATE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_64AD2B2D99DED506 ON carte_fidelite (id_client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE client (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, email VARCHAR(255) NOT NULL, adresse_postale TEXT DEFAULT NULL, num_doc_voyage VARCHAR(255) NOT NULL, type_doc_voyage VARCHAR(255) NOT NULL, nb_miles INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commande (id SERIAL NOT NULL, client_id INT DEFAULT NULL, date_commande TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, moyent_paiement VARCHAR(255) NOT NULL, prix_total NUMERIC(10, 0) NOT NULL, assurance_annulation BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE compte_voyageur (id SERIAL NOT NULL, client_id INT DEFAULT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_7C82B1A919EB6921 ON compte_voyageur (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON compte_voyageur (login)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE entretien (id SERIAL NOT NULL, avion_id INT NOT NULL, date_entretien DATE NOT NULL, type_entretien VARCHAR(255) NOT NULL, statut_entretien VARCHAR(255) NOT NULL, commentaire TEXT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2B58D6DA80BBB841 ON entretien (avion_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE escales (id SERIAL NOT NULL, duree_escale INT NOT NULL, ville_escale VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE escales_vol (escales_id INT NOT NULL, vol_id INT NOT NULL, PRIMARY KEY(escales_id, vol_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E1FBDB23A0A19C17 ON escales_vol (escales_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E1FBDB239F2BFB7A ON escales_vol (vol_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE facture (id SERIAL NOT NULL, commande_id INT DEFAULT NULL, montant_total NUMERIC(10, 0) NOT NULL, date_facture DATE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_FE86641082EA2E54 ON facture (commande_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE gerant (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON gerant (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE personnel (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, fonction TEXT NOT NULL, date_embauche DATE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN personnel.fonction IS '(DC2Type:simple_array)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE repas (id SERIAL NOT NULL, type_repas VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE repas_vol (id SERIAL NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE repas_vol_vol (repas_vol_id INT NOT NULL, vol_id INT NOT NULL, PRIMARY KEY(repas_vol_id, vol_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AFA9244DF6DDA6F5 ON repas_vol_vol (repas_vol_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AFA9244D9F2BFB7A ON repas_vol_vol (vol_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE repas_vol_repas (repas_vol_id INT NOT NULL, repas_id INT NOT NULL, PRIMARY KEY(repas_vol_id, repas_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2E60E1FF6DDA6F5 ON repas_vol_repas (repas_vol_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2E60E1F1D236AAA ON repas_vol_repas (repas_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vente (id SERIAL NOT NULL, mois INT NOT NULL, annee INT NOT NULL, chiffre_affaire NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vol (id SERIAL NOT NULL, avion_id INT DEFAULT NULL, date_depart TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_arrivee TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, distance_km INT NOT NULL, type_vol VARCHAR(255) NOT NULL, prix_base NUMERIC(10, 0) NOT NULL, statut_vol VARCHAR(255) NOT NULL, raison_retard TEXT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_95C97EB80BBB841 ON vol (avion_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE affectation_personnel_personnel ADD CONSTRAINT FK_150B25DD3CFA254C FOREIGN KEY (affectation_personnel_id) REFERENCES affectation_personnel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE affectation_personnel_personnel ADD CONSTRAINT FK_150B25DD1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billet ADD CONSTRAINT FK_1F034AF682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billet ADD CONSTRAINT FK_1F034AF69F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billet ADD CONSTRAINT FK_1F034AF619EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carte_fidelite ADD CONSTRAINT FK_64AD2B2D99DED506 FOREIGN KEY (id_client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE compte_voyageur ADD CONSTRAINT FK_7C82B1A919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DA80BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE escales_vol ADD CONSTRAINT FK_E1FBDB23A0A19C17 FOREIGN KEY (escales_id) REFERENCES escales (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE escales_vol ADD CONSTRAINT FK_E1FBDB239F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE facture ADD CONSTRAINT FK_FE86641082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_vol ADD CONSTRAINT FK_AFA9244DF6DDA6F5 FOREIGN KEY (repas_vol_id) REFERENCES repas_vol (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_vol ADD CONSTRAINT FK_AFA9244D9F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_repas ADD CONSTRAINT FK_2E60E1FF6DDA6F5 FOREIGN KEY (repas_vol_id) REFERENCES repas_vol (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_repas ADD CONSTRAINT FK_2E60E1F1D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vol ADD CONSTRAINT FK_95C97EB80BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE affectation_personnel_personnel DROP CONSTRAINT FK_150B25DD3CFA254C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE affectation_personnel_personnel DROP CONSTRAINT FK_150B25DD1C109075
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billet DROP CONSTRAINT FK_1F034AF682EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billet DROP CONSTRAINT FK_1F034AF69F2BFB7A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billet DROP CONSTRAINT FK_1F034AF619EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE carte_fidelite DROP CONSTRAINT FK_64AD2B2D99DED506
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE compte_voyageur DROP CONSTRAINT FK_7C82B1A919EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entretien DROP CONSTRAINT FK_2B58D6DA80BBB841
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE escales_vol DROP CONSTRAINT FK_E1FBDB23A0A19C17
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE escales_vol DROP CONSTRAINT FK_E1FBDB239F2BFB7A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE facture DROP CONSTRAINT FK_FE86641082EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_vol DROP CONSTRAINT FK_AFA9244DF6DDA6F5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_vol DROP CONSTRAINT FK_AFA9244D9F2BFB7A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_repas DROP CONSTRAINT FK_2E60E1FF6DDA6F5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE repas_vol_repas DROP CONSTRAINT FK_2E60E1F1D236AAA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vol DROP CONSTRAINT FK_95C97EB80BBB841
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE aeroport
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE affectation_personnel
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE affectation_personnel_personnel
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE avion
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE billet
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE carte_fidelite
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE client
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE compte_voyageur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE entretien
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE escales
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE escales_vol
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE facture
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE gerant
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE personnel
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE repas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE repas_vol
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE repas_vol_vol
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE repas_vol_repas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vente
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vol
        SQL);
    }
}
