<?php

namespace App\Repository;

use App\Entity\StockEvolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockEvolution>
 */
class StockEvolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockEvolution::class);
    }
    public function findByArticleIdOrderedByDate(int $articleId)
    {
        $qb = $this->createQueryBuilder('se')
            ->join('se.article', 'a')
            ->where('a.id = :articleId')
            ->setParameter('articleId', $articleId)
            ->orderBy('se.evolutionDate', 'DESC');
        return $qb->getQuery()->execute();
    }

    //    /**
    //     * @return StockEvolution[] Returns an array of StockEvolution objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?StockEvolution
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
