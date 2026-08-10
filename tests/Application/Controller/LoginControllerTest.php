<?php

namespace App\Tests\Application\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $userRepository = $em->getRepository(User::class);

        $em->flush();
    }
    // TODO : Create multiple test for different assertions generate
    public function testLogin(): void
    {
        // Denied - Can't login with invalid email address.
        $this->client->request('GET', '/');
        self::assertResponseIsSuccessful();

        $this->client->submitForm('Se connecter', [
            '_username' => 'user',
            '_password' => 'mdp-45',
        ]);

        self::assertResponseRedirects('/event');
//        $this->client->followRedirect();
//
//        // Ensure we do not reveal if the user exists or not.
//        self::assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
//
//        // Denied - Can't login with invalid password.
//        $this->client->request('GET', '/login');
//        self::assertResponseIsSuccessful();
//
//        $this->client->submitForm('Sign in', [
//            '_username' => 'email@example.com',
//            '_password' => 'bad-password',
//        ]);
//
//        self::assertResponseRedirects('/login');
//        $this->client->followRedirect();
//
//        // Ensure we do not reveal the user exists but the password is wrong.
//        self::assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
//
//        // Success - Login with valid credentials is allowed.
//        $this->client->submitForm('Sign in', [
//            '_username' => 'email@example.com',
//            '_password' => 'password',
//        ]);
//
//        self::assertResponseRedirects('/');
//        $this->client->followRedirect();
//
//        self::assertSelectorNotExists('.alert-danger');
//        self::assertResponseIsSuccessful();
    }
}
