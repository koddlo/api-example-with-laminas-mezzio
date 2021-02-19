<?php

declare(strict_types=1);

namespace AuthTest\Repository;

use Auth\Model\User;
use Auth\Model\UserCollection;
use Auth\Model\UserInterface;
use Auth\Repository\UserRepository;
use Auth\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private const USER_VALID_ID = 'validId';
    private const USER_INVALID_ID = 'invalidId';
    private const USER_VALID_PASSWORD = 'validPassword';
    private const USER_INVALID_PASSWORD = 'invalidPassword';
    private const USER_VALID_PASSWORD_HASH = '$2y$10$dKjKO6iC9lP.UVbaCVTZcut51ODnOhUe1rQKC.YA8lMkzUpaGI7WC';

    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        $users = new UserCollection();
        $users->add(
            new User(self::USER_VALID_ID, self::USER_VALID_PASSWORD_HASH, [])
        );

        $this->userRepository = new UserRepository($users);
    }

    public function testIsAuthenticationFailedWhenCredentialIsWrong(): void
    {
        $this->assertNull(
            $this->userRepository->authenticate(self::USER_INVALID_ID, self::USER_VALID_PASSWORD)
        );
    }

    public function testIsAuthenticationFailedWhenPasswordIsWrong(): void
    {
        $this->assertNull(
            $this->userRepository->authenticate(self::USER_VALID_ID, self::USER_INVALID_PASSWORD)
        );
    }

    public function testCanPassThruAuthenticationWhenCredentialsAreGood(): void
    {
        $this->assertInstanceOf(
            UserInterface::class,
            $this->userRepository->authenticate(self::USER_VALID_ID, self::USER_VALID_PASSWORD)
        );
    }
}
