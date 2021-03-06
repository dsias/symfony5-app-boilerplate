<?php

namespace App\Repositories;

use App\Domain\Entities\User\User;
use App\Domain\Repositories\Interfaces\UsersRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class UsersRepository extends Repository implements UsersRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function existsByEmail(string $email): bool
    {
        return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.email = :email')
                ->setParameter(':email', $email)
                ->getQuery()->getSingleScalarResult() > 0;
    }


    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }


    public function getOneByEmail(string $email): User
    {
        return $this->getOneBy(['email' => $email]);
    }


    public function getOneById(int $id): User
    {
        return $this->getOneBy(['id' => $id]);
    }

}
