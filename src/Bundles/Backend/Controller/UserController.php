<?php

namespace App\Bundles\Backend\Controller;

use App\Form\UserType;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends BaseController
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
        $form
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Creator' => 'ROLE_CREATOR',
                    'Moderator' => 'ROLE_MODERATOR',
                    'Admin' => 'ROLE_ADMIN'
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'required' => false,
                'data_class' => null,
            ])
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var $avatar UploadedFile */
            $avatar = $user->getAvatar();
            if ($avatar)
            {
                $uploadService = $this->get('file.upload.service');
                $directory = $this->getParameter('images_directory');

                $fullName = $uploadService->uploadFile($directory, $avatar);

                $user->setAvatar($fullName);
            }

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
     * @Route("/{login}-{id}/", name="user_view_backend")
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
