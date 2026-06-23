<?php

namespace App\Repository;

use App\Entity\Label;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Label>
 */
class LabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Label::class);
    }

    public function save(Label $label, bool $flush = true): void
    {
        $this->getEntityManager()->persist($label);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Label $label, bool $flush = true): void
    {
        $this->getEntityManager()->remove($label);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
