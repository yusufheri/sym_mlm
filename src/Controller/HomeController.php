<?php

namespace App\Controller;

use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(MemberRepository $memberRepository)
    {
        $members  = $memberRepository->findBy(["deletedAt" => null],["createdAt" => "DESC", "id" => "DESC"],8);

        return $this->render('home.html.twig', [
            'members' => $members,
        ]);
    }
}
