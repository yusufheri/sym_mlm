<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\AdvanceMemberType;
use App\Form\SimpleMemberType;
use App\Repository\CatMemberRepository;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminMemberController extends AbstractController
{
    /**
     * @Route("/dashboard/member", name="admin_member_index")
     * 
     * @return Response
     */
    public function index(MemberRepository $repo, EntityManagerInterface $manager)
    {
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

        //  $physiques = $repo->findBy(["deletedAt" => null, "category.indice" => 1], ["name" => "ASC"]);
        //  $morales = $repo->findBy(["deletedAt" => null, "category.indice" => 2], ["name" => "ASC"]);
       
        return $this->render('admin/member/index.html.twig', [
            'members' => compact('physiques', 'morales'),
        ]);
    }

    /**
     * @Route("/dashboard/member/new", name="admin_member_new")
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
               
                $entityManagerInterface->persist($member);
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
