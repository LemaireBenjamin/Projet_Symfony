<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participant>
 *
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function save(Participant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Participant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Participant[] Returns an array of Participant objects
     */
    public function findUserByParticipantId($id): array
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT p,u
                FROM App\Entity\Participant p
                INNER JOIN App\Entity\User u
                WHERE p.id = :id AND p = u.participant')
            ->setParameter('id', $id)
            ->getResult();
    }

    public function findParticipantByUserId($id): array
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT p
                FROM App\Entity\Participant p
                INNER JOIN App\Entity\User u
                WHERE u.id = :id AND p = u.participant')
            ->setParameter('id', $id)
            ->getResult();
    }

//    public function findOneByIsOrganiser(int $value): ?Participant
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.isOrganiser = :value')
//            ->setParameter('value', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
