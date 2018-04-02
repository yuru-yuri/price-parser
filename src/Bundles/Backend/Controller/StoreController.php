<?php

namespace App\Bundles\Backend\Controller;


use App\Bundles\Backend\Form\StoreType;
use App\Bundles\Backend\Form\UserType;
use App\Entity\Store;
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

    /**
     * @param Request $request
     * @param Store $store
     *
     * @return Response
     *
     * @Route("/{title}-{id}", name="store_edit_backend")
     * @ParamConverter("store", class="App\Entity\Store")
     */
    public function edit(Request $request, Store $store): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em->persist($store);
            $em->flush();
        }

        return $this->render('@AppBackend/store/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $request Request
     *
     * @return Response
     *
     * @Route("/new", name="store_create_backend")
     */
    public function create(Request $request): Response
    {
        return $this->edit($request, new Store());
    }

}
