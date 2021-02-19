<?php

declare(strict_types=1);

namespace AuthTest\Model;

use Auth\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCanVerifyPassword(): void
    {
        $invalidPassword = 'invalidPassword';
        $validPassword = 'validPassword';
        $validPasswordHash = '$2y$10$dKjKO6iC9lP.UVbaCVTZcut51ODnOhUe1rQKC.YA8lMkzUpaGI7WC';

        $user = new User('testId', $validPasswordHash, []);

        $this->assertFalse($user->isPasswordValid($invalidPassword));
        $this->assertTrue($user->isPasswordValid($validPassword));
    }
}
