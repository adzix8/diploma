<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findPlayersByPosition(Position $position) {

        return $this->createQueryBuilder('p')
            ->where('p.positions.position.id = ?', $position)
            ->getQuery()->getResult();
    }
}
