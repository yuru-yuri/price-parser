<?php

namespace App\Bundles\Backend\Controller;


use App\Bundles\Backend\Form\UserType;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin/store")
 */
class StoreController extends Controller
{

    /**
     * @Route("/", name="store_backend", methods="get")
     */
    public function index(): Response
    {
        return $this->render('@AppBackend/store/index.html.twig');
    }

    /**
     * @Route("/statistic", name="store_statistic_backend", methods="get")
     */
    public function statistic(): Response
    {
        return $this->render('@AppBackend/store/statistic.html.twig');
    }

}
