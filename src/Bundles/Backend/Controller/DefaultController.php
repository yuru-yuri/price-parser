<?php

namespace App\Bundles\Backend\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class DefaultController extends Controller
{

    /**
     * Matches /
     *
     * @Route("/", name="index_backend", methods="get")
     */
    public function index()
    {
        return $this->render('@AppBackend/default/index.twig');
    }

}
