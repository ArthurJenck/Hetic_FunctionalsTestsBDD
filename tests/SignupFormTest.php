<?php

namespace Tests;

use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class SignupFormTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        $_POST = [];
        $_SERVER = [];
    }

    #[TestWith(['test@test.fr', 'password123'])]
    #[TestWith(['test2@gmail.com', 'p455w0rD'])]
    public function testSignupWithValidData($a, $b)
    {
        $_SERVER["REQUEST_METHOD"] = 'POST';
        $_POST["email"] = $a;
        $_POST["password"] = $b;

        ob_start();
        include __DIR__ . '/../src/signup.php';
        $output = ob_get_clean();

        $this->assertStringContainsString("réussie", $output);
        $this->assertStringContainsString($a, $output);
    }

    #[TestWith(['', 'password123'])]
    #[TestWith(['test@test.fr', ''])]
    #[TestWith(['', ''])]
    public function testSignupWithBlankData($a, $b)
    {
        $_SERVER["REQUEST_METHOD"] = 'POST';
        $_POST['email'] = $a;
        $_POST['password'] = $b;

        $this->expectOutputString('Email et mot de passe requis');

        include __DIR__ . '/../src/signup.php';
    }

    public function testWithIncorrectMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        ob_start();
        include __DIR__ . 'tests/../src/signup.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('non autorisée', $output);
    }
}
