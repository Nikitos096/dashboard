<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private EntityManager $em;
    private EntityRepository $repo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(User::class);
    }

    /**
     * @param string $token
     * @return User|null|object
     */
    public function findByConfirmToken(string $token): ?User
    {
        return $this->repo->findOneBy(['confirmToken' => $token]);
    }

    /**
     * @param string $token
     * @return User|null|object
     */
    public function findByResetToken(string $token): ?User
    {
        return $this->repo->findOneBy(['resetToken.token' => $token]);
    }

    /**
     * @param Id $id
     * @return User
     */
    public function get(Id $id): User
    {
        /** @var User $user */
        if (!$user = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('User is not found.');
        }

        return $user;
    }

    public function getByEmail(Email $email): User
    {
        /** @var User $user */
        if (!$user = $this->repo->findOneBy(['email' => $email->getValue()])) {
            throw new EntityNotFoundException('User is not found.');
        }

        return $user;
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('u')
                ->select('COUNT(u.id)')
                ->andWhere('u.email = :email')
                ->setParameter(':   email', $email->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByNetworkIdentity(string $network, string $identity): bool
    {
        return $this->repo->createQueryBuilder('u')
                ->select('COUNT(u.id)')
                ->innerJoin('u.networks', 'n')
                ->andWhere('n.network = :network')
                ->andWhere('n.identity = :identity')
                ->setParameter(':network', $network)
                ->setParameter(':identity', $identity)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }
}
