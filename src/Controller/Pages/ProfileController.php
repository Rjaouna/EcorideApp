<?php // src/Controller/ProfileController.php
namespace App\Controller\Pages;

use App\Repository\CouvoiturageRepository;
use App\Repository\VoitureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
	#[Route('/profil', name: 'app_profile')]
	public function index(VoitureRepository $voitureRepository): Response
	{

		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$user = $this->getUser();
		$participations = $user->getCouvoituragesparticipe();


		$voitures = $voitureRepository->findBy(
			['user' => $user],
		);

		return $this->render('pages/profile/index.html.twig', ['voitures' => $voitures, 'participations' => $participations]);
	}
}
