<?php
// src/Controller/UserModesController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserModesController extends AbstractController
{
	#[Route('/account/switch-mode', name: 'app_switch_mode', methods: ['POST'])]
	public function switchMode(Request $request, EntityManagerInterface $em, Security $security): Response
	{
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

		if (!$this->isCsrfTokenValid('switch_mode', $request->request->get('_token'))) {
			throw $this->createAccessDeniedException('Token CSRF invalide.');
		}

		/** @var User $user */
		$user   = $this->getUser();
		$roles  = $user->getRoles();
		$isDriver = \in_array('ROLE_DRIVER', $roles, true);

		// on retire uniquement les rôles "mode"
		$preserved = \array_values(\array_filter(
			$roles,
			fn(string $r) => !\in_array($r, ['ROLE_DRIVER', 'ROLE_PASSAGER'], true)
		));

		// on ajoute le nouveau rôle "mode"
		$newRoles = $isDriver
			? [...$preserved, 'ROLE_PASSAGER']
			: [...$preserved, 'ROLE_DRIVER'];

		$user->setRoles(\array_values(\array_unique($newRoles)));
		$em->flush();
		//on reconnecte l'utilisateur pour éviter la déconnexion
		$security->login($user);

		$this->addFlash('success', $isDriver ? 'Passage en mode passager.' : 'Mode conducteur activé.');
		return $this->redirectToRoute('app_profile');
	}
}
