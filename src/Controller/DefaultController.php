<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    public function index()
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $adminEmail = $this->getParameter('app.admin_email');

        // ...
    }

    /**
     * @Route("/", name="homepage", methods={"GET","POST"})
     */
    public function homepage() {
 
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/test", name="test", methods={"GET","POST"})
     */
    public function testpage() {
 
        return $this->render('test.html.twig');
    }
}