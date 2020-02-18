<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Galaxy;
use App\Entity\Star;
use App\Form\Type\StarType;
use App\Repository\StarRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/star")
 * 
 */
class StarController extends AbstractController
{

    public function index()
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $adminEmail = $this->getParameter('app.admin_email');

        // ...
    }

    /**
     * @Route("/list", name="stars_list", methods={"GET","POST"})
     */
    public function starsList()
    {
        /** @var StarRepository */
        $starsRepository = $this->getDoctrine()->getRepository(Star::class);
        $stars = $starsRepository->findAll();

        return $this->render(
            'stars/stars.html.twig',
            [
                'stars'   => $stars,
            ]
        );
    }

     /**
     * @Route("/galaxy/{id}/list", name="galaxy_stars_list", methods={"GET","POST"})
     */
    public function starsListBygalaxy(Galaxy $galaxy)
    {
        /** @var StarRepository */
        $starsRepository = $this->getDoctrine()->getRepository(Star::class);
        $stars = $starsRepository->findBy(
            ['galaxy' => $galaxy]
        );

        return $this->render(
            'stars/objects_by_galaxy.html.twig',
            [
                'stars'   => $stars,
                'galaxy'  => $galaxy
            ]
        );
    }

       /**
     * @Route("/view/{id}", name="star_view", methods={"GET","POST"})
     */
    public function starView(Star $star) {

        //$this->denyAccessUnlessGranted('view', $star);

        return $this->render('stars/view.html.twig', [
            'star' => $star
        ]);
    }

    /**
     * @Route("/create", name="star_create", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function starCreate(Request $request)
    {
        $star = new Star;
        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('brochure')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                    echo("L'image n'a pas été chargée");
                }

                $star->setBrochureFilename($newFilename);
            }

            $star = $form->getData();
            $star->setAppUser($this->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($star);
            $manager->flush();

            $this->addFlash("success", "L'étoile a bien été ajoutée");

            return $this->redirectToRoute('stars_list');
        }

        return $this->render(
            "stars/star_add.html.twig",
            [
                "formView" => $form->createView()
            ]
        );
    }

     /**
     * @Route("/{id}/update", name="star_update", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function starUpdate(Request $request, Star $star, UserRepository $userRepository)
    {
        $this->denyAccessUnlessGranted('edit', $star);

        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
     
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "L'objet a bien été modifié");

            return $this->redirectToRoute('stars_list', ['id' => $star->getId()]);
        }

        return $this->render(
            "stars/update.html.twig",
            [
                "formView" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{id}/delete", name="star_delete", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function starDelete(Star $star)
    {
        $this->denyAccessUnlessGranted('edit', $star);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($star);
        $manager->flush();

        $this->addFlash("success", "L'objet a bien été supprimé");

        return $this->redirectToRoute('stars_list');
    }
}
