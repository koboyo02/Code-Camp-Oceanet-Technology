<?php

namespace App\Repository;

use App\Entity\ResumeExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResumeExperience>
 *
 * @method null|ResumeExperience find($id, $lockMode = null, $lockVersion = null)
 * @method null|ResumeExperience findOneBy(array $criteria, array $orderBy = null)
 * @method ResumeExperience[]    findAll()
 * @method ResumeExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResumeExperience::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ResumeExperience $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ResumeExperience $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllLoadedById(int $resumeId): array
    {
        return $this->createQueryBuilder('e')
            ->where('r.id = :resume_id')
            ->innerJoin('e.parent', 'r')
            ->setParameter('resume_id', $resumeId)
            // ->orderBy('e.startedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
