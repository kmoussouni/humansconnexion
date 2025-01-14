<?php

namespace App\Tests\Controller\Api;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Article::class);
    }

    public function testPOST(): void
    {
        $data = [
            'title' => 'Test',
            'content' => 'Content',
        ];

        $response = $this->client->request(
            'POST',
            'http://back.local/api/article/create',
            ['CONTENT_TYPE' => 'application/json'],
            [],
            [],
            json_encode($data),
        );

        $this->assertResponseIsSuccessful();
    }
}
