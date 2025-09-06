<?php
// src/DataFixtures/UserFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
	public function __construct(private UserPasswordHasherInterface $hasher) {}

	public function load(ObjectManager $manager): void
	{
		// 1) PASSAGER
		$passager = (new User())
			->setEmail('passager@ecoride.fr')
			->setNom('Dupont')
			->setPrenom('Julie')
			->setTelephone('0600000001')
			->setAdresse('10 Rue des Fleurs, 59000 Lille')
			->setNaissanceAt(new \DateTimeImmutable('1992-05-10'))
			->setPseudo('Voyagesecu')
			->setSexe('Femme')
			->setIsVerified(true)
			->setRoles(['ROLE_PASSAGER']); 
		$passager->setPassword($this->hasher->hashPassword($passager, 'passager@ecoride.fr'));
		$manager->persist($passager);

		// 2) CONDUCTEUR
		$conducteur = (new User())
			->setEmail('conducteur@ecoride.fr')
			->setNom('Martin')
			->setPrenom('Karim')
			->setTelephone('0600000002')
			->setAdresse('22 Avenue du Port, 59800 Lille')
			->setNaissanceAt(new \DateTimeImmutable('1988-11-20'))
			->setPseudo('Tripto')
			->setSexe('Homme')
			->setIsVerified(true)
			->setRoles(['ROLE_DRIVER']);
		$conducteur->setPassword($this->hasher->hashPassword($conducteur, 'conducteur@ecoride.fr'));
		$manager->persist($conducteur);

		// 3) ADMIN (super admin)
		$admin = (new User())
			->setEmail('admin@ecoride.fr')
			->setNom('Admin')
			->setPrenom('EcoRide')
			->setTelephone('0600000003')
			->setAdresse('1 Place Centrale, 75000 Paris')
			->setNaissanceAt(new \DateTimeImmutable('1985-01-01'))
			->setPseudo('admin')
			->setSexe('Autre')
			->setIsVerified(true)
			->setRoles(['ROLE_ADMIN']); 
		$admin->setPassword($this->hasher->hashPassword($admin, 'admin@ecoride.fr'));
		$manager->persist($admin);

		$manager->flush();
	}
}
