<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Stats{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getStats(){

        $members_physiques = $this->getMembersPhysiquesCount();
        $members_morales = $this->getMembersMoralesCount();
        $members = $members_physiques + $members_morales;

        $currentMonth = $this->getAdhesionCurrentMonth();
        $currentpaiement = $this->getSumCaisseCurrentMonth();
        $currentWeekPaiement = $this->getCurrentWeekPaiement();

        return compact('members_physiques', 'members_morales', 'members',
         'currentMonth','currentpaiement', 'currentWeekPaiement');
    }

    public function getCurrentWeekPaiement(){
        $monday = date('Y-m-d',strtotime('monday this week'));
        $sunday = date('Y-m-d',strtotime('sunday this week'));

       
        $data =  $this->manager->createQuery(
            'SELECT SUM(p.amount) as amount, p.paidAt as day FROM App\Entity\Paiement p
             WHERE (p.paidAt BETWEEN :monday AND :sunday) AND  (p.deletedAt IS NULL)
             GROUP BY p.paidAt
             ORDER BY p.paidAt')
             ->setParameter("monday", $monday)
             ->setParameter("sunday", $sunday)
            ->getResult();
        
         dump($data);

        return $data;
    }

    public function getAdhesionCurrentMonth(){
        $currentMonth = date("Y-m-01");
        return $this->manager->createQuery( //WHERE m.createdAt >= ".$currentMonth." AND m.deletedAt = null
            'SELECT COUNT(m) FROM App\Entity\Member m 
            WHERE m.createdAt >= :current AND m.deletedAt IS NULL')
            ->setParameter('current', $currentMonth)
            ->getSingleScalarResult();
    }

    public function getMembersPhysiquesCount(){
        return $this->manager->createQuery(
            'SELECT COUNT(m) FROM App\Entity\Member m 
             JOIN m.category c 
             WHERE c.indice = :val AND m.deletedAt IS NULL')
            ->setParameter('val', 1)
            ->getSingleScalarResult(); 
    }

    public function getMembersMoralesCount(){
        return $this->manager->createQuery(
            'SELECT COUNT(m) FROM App\Entity\Member m 
             JOIN m.category c 
             WHERE c.indice = :val AND m.deletedAt IS NULL')
            ->setParameter('val', 2)
            ->getSingleScalarResult(); 
    }

    public function getSumCaisseCurrentMonth(){
        $currentMonth = date("Y-m-01");
        return $this->manager->createQuery(
            'SELECT SUM(p.amount) FROM App\Entity\Paiement p
             WHERE p.paidAt >= :current AND p.deletedAt IS NULL')
            ->setParameter('current', $currentMonth)
            ->getSingleScalarResult();
    }

    public function getAVGComments($orderBy = 'DESC', $limit = 5){
        
       return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture 
            FROM App\Entity\Comment c
            JOIN c.ad a
            JOIN c.author u
            GROUP BY a
            ORDER BY note '.$orderBy
        )
        ->setMaxResults($limit)
        ->getResult();
    }

}