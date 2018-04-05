<?php

namespace App\Bundles\Frontend\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends BaseController
{

    /**
     * @Route("/", name="profile")
     */
    public function index()
    {
        return $this->render('@AppFrontend/profile/index.html.twig');
    }

    /**
     * @param Request $request
     *
     * @Route("/edit", name="profile_edit")
     *
     * @return Response
     */
    public function edit(Request $request): Response
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'required' => false,
                'data_class' => null,
            ])
            ->remove('login')
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
                $extension = $avatar->guessExtension();

                do
                {
                    $fileName = $uploadService->generateName() . '.' . $extension;
                }
                while (\is_file($directory . '/' . $fileName));

                $fullName = $fileName;

                $directory .= '.' . \dirname($fileName);
                $fileName = \basename($fileName);

                $avatar->move($directory, $fileName);
                $user->setAvatar($fullName);
            }

            $em->persist($user);
            $em->flush();
        }

        return $this->render('@AppFrontend/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'h1' => 'Edit user',
        ]);
    }

}
