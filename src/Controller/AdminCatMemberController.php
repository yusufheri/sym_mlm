<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCatMemberController extends AbstractController
{
    /**
     * @Route("/admin/cat/member", name="admin_cat_member")
     */
    public function index()
    {
        return $this->render('admin_cat_member/index.html.twig', [
            'controller_name' => 'AdminCatMemberController',
        ]);
    }
}
