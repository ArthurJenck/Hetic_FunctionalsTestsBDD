<?php

namespace Tests;

use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class SignupMailTest extends TestCase
{
    private const MAILHOG_API_READ = 'http://localhost:8025/api/v2/messages';
    private const MAILHOG_API_DELETE = 'http://localhost:8025/api/v1/messages';

    protected function setUp(): void
    {
        parent::setUp();
        $this->clearMailhog();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_POST = [];
        $_SERVER = [];
    }

    #[TestWith(['test@test.fr', 'password123'])]
    public function testEmailSentWithValidData($a, $b)
    {
        $_SERVER['REQUEST_METHOD'] = "POST";
        $_POST['email'] = $a;
        $_POST['password'] = $b;

        ob_start();
        include __DIR__ . "/../src/signup.php";
        ob_end_clean();

        sleep(1);

        $messages = $this->getMailhogMessages();

        $this->assertCount(1, $messages, "Un email devrait être envoyé");

        $message = $messages[0];

        $this->assertEquals($a, $message['To'][0]['Mailbox'] . '@' . $message['To'][0]['Domain']);
        $this->assertEquals("Confirmation d'inscription", $message['Content']['Headers']['Subject'][0]);

        $body = $message['Content']['Body'];
        $this->assertStringContainsString('inscription a été effectuée avec succès', $body);
        $this->assertStringContainsString($a, $body);
    }

    #[TestWith(['', 'password123'])]
    #[TestWith(['test@test.fr', ''])]
    #[TestWith(['', ''])]
    public function testNoEmailSentWithInvalidData($a, $b)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        include __DIR__ . '/../src/signup.php';
        ob_end_clean();

        sleep(1);

        $messages = $this->getMailhogMessages();
        $this->assertCount(0, $messages, 'Aucun mail ne devrait avoir été envoyé');
    }

    private function getMailhogMessages(): array
    {
        $response = file_get_contents(self::MAILHOG_API_READ);

        if ($response === false) {
            $this->fail("Impossible de se connecter à l'API");
        }

        $data = json_decode($response, true);

        return $data["items"] ?? [];
    }

    private function clearMailhog(): void
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'DELETE',
                'ignore_errors' => true
            ]
        ]);

        file_get_contents(self::MAILHOG_API_DELETE, false, $context);
    }
}
