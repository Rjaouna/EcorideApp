<?php

namespace App\Service;

use App\Entity\ContactMessage;
use Twig\Extension\GlobalsInterface;
use Twig\Extension\AbstractExtension;
use App\Repository\ContactMessageRepository;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
	private ContactMessageRepository $contactMessageRepository;

	public function __construct(ContactMessageRepository $contactMessageRepository)
	{
		$this->contactMessageRepository = $contactMessageRepository;
	}

	public function getGlobals(): array
	{
		return [
			'unreadCount' => $this->contactMessageRepository->count([
				'status' => ContactMessage::STATUS_NEW
			]),
		];
	}
}
