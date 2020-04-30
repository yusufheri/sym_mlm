<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Repository\BonusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBonusController extends AbstractController
{
    /**
     * @Route("/admin/bonus", name="admin_bonus_index")
     */
    public function index(BonusRepository $bonusRepository, EntityManagerInterface $manager)
    {
        $data = $manager->createQuery(

        );
        return $this->render('admin/bonus/index.html.twig', [
            'bonuses' => $bonusRepository->findBy(["deletedAt" => null]),
        ]);
    }

    /**
     * @Route("/admin/bonus/{id}/show", name="admin_bonus_show")
     */
    public function show(Bonus $bonus)
    {
        return $this->render('admin/bonus/show.html.twig', [
            'controller_name' => 'AdminBonusController',
        ]);
    }
}
