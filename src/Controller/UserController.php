<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Form\AppUserType;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController 
{

    public function index()
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $adminEmail = $this->getParameter('app.admin_email');

        // ...
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, RoleRepository $roleRepository): Response
    {
        $appUser = new AppUser();
        $form = $this->createForm(AppUserType::class, $appUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('plain_password')->getData();
            $encodedPassword = $encoder->encodePassword($appUser, $plainPassword);

            $appUser->setPassword($encodedPassword);

            $role = $roleRepository->findOneByRoleString('ROLE_USER');
            $appUser->setRole($role);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appUser);
            $entityManager->flush();

            $this->addFlash('success', 'Vous êtes enregistré. Vous pouvez maintenant vous connecter.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('app_user/new.html.twig', [
            'app_user' => $appUser,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/myprofile", name="app_user_profile", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function myProfile(): Response
    {
        $appUser = $this->getUser();

        return $this->render('app_user/show.html.twig', [
            'app_user' => $appUser,
        ]);
    }

}
