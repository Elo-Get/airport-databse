<?php

namespace App\DataFixtures;

use App\Entity\Vol;
use App\Entity\Avion;
use App\Entity\Repas;
use App\Entity\Vente;
use App\Entity\Billet;
use App\Entity\Client;
use App\Entity\Gerant;
use App\Entity\Escales;
use App\Entity\Facture;
use App\Entity\Aeroport;
use App\Entity\Commande;
use App\Entity\RepasVol;
use App\Entity\Entretien;
use App\Entity\Personnel;
use App\Model\Enum\PaysEnum;
use App\Entity\CarteFidelite;
use App\Entity\CompteVoyageur;
use App\Model\Enum\TypeVolEnum;
use App\Model\Enum\StatutVolEnum;
use App\Model\Enum\TypeAvionEnum;
use App\Model\Enum\TypePosteEnum;
use App\Model\Enum\TypeRepasEnum;
use App\Model\Enum\TypeBilletEnum;
use App\Model\Enum\TypePaiementEnum;
use App\Model\Enum\TypeDocVoyageEnum;
use App\Model\Enum\TypeEntretienEnum;
use App\Model\Enum\StatutEntretienEnum;
use Doctrine\Persistence\ObjectManager;

use App\Model\Enum\VillesDestinationEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $om): void
    {
        

        // Quelques aeroports
        $aeroports = [];
        foreach (VillesDestinationEnum::cases() as $ville) {

            // Pays est une enum de 

            $aeroport = (new Aeroport())
                ->setNom("Aéroport de {$ville->value}")
                ->setVille($ville)
                ->setPays(PaysEnum::cases()[array_rand(PaysEnum::cases())]);
            $om->persist($aeroports[] = $aeroport);
        }

        // 1. Quelques avions
        $avions = [];
        foreach ([TypeAvionEnum::A220, TypeAvionEnum::A320, TypeAvionEnum::A350] as $type) {
            $a = (new Avion())
                ->setTypeAvion($type)
                ->setCapacite(rand(100, 300))
                ->setDateMiseEnService(new \DateTime(sprintf('-%dy', rand(1,10))));
            $om->persist($avions[] = $a);
        }

        // 2. Entretien sur chaque avion
        foreach ($avions as $avion) {
            for ($i=0; $i<3; $i++) {
                $e = (new Entretien())
                    ->setAvion($avion)
                    ->setDateEntretien((new \DateTime())->modify("-{$i} months"))
                    ->setTypeEntretien(TypeEntretienEnum::MAINTENANCE)
                    ->setStatutEntretien($i ? StatutEntretienEnum::FAIT : StatutEntretienEnum::AFAIRE)
                    ->setCommentaire('Vérif sécurité');
                $om->persist($e);
            }
        }



        // 3. Personnel
        $roles = TypePosteEnum::cases();
        $personnels = [];
        foreach (range(1,10) as $i) {
            $p = (new Personnel())
                ->setNom("Nom{$i}")
                ->setPrenom("Prenom{$i}")
                ->setFonction([$roles[array_rand($roles)]])
                ->setDateEmbauche((new \DateTime())->modify('-'.rand(0,5).' years'));
            $om->persist($personnels[] = $p);
        }

        // 4. Clients / cartes
        $clients = [];
        foreach (range(1,20) as $i) {
            $c = (new Client())
                ->setNom("ClientNom{$i}")
                ->setPrenom("ClientPrenom{$i}")
                ->setDateNaissance((new \DateTime())->modify('-'.rand(18,70).' years'))
                ->setEmail("client{$i}@traveljet.com")
                ->setAdressePostale("Address {$i}, City")
                ->setNumDocVoyage("DOC{$i}")
                ->setTypeDocVoyage(array_rand(TypeDocVoyageEnum::cases()) ? TypeDocVoyageEnum::PASSEPORT : TypeDocVoyageEnum::CNI)
                ->setNbMiles(rand(0,10000));
            $om->persist($clients[] = $c);


            $cv = (new CompteVoyageur())
                ->setLogin("user{$i}")
                ->setPassword(password_hash("pass{$i}", PASSWORD_BCRYPT))
                ->setDateCreation(new \DateTime('-'.rand(0,5).' years'))
                ->setClient($c);
            $om->persist($cv);
            

            $cf = (new CarteFidelite())
                ->setIdClient($c)
                ->setDateObtention((new \DateTime())->modify('-'.rand(0,3).' years'));
            $om->persist($cf);
        }


        // 5. Repas disponibles
        $repasOptions = [];
        foreach (TypeRepasEnum::cases() as $r) {
            $rE = (new Repas())->setTypeRepas($r);
            $om->persist($repasOptions[] = $rE);
        }


        // 6. Vols + escales + repasVol + commandes + billets + factures
        $ventes = [];
        foreach (range(1,12) as $m) {
            $v = (new Vente())->setMois($m)->setAnnee(2025)->setChiffreAffaire(rand(50000,200000));
            $om->persist($ventes[] = $v);
        }

        $vols = [];
        foreach ($avions as $avion) {
            for ($j=0; $j<5; $j++) {
                $vd = new \DateTime("+".rand(1,60)." days");
                $va = (clone $vd)->modify('+'.rand(1,12).' hours');
                $vol = (new Vol())
                    ->setAvion($avion)
                    ->setDateDepart($vd)
                    ->setDateArrivee($va)
                    ->setDistanceKm(rand(200,8000))
                    ->setTypeVol(TypeVolEnum::cases()[rand(0,2)])
                    ->setPrixBase(rand(50,1000))
                    ->setStatutVol(StatutVolEnum::cases()[rand(0,4)])
                    ->setAeroportDepart($aeroports[array_rand($aeroports)])
                    ->setAeroportArrive($aeroports[array_rand($aeroports)])
                    ->setRaisonRetard(rand(0,4)==1 ? 'Météo' : null);
                $om->persist($vol);
                $vols[] = $vol;

                // escales
                $esc = (new Escales())
                    ->setDureeEscale(rand(30,180))
                    ->setVilleEscale(VillesDestinationEnum::cases()[rand(0, count(VillesDestinationEnum::cases()) - 1)]);
                $esc->addVol($vol);
                $om->persist($esc);

                // repasVol
                $rv = (new RepasVol())->setQuantite(rand(50,200));
                $rv->addVol($vol);
                foreach ($repasOptions as $rp) {
                    if (rand(0,1)) $rv->addRepa($rp);
                }
                $om->persist($rv);

                // commandes
                $cli = $clients[array_rand($clients)];
                $cmd = (new Commande())
                    ->setClient($cli)
                    ->setDateCommande(new \DateTime())
                    ->setMoyentPaiement(TypePaiementEnum::CB)
                    ->setPrixTotal($vol->getPrixBase() * rand(1,4))
                    ->setAssuranceAnnulation((bool)rand(0,1));
                $om->persist($cmd);

                $fact = (new Facture())
                    ->setCommande($cmd)
                    ->setMontantTotal($cmd->getPrixTotal())
                    ->setDateFacture(new \DateTime());
                $om->persist($fact);

                $bil = (new Billet())
                    ->setCommande($cmd)
                    ->setVol($vol)
                    ->setClient($cli)
                    ->setPrixEffectif($vol->getPrixBase())
                    ->setClasse(TypeBilletEnum::cases()[rand(0,3)])
                    ->setNbBagagesSoute(rand(0,2));
                $om->persist($bil);
            }
        }

        // 8. Gérent 
       for ($i = 1; $i <= 3; $i++) {
            $gerant = (new Gerant())
                ->setEmail("client{$i}@traveljet.com")
                ->setRoles(['ROLE_GERANT'])
                ->setPassword(password_hash("pass{$i}", PASSWORD_BCRYPT));
            $om->persist($gerant);
       }

        $om->flush();
    }
}
