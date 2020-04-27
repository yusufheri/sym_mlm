<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminMemberController extends AbstractController
{
    /**
     * @Route("/dashboard/member", name="admin_member_index")
     */
    public function index()
    {
        return $this->render('admin/member/index.html.twig', [
            'controller_name' => 'AdminMemberController',
        ]);
    }
}
