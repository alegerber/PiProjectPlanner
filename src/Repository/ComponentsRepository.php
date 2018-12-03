<?php

namespace App\Repository;

use App\Entity\Components;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Components|null find($id, $lockMode = null, $lockVersion = null)
 * @method Components|null findOneBy(array $criteria, array $orderBy = null)
 * @method Components[]    findAll()
 * @method Components[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComponentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Components::class);
    }

    // /**
    //  * @return Components[] Returns an array of Database objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Database
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}