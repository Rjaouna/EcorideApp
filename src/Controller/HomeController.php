<?php

namespace App\Controller;

use App\Repository\CouvoiturageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CouvoiturageRepository $couvoiturage_repository): Response
    {
        $couvoiturages = $couvoiturage_repository->findBy(
            [],
            ['createdAt' => 'DESC'],
            4
        );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'couvoiturages' => $couvoiturages
        ]);
    }
}
