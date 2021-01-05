<?php

namespace App\Repository;

use App\Entity\Show;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Show|null find($id, $lockMode = null, $lockVersion = null)
 * @method Show|null findOneBy(array $criteria, array $orderBy = null)
 * @method Show[]    findAll()
 * @method Show[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Show::class);
    }

    public function nextShowsForThisBand($bandId){
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT show_id FROM `show_band` join showT on id = show_id where band_id = :bandId and date >= CURRENT_TIMESTAMP ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bandId' => $bandId]);
        $result = array_values($stmt->fetchFirstColumn());
        if (!empty($result)) {
            return $this->findBy(['id' => $result]);
        } else {
            return false;
        }
    }

    public function nextShows(){
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT show_id FROM `show_band` join showT on id = show_id WHERE date >= CURRENT_TIMESTAMP ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = array_values($stmt->fetchFirstColumn());
        if (!empty($result)) {
            return $this->findBy(['id' => $result]);
        } else {
            return false;
        }
    }

    public function oldShows(){
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT show_id FROM `show_band` join showT on id = show_id WHERE date < CURRENT_TIMESTAMP ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = array_values($stmt->fetchFirstColumn());
        if (!empty($result)) {
            return $this->findBy(['id' => $result],['date' => 'DESC']);
        } else {
            return false;
        }
    }

    // /**
    //  * @return Show[] Returns an array of Show objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Show
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
