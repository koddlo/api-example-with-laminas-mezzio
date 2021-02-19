<?php

declare(strict_types=1);

namespace Auth\Factory;

use Auth\Model\User;
use Auth\Model\UserCollection;
use Auth\Repository\UserRepository;
use Interop\Container\ContainerInterface;

class UserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): UserRepository
    {
        $config = $container->get('config');

        $users = new UserCollection();
        foreach ($config['authentication']['users'] ?? [] as $userId => $userData) {
            if (empty($userData['password'])) {
                throw new \InvalidArgumentException('User password is required.');
            }

            $users->add(
                new User(
                    $userId,
                    $userData['password'],
                    $userData['ipAddresses'] ?? []
                )
            );
        }

        return new UserRepository($users);
    }
}
