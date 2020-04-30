<?php

namespace App\Controller;

use App\Service\Stats;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_index")
     */
    public function index(Stats $statsService)
    {
        $stats = $statsService->getStats();

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats
        ]);
    }
}
