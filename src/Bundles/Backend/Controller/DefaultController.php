<?php

namespace App\Bundles\Backend\Controller;

use App\Entity\Product;
use App\Entity\Store;
use App\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{

    /**
     * @Route("/", name="index_backend", methods="get")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $time = new \DateTime('NOW');
        $time->sub(new \DateInterval('P7D'));
        $compare = Criteria::expr()->gte('created_at', $time);
        $criteria = Criteria::create()->where($compare);

        $data = [
            'stores' => $em->getRepository(Store::class)->count(['active' => '1']),
            'products' => $em->getRepository(Product::class)->count([]),
            'products_last_week' => $em->getRepository(Product::class)->matching($criteria)->count(),
        ];

        return $this->render('@AppBackend/default/index.html.twig', $data);
    }

}
