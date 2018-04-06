<?php

namespace App\Bundles\Backend\Controller;

use App\Form\CategoryType;
use App\Entity\Category;
use Doctrine\Common\Collections\Criteria;
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
     * @Route("/{page}", name="categories_backend.paginate", requirements={"page"="\d+"})
     *
     * @return Response
     */
    public function index(Request $request, ?int $page=null): Response
    {
        $page = (int)$page;
        $em = $this->getDoctrine()->getManager();
        $criteria = Criteria::create();
        $criteria->setFirstResult(3)->setMaxResults(10);

        $pagesCount = 0;

        $categories = $em->getRepository(Category::class)->findBy(['active' => 1]);

        return $this->render('@AppBackend/categories/index.html.twig', [
            'categories' => $categories,
            'h1' => 'Categories index',
            'currentPage' => $page,
            'lastPage' => $pagesCount,
        ]);
    }

    /**
     * @Route("/{title}-{id}", name="category_edit_backend", requirements={"id"="\d+"})
     * @ParamConverter("category", class="App\Entity\Category")
     *
     * @param $request Request
     * @param $category Category
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
