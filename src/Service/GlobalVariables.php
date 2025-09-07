<?php

namespace App\Service;

use App\Entity\ContactMessage;
use App\Repository\ContactMessageRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
	private ContactMessageRepository $contactMessageRepository;
	private Security $security;

	public function __construct(
		ContactMessageRepository $contactMessageRepository,
		Security $security
	) {
		$this->contactMessageRepository = $contactMessageRepository;
		$this->security = $security;
	}

	public function getGlobals(): array
	{
		$user = $this->security->getUser();

		return [
			'unreadCount'    => $this->contactMessageRepository->count([
				'status' => ContactMessage::STATUS_NEW,
			]),
			// Les covoiturages auxquels l'utilisateur connecté a participé
			// (relation ManyToMany "passagers" côté User)
			'participations' => $user ? $user->getCouvoituragesparticipe() : [],
		];
	}
}
