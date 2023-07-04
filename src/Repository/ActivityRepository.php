<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activity>
 *
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function save(Activity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Activity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByFilters($site, $name, $startDate, $endDate, $isOrganizer, $isParticipant, $isNotParticipant, $isPast, $currentUser)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        if ($site) {
            $queryBuilder->andWhere('a.site = :site')
                ->setParameter('site', $site);
        }

        if ($name) {
            $queryBuilder->andWhere('a.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if ($startDate) {
            $queryBuilder->andWhere('a.startDate >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $queryBuilder->andWhere('a.startDate <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        if ($isOrganizer) {
            $queryBuilder->andWhere('a.organizer = :organizer')
                ->setParameter('organizer', $currentUser);
        }

        if ($isParticipant && !$isNotParticipant) {
            $queryBuilder->innerJoin('a.participants', 'p1')
                ->andWhere('p1.id = :participantId')
                ->setParameter('participantId', $currentUser->getId());
        }

        if ($isNotParticipant && !$isParticipant) {
            $queryBuilder->leftJoin('a.participants', 'p2')
                ->andWhere($queryBuilder->expr()->orX(
                    $queryBuilder->expr()->isNull('p2'),
                    $queryBuilder->expr()->neq('a.id', ':participantId')
                ))
                ->setParameter('participantId', $currentUser->getId());
        }

        if ($isParticipant && $isNotParticipant) {
            $queryBuilder->leftJoin('a.participants', 'p2')
                ->andWhere($queryBuilder->expr()->orX(
                    $queryBuilder->expr()->isNull('p2'),
                    $queryBuilder->expr()->neq('p2.id', ':participantId')
                ))
                ->setParameter('participantId', $currentUser->getId());
        }

        if ($isPast) {
            $statusIds = [3, 5]; // Liste des IDs de statut à inclure
            $queryBuilder->andWhere('a.status IN (:statusIds)')
                ->setParameter('statusIds', $statusIds);
        }
//            $queryBuilder->andWhere('a.startDate < :currentDate')
//                ->setParameter('currentDate', new \DateTime());
//        }

        return $queryBuilder->getQuery()->getResult();
    }


//    public function findOneByOrganizerId(int $organiserId): ?array
//    {
//        $queryBuilder = $this->createQueryBuilder('a')
//            ->select('p.firstname', 'p.lastname')
//            ->leftJoin('a.organiser', 'p')
//            ->andWhere('a.organiser = :organiserId')
//            ->setParameter('organiserId', $organiserId)
//            ->getQuery();
//
//        return $queryBuilder->getOneOrNullResult();
//    }

//    /**
//     * @return Activity[] Returns an array of Activity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Activity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
