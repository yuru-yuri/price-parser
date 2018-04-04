<?php

namespace App\Bundles\Backend\Controller;


use App\Form\CategoryType;
use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/categories")
 */
class CategoryController extends BaseController
{

    /**
     * @Route("/", name="categories_backend")
     *
     * @return Response
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository(Category::class)->findBy(['active' => 1]);

        return $this->render('@AppBackend/categories/index.html.twig', [
            'categories' => $categories,
            'h1' => 'Categories index',
        ]);
    }

    /**
     * @param $request Request
     * @param $category Category
     *
     * @Route("/{title}-{id}", name="category_edit_backend")
     *
     * @ParamConverter("category", class="App\Entity\Category")
     *
     * @return Response
     */
    public function edit(Request $request, Category $category): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($category);
            $em->flush();
        }

        return $this->render('@AppBackend/categories/edit.html.twig', [
            'form' => $form->createView(),
            'h1' => 'Edit category',
            'category' => $category,
        ]);
    }

}