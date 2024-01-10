<?php

namespace App\Repository;

use App\Entity\VendorPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VendorPart>
 *
 * @method VendorPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method VendorPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method VendorPart[]    findAll()
 * @method VendorPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VendorPart::class);
    }

//    /**
//     * @return VendorPart[] Returns an array of VendorPart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VendorPart
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
