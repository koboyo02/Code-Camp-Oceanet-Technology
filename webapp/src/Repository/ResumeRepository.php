<?php

namespace App\Repository;

use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resume>
 *
 * @method null|Resume find($id, $lockMode = null, $lockVersion = null)
 * @method null|Resume findOneBy(array $criteria, array $orderBy = null)
 * @method Resume[]    findAll()
 * @method Resume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resume::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Resume $entity, bool $flush = true): void
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
    public function remove(Resume $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByIdFullyLoaded(string $id): ?Resume
    {
        return $this->createQueryBuilder('r')
            ->select('r, a, e')
            ->leftJoin('r.address', 'a')
            ->leftJoin('r.experiences', 'e')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByHashFullyLoaded(string $hash): ?Resume
    {
        return $this->createQueryBuilder('r')
            ->select('r, a, e')
            ->leftJoin('r.address', 'a')
            ->leftJoin('r.experiences', 'e')
            ->where('r.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
