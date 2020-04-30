<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class Paginator{

    private $entityClass;
    private $limit = 10;
    private $currentPage;
    private $route;
    private $templatePath;

    private $manager;
    private $twig;

    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $request, $templatePath)
    {
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->twig = $twig;
        $this->manager = $manager;
        $this->templatePath = $templatePath;
    }

    public function display(){
        return $this->twig->display($this->templatePath, [
            'page'  => $this->currentPage,
            'pages' => $this->getPages(),
            'start' => $this->getStart(),
            'route' => $this->route
        ]);
    }

    public function getTemplatePath(){
        return $this->templatePath;
    }

    public function setTemplatePath($templatePath){
        $this->templatePath = $templatePath;

        return $this;
    }

    public function getRoute(){
        return $this->route;
    }

    public function setRoute($route){
        $this->route = $route;

        return $this;
    }

    public function getPages(){
        $total = count($this->manager->getRepository($this->entityClass)->findAll());
        return ceil($total / $this->limit);
    }

    public function getStart(){
        return ($this->currentPage - 1) * $this->limit;
    }

    public function getData($criteria = [], $order = []){

        $offset = ($this->currentPage - 1)*$this->limit;

        $data = $this->manager->getRepository($this->entityClass)->findBy($criteria, $order, $this->limit, $offset);

        return $data;
    }

    public function getDataFromQuery($query){

        $data = $this->manager->createQuery($query)->getResult();

        return $data;
    }

    public function getPage(){
        return $this->currentPage;
    }

    public function setPage($page){
        $this->currentPage = $page;

        return $this;
    }

    public function getLimit(){
        return $this->limit;
    }

    public function setLimit($limit){
        $this->limit = $limit;

        return $this;
    }

    public function getEntityClass(){
        return $this->entityClass;
    }

    public function setEntityClass($entityClass){
        $this->entityClass = $entityClass;

        return $this;
    }
}