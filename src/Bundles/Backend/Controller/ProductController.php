<?php

namespace App\Bundles\Backend\Controller;

use App\Form\ProductType;
use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/products")
 */
class ProductController extends BaseController
{

    /**
     * @Route("/", name="products_backend")
     *
     * @return Response
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findBy(['active' => 1]);

        return $this->render('@AppBackend/products/index.html.twig', [
            'h1' => 'Products index',
            'products' => $products,
        ]);
    }

    /**
     * @param $request Request
     * @param $product Product
     *
     * @Route("/{title}-{id}", name="product_edit_backend")
     *
     * @ParamConverter("store", class="App\Entity\Product")
     *
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($product);
            $em->flush();
        }

        return $this->render('@AppBackend/products/edit.html.twig', [
            'h1' => 'Edit product',
            'form' => $form->createView(),
        ]);
    }

}