<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Home extends AbstractController
{
    #[Route('/')]
    public function homePage(): Response
    {
        $blogTile = 'Le Blog de Captain Français';

        return $this->render('home.html.twig', [
            'title' => $blogTile
        ]);
    }
}
