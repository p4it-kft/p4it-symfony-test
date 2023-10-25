<?php

namespace App\Repository;

use App\Entity\MessageHasTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageHasTag>
 *
 * @method MessageHasTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageHasTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageHasTag[]    findAll()
 * @method MessageHasTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageHasTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageHasTag::class);
    }

//    /**
//     * @return MessageHasTag[] Returns an array of MessageHasTag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MessageHasTag
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
