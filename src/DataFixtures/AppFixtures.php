<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\Sexe;
use App\Entity\User;
use App\Entity\Bonus;
use App\Entity\Member;
use App\Entity\Commune;
use App\Entity\Paiement;
use App\Entity\Province;
use App\Entity\CatMember;
use App\Entity\CatPaiement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); 
        // Gestion des rôles
        $adminRole = new Role();
        $adminRole   ->setLibelle("ROLE_ADMIN")
                ->setDescription($faker->sentence());        
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser
                ->setLastName("Admin")
                ->setFirstName("*")
                ->setEmail("admin@gmail.com")
                ->setPicture("https://komptapp.herokuapp.com/images/logo.png")
                ->setHash($this->encoder->encodePassword($adminUser, '12345678'))
                ->setDescription('<p>'. join('</p><p>', $faker->paragraphs(3)).'</p>')
                ->setState(true)
                ->setLocal(false)
                ->addRole($adminRole)
                ;
        $manager->persist($adminUser);
        // Gestion des utilisateurs
        $users = [];
        for($i = 0; $i < 5 ; $i++){
            $user = new User();

            $genre = $faker->randomElement(['male', 'female']);
            $picture = "https://randomuser.me/api/portraits/";
            $pictureId  = $faker->numberBetween(1, 99). ".jpg";

            $picture .= ($genre == 'male' ? "men/" : "women/").$pictureId;

            $psw = $this->encoder->encodePassword($user, '123456');

            $user   -> setEmail($faker->email)
                    -> setFirstName($faker->firstName())
                    -> setLastName($faker->lastName())
                    -> setPicture($picture)
                    -> setHash($psw)
                    -> setState(true)
                    -> setDescription($faker->sentence(10));

            $manager->persist($user);
            $users [] = $user;
        }

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


        $ancentre = new Member();
        $catMembreId = 1;
        $unique = strtoupper(substr(uniqid(""), 8, 6));

        $ancentre ->setname("GROUPE DE NEHEMIE POUR LE DEVELOPPEMENT COMM.")
                ->setLastname("(G.N.D.C)")
                ->setPrename("")
                ->setToken($unique)
                ->setTel1($faker->e164PhoneNumber)
                ->setTel2($faker->e164PhoneNumber)
                ->setAddress($faker->address)                  
                ->setEmail( ($catMembreId == 0)?$faker->freeEmail:$faker->companyEmail)
                ->setDescription('<p>C est une organisation non gouvernemenatle pour le développement communautaire, implantée à Kinshasa, capitale de 
                la République Démocratique du Congo.</p>')
                ->setDateNais($faker->dateTime())
                ->setLieuNais("Kinshasa")
                ->setSexe($Sexes[mt_rand(0, count($Sexes) - 1)])
                ->setCategory($categories[1])
                ->setCommune($communes[mt_rand(0, count($communes) - 1)])
                ->setProvince($provinces[mt_rand(0, count($provinces) - 1)])
                ->setWebsite($faker->url)
                ->setUser($users[mt_rand(0, count($users) - 1)]);

        $manager->persist($ancentre);

        $paiement = new Paiement();
        $PaidAt = new \DateTime('now');
        $PaidAt = (clone $PaidAt)->modify("- 5 days");
        $paiement   ->setAmount(($catMembreId == 0)? 10: 50 )
                    ->setPayer($ancentre)
                    ->setCategory($catPaiements[0])
                    ->setAmountLetter(($catMembreId == 0)? "Dix dollars américains": "Cinquante dollars américains" )
                    ->setPaidAt($PaidAt);
    $manager->persist($paiement);


        for($i=1; $i < 5; $i++){
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
                    ->setParrain($ancentre)
                    ->setUser($users[mt_rand(0, count($users) - 1)])
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

            $bonus = new Bonus();
            $bonus              ->setBeneficiary($member->getParrain())
                                ->setAmount($paiement->getAmount() * 10 /100)
                                ->setDonor($paiement)
                                ->setPaidAt($paiement->getPaidAt());
                                $manager->persist($bonus);

            

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
                                ->setParrain($member)
                                ->setUser($users[mt_rand(0, count($users) - 1)]);
    
                $manager->persist($member_child);
                $paiement = new Paiement();
                $paiement   ->setAmount(($catMembreId == 0)? 10: 50 )
                            ->setPayer($member_child)
                            ->setCategory($catPaiements[0])
                            ->setAmountLetter(($catMembreId == 0)? "Dix dollars américains": "Cinquante dollars américains" )
                            ->setPaidAt(new \DateTime('now'));
                $manager->persist($paiement);

                $bonus = new Bonus();
                $bonus              ->setBeneficiary($member_child->getParrain()->getParrain())
                                    ->setAmount($paiement->getAmount() * 5 /100)
                                    ->setDonor($paiement)
                                    ->setPaidAt($paiement->getPaidAt());
                                    $manager->persist($bonus);

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
    
                    $member_child2  ->setname(($catMembreId == 0)?$faker->name():$faker->company)
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
                                    ->setParrain($member_child)
                                    ->setUser($users[mt_rand(0, count($users) - 1)]);
        
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
