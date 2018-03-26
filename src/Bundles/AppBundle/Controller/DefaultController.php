<?php

namespace App\Bundles\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /**
     * Matches /
     *
     * @Route("/", name="index_page", methods="get")
     */
    public function index()
    {
        return $this->render('default/index.twig');
    }

}
