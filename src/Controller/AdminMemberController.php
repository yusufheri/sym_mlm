<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\AdvanceMemberType;
use App\Form\SimpleMemberType;
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
    public function index()
    {
        return $this->render('admin/member/index.html.twig', [
            'controller_name' => 'AdminMemberController',
        ]);
    }

    /**
     * @Route("/dashboard/member/new", name="admin_member_new")
     * 
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManagerInterface){
        $id = $request->query->get("id");
        $title = "Personne physique (Nouveau membre)";
        //  $form = null;

        $member = new Member();

        if($id == 1 || $id == 2 ){
            $form =($id == 1)? $this->createForm(SimpleMemberType::class,$member):$this->createForm(AdvanceMemberType::class,$member);
            $title = ($id == 1)?$title:"Personne morale (Nouveau membre)";

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $entityManagerInterface->persist($member);
                $entityManagerInterface->flush();

                $this->addFlash(
                    "success",
                    "Le nouveau membre est enregistré avec succès"
                );
                dump($member);
            }

            return $this->render('admin/member/new.html.twig', [
                'form' => $form->createView(),
                'title' => $title
            ]);            
        }else {
            return $this->render('admin/member/new.html.twig', ['title' => $title]);
        }
       
    }
}
