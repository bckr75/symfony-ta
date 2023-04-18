<?php

namespace App\Repository;

use App\Entity\TaxNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxNumber>
 *
 * @method TaxNumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxNumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxNumber[]    findAll()
 * @method TaxNumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxNumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxNumber::class);
    }

    public function save(TaxNumber $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaxNumber $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findTaxNumberByPrefix(string $prefix): ?TaxNumber
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.prefix = :prefix')
            ->setParameter('prefix', $prefix)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


//    /**
//     * @return TaxNumber[] Returns an array of TaxNumber objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


//    public function findOneBySomeField($value): ?TaxNumber
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//
}
