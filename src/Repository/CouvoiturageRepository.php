<?php

namespace App\Repository;

use App\Entity\Couvoiturage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Couvoiturage>
 */
class CouvoiturageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Couvoiturage::class);
    }
    /**
     * @return Couvoiturage[]
     */
    // src/Repository/CouvoiturageRepository.php
    public function search(
        ?string $depart,
        ?string $arrivee,
        ?\DateTimeInterface $departAt,
        int $page = 1,
        int $limit = 20
    ): array {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.driver', 'd')->addSelect('d')
            ->orderBy('c.departAt', 'ASC');

        // Ex : n’afficher que les futurs (optionnel, à garder/supprimer selon besoin)
        // $qb->andWhere('c.departAt >= :now')->setParameter('now', new \DateTimeImmutable());

        if ($depart) {
            $qb->andWhere('LOWER(c.lieuDepart) LIKE :depart')
                ->setParameter('depart', mb_strtolower($depart) . '%');
        }
        if ($arrivee) {
            $qb->andWhere('LOWER(c.lieuArrivee) LIKE :arrivee')
                ->setParameter('arrivee', mb_strtolower($arrivee) . '%');
        }

        if ($departAt) {
            // Si on reçoit juste une date, on filtre sur la journée complète
            $start = (clone $departAt)->setTime(0, 0, 0);
            $end   = (clone $departAt)->setTime(23, 59, 59);
            $qb->andWhere('c.departAt BETWEEN :start AND :end')
                ->setParameter('start', $start)
                ->setParameter('end', $end);
        }

        $offset = max(0, ($page - 1) * $limit);
        $qb->setFirstResult($offset)->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Couvoiturage[] Returns an array of Couvoiturage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Couvoiturage
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
