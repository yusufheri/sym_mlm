<?php

namespace App\DataFixtures;

use App\Entity\Bonus;
use App\Entity\CatMember;
use App\Entity\CatPaiement;
use App\Entity\Commune;
use Faker\Factory;
use App\Entity\Member;
use App\Entity\Paiement;
use App\Entity\Province;
use App\Entity\Sexe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); 

         //Gestion des Sexe
         $Sexes = [];
         $Sexe = new Sexe();
         $Sexe2 = new Sexe();
 
         $Sexe      ->setLibelle("Homme")
                    ->setContent($faker->sentence());                        
         $manager->persist($Sexe);
         $Sexes[] = $Sexe;
 
         $Sexe2     ->setLibelle("Femme")
                    ->setContent($faker->sentence());
         $manager->persist($Sexe2);
         $Sexes[] = $Sexe2;

        //Gestion des categories de paiement
        $catPaiements = [];
        $catPaiement = new CatPaiement();
        $catPaiement2 = new CatPaiement();

        $catPaiement    ->setLibelle("Frais d'adhésion")
                        ->setIndice(1)
                        ->setContent($faker->sentence());                        
        $manager->persist($catPaiement);
        $catPaiements[] = $catPaiement;

        $catPaiement2   ->setLibelle("Frais de cotatisation mensuelle")
                        ->setIndice(2)
                        ->setContent($faker->sentence());
        $manager->persist($catPaiement2);
        $catPaiements[] = $catPaiement2;

        //Gestion des categories de membres
        $categories = [];
        $categorie = new CatMember();
        $categorie2 = new CatMember();

        $categorie      ->setLibelle("Personne physique")
                        ->setIndice(1)
                        ->setContent($faker->sentence());                        
        $manager->persist($categorie);
        $categories[] = $categorie;

        $categorie2     ->setLibelle("Personne morale")
                        ->setIndice(2)
                        ->setContent($faker->sentence());
        $manager->persist($categorie2);
        $categories[] = $categorie2;

        //Gestion des provinces
        $provinces = [];
        $province = new Province();
        $province2 = new Province();

        $province       ->setLibelle("Kinshasa")
                        ->setContent($faker->sentence());                        
        $manager->persist($province);
        $provinces[] = $province;

        $province2      ->setLibelle("Maniema")
                        ->setContent($faker->sentence());
        $manager->persist($province2);
        $provinces[] = $province2;

        //Gestion des communes
        $communes = [];
        $commune = new Commune();
        $commune2 = new Commune();

        $commune        ->setLibelle("Limete")
                        ->setContent($faker->sentence());                        
        $manager->persist($commune);
        $communes[] = $commune;

        $commune2       ->setLibelle("Ngaba")
                        ->setContent($faker->sentence());
        $manager->persist($commune2);
        $communes[] = $commune2;

        for($i=1; $i < 3; $i++){
            $member = new Member();
            $catMembreId = mt_rand(0, count($categories) - 1);
            $unique = strtoupper(substr(uniqid(""), 8, 6));

            $member ->setname(($catMembreId == 0)?$faker->name():$faker->company)
                    ->setLastname("")
                    ->setPrename("")
                    ->setToken($unique)
                    ->setTel1($faker->e164PhoneNumber)
                    ->setTel2($faker->e164PhoneNumber)
                    ->setAddress($faker->address)                  
                    ->setEmail( ($catMembreId == 0)?$faker->freeEmail:$faker->companyEmail)
                    ->setDescription('<p>'. join('</p><p>', $faker->paragraphs(2)).'</p>')
                    ->setDateNais($faker->dateTime())
                    ->setLieuNais($faker->city)
                    ->setSexe($Sexes[mt_rand(0, count($Sexes) - 1)])
                    ->setCategory($categories[$catMembreId])
                    ->setCommune($communes[mt_rand(0, count($communes) - 1)])
                    ->setProvince($provinces[mt_rand(0, count($provinces) - 1)])
                    ->setWebsite($faker->url);

            $manager->persist($member);

            $paiement = new Paiement();
            $PaidAt = new \DateTime('now');
            $PaidAt = (clone $PaidAt)->modify("- ".mt_rand(3,4)." days");

            $paiement   ->setAmount(($catMembreId == 0)? 10: 50 )
                        ->setPayer($member)
                        ->setCategory($catPaiements[0])
                        ->setAmountLetter(($catMembreId == 0)? "Dix dollars américains": "Cinquante dollars américains" )
                        ->setPaidAt($PaidAt);
            $manager->persist($paiement);

            

            for($j=0; $j < mt_rand(7, 14); $j++){
                $member_child = new Member();
                $catMembreId = mt_rand(0, count($categories) - 1);

                $unique = strtoupper(substr(uniqid(""), 7, 6));

                $member_child   ->setname(($catMembreId == 0)?$faker->name():$faker->company)
                                ->setLastname("")
                                ->setPrename("")
                                ->setToken($unique)
                                ->setTel1($faker->e164PhoneNumber)
                                ->setTel2($faker->e164PhoneNumber)
                                ->setAddress($faker->address)                  
                                ->setEmail( ($catMembreId == 0)?$faker->freeEmail:$faker->companyEmail)
                                ->setDescription('<p>'. join('</p><p>', $faker->paragraphs(2)).'</p>')
                                ->setDateNais($faker->dateTime())
                                ->setLieuNais($faker->city)
                                ->setSexe($Sexes[mt_rand(0, count($Sexes) - 1)])
                                ->setCategory($categories[$catMembreId])
                                ->setCommune($communes[mt_rand(0, count($communes) - 1)])
                                ->setProvince($provinces[mt_rand(0, count($provinces) - 1)])
                                ->setWebsite($faker->url)
                                ->setParrain($member);
    
                $manager->persist($member_child);
                $paiement = new Paiement();
                $paiement   ->setAmount(($catMembreId == 0)? 10: 50 )
                            ->setPayer($member_child)
                            ->setCategory($catPaiements[0])
                            ->setAmountLetter(($catMembreId == 0)? "Dix dollars américains": "Cinquante dollars américains" )
                            ->setPaidAt(new \DateTime('now'));
                $manager->persist($paiement);

                $bonus = new Bonus();
                $bonus              ->setBeneficiary($member_child->getParrain())
                                    ->setAmount($paiement->getAmount() * 10 /100)
                                    ->setDonor($paiement)
                                    ->setPaidAt($paiement->getPaidAt());
                                    $manager->persist($bonus);

                for($k=0; $k < mt_rand(5, 8); $k++){
                    $member_child2 = new Member();
                    $catMembreId = mt_rand(0, count($categories) - 1);
    
                    $unique = strtoupper(substr(uniqid(""), 7, 6));
    
                    $member_child2   ->setname(($catMembreId == 0)?$faker->name():$faker->company)
                                    ->setLastname("")
                                    ->setPrename("")
                                    ->setToken($unique)
                                    ->setTel1($faker->e164PhoneNumber)
                                    ->setTel2($faker->e164PhoneNumber)
                                    ->setAddress($faker->address)                  
                                    ->setEmail( ($catMembreId == 0)?$faker->freeEmail:$faker->companyEmail)
                                    ->setDescription('<p>'. join('</p><p>', $faker->paragraphs(2)).'</p>')
                                    ->setDateNais($faker->dateTime())
                                    ->setLieuNais($faker->city)
                                    ->setSexe($Sexes[mt_rand(0, count($Sexes) - 1)])
                                    ->setCategory($categories[$catMembreId])
                                    ->setCommune($communes[mt_rand(0, count($communes) - 1)])
                                    ->setProvince($provinces[mt_rand(0, count($provinces) - 1)])
                                    ->setWebsite($faker->url)
                                    ->setParrain($member_child);
        
                    $manager->persist($member_child2);
                    $paiement = new Paiement();
                    $PaidAt = new \DateTime('now');
                    $PaidAt = (clone $PaidAt)->modify("- ".mt_rand(1,3)." days");

                    $paiement   ->setAmount(($catMembreId == 0)? 10: 50 )
                                ->setPayer($member_child2)
                                ->setCategory($catPaiements[0])
                                ->setAmountLetter(($catMembreId == 0)? "Dix dollars américains": "Cinquante dollars américains" )
                                ->setPaidAt($PaidAt);
                    $manager->persist($paiement);
                    
                    $bonus = new Bonus();
                    $bonus              ->setBeneficiary($member_child->getParrain())
                                        ->setAmount($paiement->getAmount() * 5 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $manager->persist($bonus);

                    $bonus = new Bonus();
                    $bonus              ->setBeneficiary($member_child)
                                        ->setAmount($paiement->getAmount() * 10 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $manager->persist($bonus);
    
                    
                }
                
            }
        }

        $manager->flush();
    }
}
