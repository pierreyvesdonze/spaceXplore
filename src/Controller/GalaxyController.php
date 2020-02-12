<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Galaxy;
use App\Form\Type\GalaxyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/galaxy")
 * 
 */
class GalaxyController extends AbstractController
{

    /**
     * @Route("/list", name="galaxies_list")
     */
    public function galaxiesList()
    {

        $galaxiesRepository = $this->getDoctrine()->getRepository(Galaxy::class);
        $galaxies = $galaxiesRepository->findAll();

        return $this->render(
            'galaxies/galaxies.html.twig',
            [
                'galaxies'   => $galaxies,
            ]
        );
    }

    /**
     * @Route("/create", name="galaxy_create")
     * @IsGranted("ROLE_DB_ADMIN")
     */
    public function galaxyCreate(Request $request)
    {
        $galaxy = new Galaxy;
        $form = $this->createForm(GalaxyType::class, $galaxy);
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

                $galaxy->setBrochureFilename($newFilename);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($galaxy);
            $manager->flush();

            $this->addFlash("success", "La galaxie a bien été ajoutée");

            return $this->redirectToRoute('galaxies_list');
        }

        return $this->render(
            "galaxies/galaxy_add.html.twig",
            [
                "formView" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{id}/delete", name="galaxy_delete")
     * @IsGranted("ROLE_DB_ADMIN")
     * 
     */
    public function galaxyDelete(Galaxy $galaxy)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($galaxy);
        $manager->flush();

        $this->addFlash("success", "La galaxie a bien été supprimée");

        return $this->redirectToRoute('galaxies_list');
    }
}
