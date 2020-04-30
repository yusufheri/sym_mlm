<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Entity\Member;
use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use App\Service\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPaiementController extends AbstractController
{
    /**
     * @Route("/admin/paiement/{page<\d+>?1}", name="admin_paiement_index")
     * 
     * @return Response
     */
    public function index(PaiementRepository $paiementRepository,$page, Paginator $paginator)
    {
        $paginator  ->setEntityClass(Paiement::class)
                    ->setLimit(15)
                    ->setPage($page);
        return $this->render('admin/paiement/index.html.twig', [
            'paginator' => $paginator,
            //  'paiements' => $paiementRepository->findBy(["deletedAt" => null],["paidAt" => "DESC"]),
        ]);
    }

    /**
     * @Route("/admin/paiement/new", name="admin_paiement_new")
     * 
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManagerInterface){
        $paiement = new Paiement();

        $form = $this->createForm(PaiementType::class, $paiement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManagerInterface->persist($paiement);           

            $category_paiement = $paiement->getCategory()->getIndice();

            $donor = $paiement->getPayer();
            $parrain_direct = $donor->getParrain();
            $parrain_indirect = null;

            if ($parrain_direct  instanceof Member) {
                $parrain_indirect = $parrain_direct->getParrain();
            }
            
            $bonus = new Bonus();
            $bonus_indirect = new Bonus();

            if( $category_paiement == 1){ //Frais d'adhésion  

                if($parrain_direct  instanceof Member) {
                    $bonus              ->setBeneficiary($parrain_direct)
                                        ->setAmount($paiement->getAmount() * 10 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $entityManagerInterface->persist($bonus);
                }
                
                if ($parrain_indirect instanceof Member){
                    $bonus_indirect     ->setBeneficiary($parrain_indirect)
                                        ->setAmount($paiement->getAmount() * 5 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $entityManagerInterface->persist($bonus_indirect);
                }

            }   else if( $category_paiement == 2){ //Frais de cotisation mensuelle
                if ($parrain_direct instanceof Member) {
                    $bonus              ->setBeneficiary($parrain_direct)
                                        ->setAmount($paiement->getAmount() * 10 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $entityManagerInterface->persist($bonus);
                }

                if($parrain_indirect instanceof Member){
                    $bonus_indirect     ->setBeneficiary($parrain_indirect)
                                        ->setAmount($paiement->getAmount() * 10 /100)
                                        ->setDonor($paiement)
                                        ->setPaidAt($paiement->getPaidAt());
                    $entityManagerInterface->persist($bonus_indirect);
                }

            }
            $entityManagerInterface->flush();
            $this->addFlash(
                "success",
                "Paiement enregistré avec succès"
            );
            //  $this->redirectToRoute('admin_paiement_index');
            return $this->redirect($request->getUri());
        }

        return $this->render('admin/paiement/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/paiement/{id}/edit", name="admin_paiement_edit")
     * 
     * @return Response
     */
    public function edit(Paiement $paiement){

    }

    /**
     * @Route("/admin/paiement/{id}/delete", name="admin_paiement_delete")
     * 
     * @return Response
     */
    public function delete(Paiement $paiement, PaiementRepository $paiementRepository){
        return $this->render('admin/paiement/index.html.twig', [
            'paiements' => $paiementRepository->findBy(["deletedAt" => null]),
        ]);
    }


}
