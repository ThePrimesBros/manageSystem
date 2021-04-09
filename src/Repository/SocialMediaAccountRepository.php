<?php

namespace App\Repository;

use App\Entity\SocialMediaAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocialMediaAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialMediaAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialMediaAccount[]    findAll()
 * @method SocialMediaAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialMediaAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialMediaAccount::class);
    }

     /**
      * @return SocialMediaAccount[] Returns an array of SocialMediaAccount objects
        */
    
    public function findByUser($user)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :user')
            ->setParameter('user', $user)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
      * @return SocialMediaAccount[] Returns an array of SocialMediaAccount objects
        */
    
        public function findByUserAndSocialMedia($user,$socialMediaAccount)
        {
            return $this->createQueryBuilder('s')
                ->where('s.socialMedia = :socialMedia')
                ->setParameter('socialMedia', $socialMediaAccount)
                ->andWhere('s.user = :user')
                ->setParameter('user', $user)
                ->orderBy('s.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

    
  /**
     * @return FbAccount Return FbAccount objects
     */
    
    public function findById($id)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.id = :id')
            ->setParameter('id', $id)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?SocialMediaAccount
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
