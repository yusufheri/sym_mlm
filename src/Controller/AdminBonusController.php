<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Entity\Member;
use App\Service\Paginator;
use App\Repository\BonusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBonusController extends AbstractController
{
    /**
     * @Route("/dashboard/bonus/{page<\d+>?1}", name="admin_bonus_index")
     */
    public function index($page, Paginator $paginator)
    {
        $paginator  ->setEntityClass(Bonus::class)
                    ->setLimit(15)
                    ->setPage($page);
        $data = $paginator->getDataFromQuery(
            'SELECT m.id,m.name as beneficiary,m.token,c.libelle, SUM(b.amount) AS amount 
            FROM App\Entity\Bonus b
            JOIN b.beneficiary m
            JOIN m.category c
            WHERE b.deletedAt IS NULL
            GROUP BY m.id
            '
        );
        return $this->render('admin/bonus/index.html.twig', [
            'paginator' => $paginator,
            'data' => $data
        ]);
    }

    /**
     * @Route("/dashboard/bonus/{id}/show", name="admin_bonus_show")
     */
    public function show(Member $member,BonusRepository $bonusRepository)
    {
        //  dump($member);
        return $this->render('admin/bonus/show.html.twig', [
            'member' => $member,
        ]);
    }
}
