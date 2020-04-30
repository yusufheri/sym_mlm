<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Service\Paginator;
use App\Repository\BonusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBonusController extends AbstractController
{
    /**
     * @Route("/admin/bonus/{page<\d+>?1}", name="admin_bonus_index")
     */
    public function index(BonusRepository $bonusRepository, EntityManagerInterface $manager,$page, Paginator $paginator)
    {
        $paginator  ->setEntityClass(Bonus::class)
                    ->setLimit(15)
                    ->setPage($page);
        return $this->render('admin/bonus/index.html.twig', [
            'paginator' => $paginator,
            //  'bonuses' => $bonusRepository->findBy(["deletedAt" => null]),
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
