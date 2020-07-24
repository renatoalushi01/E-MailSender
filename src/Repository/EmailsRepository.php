<?php

namespace App\Repository;

use App\Entity\Emails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Emails|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emails|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emails[]    findByUserId($value)
 * @method Emails[]    findAll()
 * @method Emails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emails::class);
    }

     /**
      * @param $value
      * @return mixed
      */
     /*
    public function findByUserId($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Emails e
            WHERE e.usr_id > :id'
        )->setParameter('id', $value);

        // returns an array of Emails objects
        return $query->getResult();
    }
    

    /*
    public function findOneBySomeField($value): ?Emails
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
