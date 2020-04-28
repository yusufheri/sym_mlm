<?php

namespace App\Controller;

use App\Entity\CatPaiement;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CatPaiementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCatPaiementController extends AbstractController
{
    /**
     * @Route("/dashboard/cat_paiement", name="admin_cat_paiement")
     * 
     * @return Response
     */
    public function index(CatPaiementRepository $repo)
    {
        $data = $repo->findBy(["deletedAt" => null], ["libelle" => "ASC"]);
       
        return $this->render('admin/cat_paiement/index.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * Permet d'enregistrer la nouvelle catégorie de membre
     *
     * @Route("/dashboard/cat_paiement/new", name="admin_cat_paiement_new")
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager){
        $libelle = $request->get('_libelle');
        $content = $request->get('_content');

        $catPaiement = new CatPaiement();
        $catPaiement->setLibelle($libelle)
                    ->setContent($content);

        if(!empty(trim($catPaiement->getLibelle()))){
            $manager->persist($catPaiement);
            $manager->flush();

            $this->addFlash(
                "success",
                "Le type de paiment :  <b>".$libelle."</b> a été enregistré avec succès"
            );
        }
        

        return $this->redirectToRoute('admin_cat_paiement');
    }

    /**
     * Permet de supprimer une catégorie
     * 
     * @Route("/dashboard/cat_paiement/{id}/delete", name="admin_cat_paiement_delete")
     *
     * @return void
     */
    public function delete(CatPaiement $catPaiement, EntityManagerInterface $manager){
        
        $libelle = $catPaiement->getLibelle();
        $catPaiement->setDeteledAt(new \DateTime());
        
        if(!empty(trim($catPaiement->getLibelle()))){
            $manager->persist($catPaiement);
            $manager->flush();

            $this->addFlash(
                "success",
                " <b>".$libelle."</b> a été supprimé avec succès"
            );
        }
        return $this->redirectToRoute('admin_cat_paiement');
    }
}
