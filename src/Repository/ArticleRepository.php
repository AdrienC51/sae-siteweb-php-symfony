<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search(string $text, string $pMin = '', string $pMax = ''): array
    {
        if (empty($text) && empty($pMin) && empty($pMax)) {
            $query = $this->createQueryBuilder('a')
                ->orderBy('a.name', 'ASC')
                ->getQuery();
        } elseif (!empty($text)) {
            if (!empty($pMin) && !empty($pMax)) {
                $query = $this->createQueryBuilder('a')
                    ->where('a.name LIKE :text')
                    ->andWhere('a.price >= :pMin')
                    ->andWhere('a.price <= :pMax')
                    ->setParameter('text', '%'.$text.'%')
                    ->setParameter('pMin', (float) $pMin)
                    ->setParameter('pMax', (float) $pMax)
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            } elseif (!empty($pMin) && empty($pMax)) {
                $query = $this->createQueryBuilder('a')
                    ->where('a.name LIKE :text')
                    ->andWhere('a.price >= :pMin')
                    ->setParameter('text', '%'.$text.'%')
                    ->setParameter('pMin', (float) $pMin)
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            } elseif (empty($pMin) && !empty($pMax)) {
                $query = $this->createQueryBuilder('a')
                    ->where('a.name LIKE :text')
                    ->andWhere('a.price <= :pMax')
                    ->setParameter('text', '%'.$text.'%')
                    ->setParameter('pMax', (float) $pMax)
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            } else {
                $query = $this->createQueryBuilder('a')
                    ->where('a.name LIKE :text')
                    ->setParameter('text', '%'.$text.'%')
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            }
        } else {
            if (!empty($pMin) && !empty($pMax)) {
                $query = $this->createQueryBuilder('a')
                    ->where('a.price >= :pMin')
                    ->andWhere('a.price <= :pMax')
                    ->setParameter('pMin', (float) $pMin)
                    ->setParameter('pMax', (float) $pMax)
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            } elseif (!empty($pMin) && empty($pMax)) {
                $query = $this->createQueryBuilder('a')
                    ->where('a.price >= :pMin')
                    ->setParameter('pMin', (float) $pMin)
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            } else {
                $query = $this->createQueryBuilder('a')
                    ->where('a.price <= :pMax')
                    ->setParameter('pMax', (float) $pMax)
                    ->orderBy('a.name', 'ASC')
                    ->getQuery();
            }
        }

        return $query->getResult();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
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

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
