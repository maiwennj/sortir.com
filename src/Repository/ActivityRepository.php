<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\UserProfile;
use App\Model\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Sodium\add;
use function Symfony\Component\Clock\now;

/**
 * @extends ServiceEntityRepository<Activity>
 *
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function save(Activity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Activity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getFilteredActivities(Filter $filter, UserProfile $userProfile, array $activitiesIds)
    {
        $querybuilder = $this->createQueryBuilder("a");

        if($filter->getSite()!== null){
            $querybuilder
                ->where("a.site = :site")
                ->setParameter("site",$filter->getSite());

        }
        if($filter->getKeyWord()!== null){
            $querybuilder
                ->andWhere("a.activityName LIKE :keyword")
                ->setParameter("keyword",'%'.$filter->getKeyWord().'%');
        }
        if($filter->getStartDate()!==null){
            $querybuilder
                ->andWhere("a.startDate >= :startDate")
                ->setParameter("startDate",$filter->getStartDate());
        }
        if($filter->getEndDate()!==null){
            $inputDate = $filter->getEndDate();
            $filter->setEndDate($inputDate->modify('+23 hours 59 minutes'));
            $querybuilder
                ->andWhere("a.startDate <= :endDate")
                ->setParameter("endDate",$filter->getEndDate());
        }
        if($filter->getIsTheOrganiser()==1){
            $querybuilder
                ->andWhere("a.organiser = :user")
                ->setParameter("user",$userProfile);
        }
        if($filter->getIsRegistered()==1){
            $querybuilder
//                ->join("a.registrations",'r')
//                ->andWhere("r.participant = :user")
//                ->setParameter("user",$userProfile);
                ->andWhere('a.id IN (:activitiesIds)')
                ->setParameter('activitiesIds', $activitiesIds);
        }
        if($filter->getIsNotRegistered()==1){
            $querybuilder
                ->andWhere('a.id NOT IN (:activitiesIds)')
                ->setParameter('activitiesIds', $activitiesIds);
        }
        if($filter->getIsFinished()==1){
            $querybuilder
                ->andWhere("a.startDate < :now")
                ->setParameter("now",new \DateTime());
        }


        return $querybuilder->getQuery()->getResult();
    }
//    /**
//     * @return Activity[] Returns an array of Activity objects
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

//    public function findOneBySomeField($value): ?Activity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
