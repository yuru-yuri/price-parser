<?php

namespace App\Bundles\Backend\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/profile")
 */
class ProfileController extends BaseController
{
    /**
     * @Route("/", name="profile_backend")
     */
    public function index(Request $request)
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();
        $oldAvatar = $user->getAvatar();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form
            ->add('virtualAvatar', FileType::class, [
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
            $avatar = $user->getVirtualAvatar();
            if (!$form->get('virtualAvatar')->getErrors()->count() && $avatar)
            {
                $uploadService = $this->get('file.upload.service');
                $fullName = $uploadService->uploadFile($avatar);
                $user->setAvatar($fullName);
            }
            else
            {
                $user->setAvatar($oldAvatar);
            }

            $em->persist($user);
            $em->flush();
        }

        return $this->render('@AppBackend/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'h1' => 'Edit profile',
        ]);
    }

}
