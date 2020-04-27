<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}
