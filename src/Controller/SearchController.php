<?php

namespace App\Controller;

use App\Repository\MemberRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchMember(){        

        $form = $this->createFormBuilder(null)
                    ->add('query', TextType::class)
                    ->getForm();

        return $this->render("search/member.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de répondre à la requête effectuée lors de la recherche d un membre
     *
     * @Route("Dashboard/member/handleSearch/{_query?}", name="handle_request", methods={"POST", "GET"})
     * @param MemberRepository $memberRepository
     * @param String $_query
     * @return JsonResponse
     */
    public function handleSearchMember(MemberRepository $memberRepository, $_query){

        if($_query){
            $data = $memberRepository->findByName($_query);
        } else{
            $data = $memberRepository->findAll();
        }

        return $this->json($data, 200, [],['groups' => 'member:read']);
        //Setting up the normalizer
        /* $normalizers = [
            new ObjectNormalizer()
        ];

        $encoders = [
            new JsonEncoder()
        ];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($data, 'json');

        return new JsonResponse($data, 200, [], true); */
    }
}
