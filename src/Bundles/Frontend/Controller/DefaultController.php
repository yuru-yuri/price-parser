<?php

namespace App\Bundles\Frontend\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends BaseController
{

    /**
     * @Route("/", name="index", methods="get")
     */
    public function index()
    {
        return $this->render('@AppFrontend/default/index.html.twig');
    }

    /**
     * @Route("/shop/{id}", name="shop", methods="get", requirements={"id"="\d+"})
     */
    public function shop($id)
    {
        return $this->render('@AppFrontend/default/shop.html.twig', ['id' => $id]);
    }

    /**
     * @Route("/login/", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@AppFrontend/default/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/registration/", name="registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
            ])
            ;

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('index');
        }

        return $this->render('@AppFrontend/default/register.html.twig', ['form' => $form->createView()]);
    }

}
