<?php

namespace App\Controller;

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
        return $this->render('admin/member/new.html.twig', [
            'controller_name' => 'AdminMemberController',
        ]);
    }
}
