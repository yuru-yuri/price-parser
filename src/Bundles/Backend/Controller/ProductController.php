<?php

namespace App\Bundles\Backend\Controller;

use App\Form\ProductType;
use App\Entity\Product;
use Doctrine\Common\Collections\Criteria;
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
     * @Route("/{page}", name="products_backend.paginate", requirements={"page"="\d+"})
     *
     * @param $request Request
     * @param $page int|null
     *
     * @return Response
     */
    public function index(Request $request, ?int $page = null): Response
    {
        $maxProducts = 6;
        $page = $page ?? 1;

        $em = $this->getDoctrine()->getManager();
        $criteria = Criteria::create();
        $criteria->setFirstResult($maxProducts * ($page - 1))
            ->setMaxResults($maxProducts);
        $totalPages = $products = $em->getRepository(Product::class)->count([]);

        $products = $em->getRepository(Product::class)
            ->matching($criteria);

        $template = '@AppBackend/products/index.html.twig';
        if($request->isXmlHttpRequest())
        {
            $template = '@AppBackend/products/index_json.html.twig';
        }

        return $this->render($template, [
            'h1' => 'Products index',
            'products' => $products,
            'page' => $page,
            'totalPages' => \ceil($totalPages / $maxProducts),
        ]);
    }

    /**
     * @Route("/{title}-{id}/", name="product_edit_backend", methods={"GET","POST","PUT"})
     * @ParamConverter("product", class="App\Entity\Product")
     *
     * @param $request Request
     * @param $product Product
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

    /**
     * @Route("/{title}-{id}", methods={"post"}, name="product_active_change_backend", methods={"OPTIONS"})
     *
     * @param Request $request
     * @param Product $product
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changeActive(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $active = !$product->getActive();
        $product->setActive($active);
        $em->persist($product);
        $em->flush();

        return $this->json([]);
    }

    /**
     * @Route("/{title}-{id}/", name="product_delete_backend", methods={"DELETE"})
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Response
     */
    public function delete(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

}
