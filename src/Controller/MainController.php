<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Repository\PlanetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Zenstruck\Collection\Grid;
use Zenstruck\Collection\Symfony\Attributes\ForDefinition;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        #[ForDefinition(Voyage::class)] Grid $voyageGrid,
        PlanetRepository $planetRepository,
    ): Response
    {
        return $this->render('main/homepage.html.twig', [
            'voyages' => $voyageGrid,
            'planets' => $planetRepository->findAll(),
        ]);
    }
}
