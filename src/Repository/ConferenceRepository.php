<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Conference::class);
    }

     /**
     * @return Query Returns a query
     */

    public function queryForUser()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.creationDate', 'DESC')
            ->getQuery();
    }

    /**
     * @return Query Returns a query
     */

    public function queryForAdmin()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.creationDate', 'DESC')
            ->andWhere('a.creationDate <= :val')
            ->setParameter('val', new \DateTime('now'))
            ->getQuery();
    }

    /**
     * @param string|null $title
     * @return Conference returns the result of searching by title of conference
     */
    public function searchByTitle(?string $title)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.title LIKE  :val')
            ->setParameter('val', '%'.$title.'%')
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
