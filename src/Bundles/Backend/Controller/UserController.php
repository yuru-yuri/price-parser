<?php

namespace App\Bundles\Backend\Controller;


use App\Bundles\Backend\Form\UserType;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class UserController extends Controller
{

    /**
     * @Route("/", name="users_backend", methods="get")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('@AppBackend/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @Route("/{login}-{id}/edit", name="user_edit_backend")
     * @ParamConverter("user", class="App\Entity\User")
     *
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();
        }

        return $this->render('@AppBackend/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'h1' => 'Edit user',
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @Route("/{login}-{id}", name="user_view_backend")
     * @ParamConverter("user", class="App\Entity\User")
     *
     * @return Response
     */
    public function view(Request $request, User $user): Response
    {
        return $this->render('@AppBackend/user/view.html.twig', [
            'user' => $user,
            'h1' => 'View user',
        ]);
    }

}
