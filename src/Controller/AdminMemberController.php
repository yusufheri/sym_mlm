<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Entity\Member;
use App\Entity\Paiement;
use App\Form\SimpleMemberType;
use App\Form\AdvanceMemberType;
use App\Repository\MemberRepository;
use App\Repository\CatMemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMemberController extends AbstractController
{
    /**
     * @Route("/dashboard/member/{query?}", name="admin_member_index")
     * 
     * @return Response
     */
    public function index(MemberRepository $repo, EntityManagerInterface $manager, $query)
    {

        if($query){
            $title = "Les noms de membres commençant par: <b>".$query."</b>";
            $physiques =  $manager->createQuery(
                "SELECT m.name,m.lastname,m.prename,m.createdAt,m.picture,m.id,m.tel1,m.address
                FROM App\Entity\member m
                JOIN m.category c
                WHERE c.indice = 1 AND m.deletedAt is null AND m.name like '".$query."%'
                ORDER BY m.name ASC"
            )->getResult();
    
            $morales =  $manager->createQuery(
                "SELECT m.name,m.lastname,m.prename,m.createdAt,m.picture,m.id,m.tel1,m.address
                FROM App\Entity\member m
                JOIN m.category c
                WHERE c.indice = 2 AND m.deletedAt is null AND  m.name like '".$query."%'
                ORDER BY m.name ASC"
            )->getResult();
        } else {
            $title = 'Nos membres';
            $physiques =  $manager->createQuery(
                "SELECT m.name,m.lastname,m.prename,m.createdAt,m.picture,m.id,m.tel1,m.address
                FROM App\Entity\member m
                JOIN m.category c
                WHERE c.indice = 1 AND m.deletedAt is null
                ORDER BY m.name ASC"
            )->getResult();
    
            $morales =  $manager->createQuery(
                "SELECT m.name,m.lastname,m.prename,m.createdAt,m.picture,m.id,m.tel1,m.address
                FROM App\Entity\member m
                JOIN m.category c
                WHERE c.indice = 2 AND m.deletedAt is null
                ORDER BY m.name ASC"
            )->getResult();
        }   

       
        return $this->render('admin/member/index.html.twig', [
            'members' => compact('physiques', 'morales'),
            'title' => $title
        ]);
    }

    /**
     * @Route("/dashboard/member/show/{id?}", name="admin_member_show")
     * 
     * @return Response
     */
    public function show(Member $member){
        return $this->render('admin/member/show.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * @Route("/dashboard/new/member", name="admin_member_new")
     * 
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManagerInterface, 
    CatMemberRepository $catMemberRepository, MemberRepository $memberRepository){
        $id = $request->query->get("id");
        $title = "Personne physique";
        $verite = false;
        $uniqid = "";

        $member = new Member();
       
        if($id == 1 || $id == 2 ){            
           
            while ($verite == false) {
                $uniqid =strtoupper(substr(uniqid(""), 2, 6));
                $members = $memberRepository->findBy(["token" => $uniqid]);
                if (count($members) < 1) {$verite = true;}
            }   

            $member->setCategory($catMemberRepository->findOneBy(["indice" => $id]))
                    ->setToken($uniqid);
           

            $form =($id == 1)? $this->createForm(SimpleMemberType::class,$member):$this->createForm(AdvanceMemberType::class,$member);
            $title = ($id == 1)?$title:"Personne morale";
           
           
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
               
                $user = $this->getUser();
                $member->setUser($user);

                $entityManagerInterface->persist($member);

                $amount =($id == 1)? 10:50;
                $amount_letter =($id == 1)? "Dix dollars américains":"Cinquante dollars américains";

                $parrain_direct = $member->getParrain();
                if (! is_null($parrain_direct)){ $parrain_indirect = $parrain_direct->getParrain(); }

                $category = $entityManagerInterface
                            ->createQuery('SELECT c FROM App\Entity\CatPaiement c WHERE c.indice = :indice AND c.deletedAt IS NULL')
                            ->setParameter("indice", 1)
                            ->setMaxResults(1)
                            ->getResult();

                $paiement = new Paiement();
                $paiement   ->setAmount($amount)
                            ->setPaidAt(new \DateTime())
                            ->setCategory($category[0])
                            ->setPayer($member)
                            ->setComment($amount_letter)
                            ->setUser($user)
                            ->setAmountLetter($amount_letter);
                $entityManagerInterface->persist($paiement);
                //  dump($paiement);
                
                $bonus = new Bonus();
                if($parrain_direct  instanceof Member) {
                    $bonus              ->setBeneficiary($parrain_direct)
                                        ->setAmount($paiement->getAmount() * 10 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $entityManagerInterface->persist($bonus);
                    //  dump($bonus);
                }
                
                $bonus_indirect = new Bonus();
                if ($parrain_indirect instanceof Member){
                    $bonus_indirect ->setBeneficiary($parrain_indirect)
                                    ->setAmount($paiement->getAmount() * 5 /100)
                                    ->setDonor($paiement)
                                    ->setPaidAt($paiement->getPaidAt());
                    $entityManagerInterface->persist($bonus_indirect);
                    //  dump($bonus_indirect);
                }


                $entityManagerInterface->flush();

                $this->addFlash(
                    "success",
                    "Le nouveau membre <b>". $member->getname() ."</b> est enregistré avec succès dans la base de données"
                ); 

            }

            return $this->render('admin/member/new.html.twig', [
                'form' => $form->createView(),
                'title' => $title,
                'member' => $member
            ]);            
        }else {
            return $this->render('admin/member/new.html.twig', ['title' => $title]);
        }
       
    }
}
