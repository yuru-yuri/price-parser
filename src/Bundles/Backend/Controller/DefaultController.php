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
 * @Route("/admin")
 */
class DefaultController extends Controller
{

    /**
     * Matches /
     *
     * @Route("/", name="index_backend", methods="get")
     */
    public function index(): Response
    {
        return $this->render('@AppBackend/default/index.html.twig');
    }

    /**
     * Matches /users
     *
     * @Route("/users", name="users_backend", methods="get")
     */
    public function dashboard(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('@AppBackend/default/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Matches /users
     *
     * @param Request $request
     * @param User $user
     *
     * @Route("/users/edit/{id}", name="editUser_backend")
     * @ParamConverter("user", class="App\Entity\User")
     *
     * @return Response
     */
    public function editUser(Request $request, User $user): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em->persist($user);
            $em->flush();
        }

        return $this->render('@AppBackend/default/editUser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}
