<?php

namespace App\Controller;

use App\Entity\CatMember;
use App\Repository\CatMemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCatMemberController extends AbstractController
{
    /**
     * @Route("/dashboard/cat_member", name="admin_cat_member")
     * 
     * @return Response
     */
    public function index(CatMemberRepository $repo)
    {
        $data = $repo->findBy(["deletedAt" => null], ["libelle" => "ASC"]);
        
        return $this->render('admin/cat_member/index.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * Permet d'enregistrer la nouvelle catégorie de membre
     *
     * @Route("/dashboard/cat_member/new", name="admin_cat_member_new")
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager){
        $libelle = $request->get('_libelle');
        $content = $request->get('_content');

        $catMember = new CatMember();
        $catMember->setLibelle($libelle)
                    ->setContent($content);

        if(!empty(trim($catMember->getLibelle()))){
            $manager->persist($catMember);
            $manager->flush();

            $this->addFlash(
                "success",
                "La catégorie <b>".$libelle."</b> a été enregistrée avec succès"
            );
        }
        

        return $this->redirectToRoute('admin_cat_member');
    }

    /**
     * Permet de supprimer une catégorie
     * 
     * @Route("/dashboard/cat_member/{id}/delete", name="admin_cat_member_delete")
     *
     * @return void
     */
    public function delete(CatMember $catMember, EntityManagerInterface $manager){
        
        $libelle = $catMember->getLibelle();
        $catMember->setDeletedAt(new \DateTime());
        
        if(!empty(trim($catMember->getLibelle()))){
            $manager->persist($catMember);
            $manager->flush();

            $this->addFlash(
                "success",
                "La catégorie <b>".$libelle."</b> a été supprimée avec succès"
            );
        }
        return $this->redirectToRoute('admin_cat_member');
    }
}
