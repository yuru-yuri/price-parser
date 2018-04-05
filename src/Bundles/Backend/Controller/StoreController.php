<?php

namespace App\Bundles\Backend\Controller;

use App\Form\StoreType;
use App\Entity\Store;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/store")
 */
class StoreController extends BaseController
{

    /**
     * @Route("/", name="store_backend", methods="get")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $stores = $em->getRepository(Store::class)->findAll();

        return $this->render('@AppBackend/store/index.html.twig', [
            'stores' => $stores,
        ]);
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
     * @param array $data
     *
     * @return Response
     *
     * @Route("/{title}-{id}", name="store_edit_backend")
     * @ParamConverter("store", class="App\Entity\Store")
     */
    public function edit(Request $request, Store $store, array $data = []): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($store);
            $em->flush();
        }

        return $this->render('@AppBackend/store/edit.html.twig', $data + [
            'form' => $form->createView(),
            'h1' => 'Edit store',
            'title' => 'Edit store',
            ]);
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
        return $this->edit($request, new Store(), [
            'h1' => 'New store',
            'title' => 'New store',
        ]);
    }

}
