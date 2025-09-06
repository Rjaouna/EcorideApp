<?php
namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$marques = [
			'Peugeot',
			'Citroën',
			'DS Automobiles',
			'Renault',
			'Dacia',
			'Volkswagen',
			'Audi',
			'BMW',
			'Mercedes-Benz',
			'Opel',
			'Ford',
			'Seat',
			'Cupra',
			'Škoda',
			'Mini',
			'Toyota',
			'Lexus',
			'Honda',
			'Nissan',
			'Mazda',
			'Mitsubishi',
			'Subaru',
			'Suzuki',
			'Hyundai',
			'Kia',
			'Jaguar',
			'Land Rover',
			'Volvo',
			'Jeep',
			'Tesla',
			'Alfa Romeo',
			'Fiat',
			'Ferrari',
			'Lamborghini',
			'Maserati',
			'Porsche',
		];

		foreach ($marques as $name) {
			$marque = new Marque();
			$marque->setNom($name);
			$manager->persist($marque);
		}

		$manager->flush();
	}
}
