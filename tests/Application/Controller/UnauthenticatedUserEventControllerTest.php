<?php

namespace App\Tests\Application\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class UnauthenticatedUserEventControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $eventRepository;
    private string $path = '/event/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->eventRepository = $this->manager->getRepository(Event::class);

        $this->manager->flush();
    }

    public function testUnauthorizedUserCantConnectToEventListPage(): void
    {
        $this->client->followRedirects();
        $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(404);
    }

// TODO : add following tests of event controller

//    public function testNew(): void
//    {
//        $this->markTestIncomplete();
//        $this->client->request('GET', sprintf('%snew', $this->path));
//
//        self::assertResponseStatusCodeSame(200);
//
//        $this->client->submitForm('Save', [
//            'event[event_name]' => 'Testing',
//            'event[event_date]' => 'Testing',
//            'event[event_slug]' => 'Testing'
//        ]);
//
//        self::assertResponseRedirects($this->path);
//
//        self::assertSame(1, $this->eventRepository->count([]));
//    }
//
//    public function testShow(): void
//    {
//        $this->markTestIncomplete();
//        $fixture = new Event();
//        $fixture->setEvent_name('My Title');
//        $fixture->setEvent_date('My Title');
//        $fixture->setEvent_slug('My Title');
//
//        $this->manager->persist($fixture);
//        $this->manager->flush();
//
//        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//
//        self::assertResponseStatusCodeSame(200);
//        self::assertPageTitleContains('Event');
//
//        // Use assertions to check that the properties are properly displayed.
//    }
//
//    public function testEdit(): void
//    {
//        $this->markTestIncomplete();
//        $fixture = new Event();
//        $fixture->setEvent_name('Value');
//        $fixture->setEvent_date('Value');
//        $fixture->setEvent_slug('Value');
//
//        $this->manager->persist($fixture);
//        $this->manager->flush();
//
//        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
//
//        $this->client->submitForm('Update', [
//            'event[event_name]' => 'Something New',
//            'event[event_date]' => 'Something New',
//            'event[event_slug]' => 'Something New',
//        ]);
//
//        self::assertResponseRedirects('/event/');
//
//        $fixture = $this->eventRepository->findAll();
//
//        self::assertSame('Something New', $fixture[0]->getEvent_name());
//        self::assertSame('Something New', $fixture[0]->getEvent_date());
//        self::assertSame('Something New', $fixture[0]->getEvent_slug());
//    }
//
//    public function testRemove(): void
//    {
//        $this->markTestIncomplete();
//        $fixture = new Event();
//        $fixture->setEvent_name('Value');
//        $fixture->setEvent_date('Value');
//        $fixture->setEvent_slug('Value');
//
//        $this->manager->persist($fixture);
//        $this->manager->flush();
//
//        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//        $this->client->submitForm('Delete');
//
//        self::assertResponseRedirects('/event/');
//        self::assertSame(0, $this->eventRepository->count([]));
//    }
}
