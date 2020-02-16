<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Form\AppUserAdminType;
use App\Form\AppUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_SUPER_ADMIN")
 * @Route("/admin/user")
 */
class UserAdminController extends AbstractController {
    
    /**
     * @Route("/{id}/edit", name="app_admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AppUser $appUser): Response
    {
        $form = $this->createForm(AppUserAdminType::class, $appUser);

        $this->denyAccessUnlessGranted('edit', $appUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->render('app_user/edit.html.twig', [
            'app_user' => $appUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AppUser $appUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }

      /**
     * @Route("/show/{id}", name="app_admin_user_show", methods={"GET"})
     */
    public function show(AppUser $appUser)
    {
        return $this->render('app_user/show.html.twig', [
            'app_user' => $appUser,
        ]);
    }
    
    /**
     * @Route("/", name="app_admin_user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $appUsers = $this->getDoctrine()
            ->getRepository(AppUser::class)
            ->findAll();

        return $this->render('app_user/index.html.twig', [
            'app_users' => $appUsers,
        ]);
    }
}