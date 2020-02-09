<?php

namespace App\Controller;

use App\Entity\Galaxy;
use App\Entity\Star;
use App\Form\Type\StarType;
use App\Repository\StarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/star")
 */
class StarController extends AbstractController
{

    /**
     * @Route("/list", name="stars_list")
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
     * @Route("/galaxy/{id}/list", name="galaxy_stars_list")
     */
    public function starsListBygalaxy(Galaxy $galaxy)
    {
        /** @var StarRepository */
        $starsRepository = $this->getDoctrine()->getRepository(Star::class);
        $stars = $starsRepository->findBy(
            ['galaxy' => $galaxy]
        );

        return $this->render(
            'stars/stars_by_galaxy.html.twig',
            [
                'stars'   => $stars,
                'galaxy'  => $galaxy
            ]
        );
    }

       /**
     * @Route("/view/{id}", name="star_view")
     */
    public function starView(Star $star) {

        return $this->render('stars/view.html.twig', [
            'star' => $star
        ]);
    }

    /**
     * @Route("/create", name="star_create")
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
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
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
     * @Route("/{id}/update", name="star_update")
     */
    public function starUpdate(Request $request, Star $star)
    {
        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
     
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "L'étoile a bien été modifiée");

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
     * @Route("/{id}/delete", name="star_delete")
     */
    public function starDelete(Star $star)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($star);
        $manager->flush();

        $this->addFlash("success", "L'étoile a bien été supprimée");

        return $this->redirectToRoute('stars_list');
    }
}
