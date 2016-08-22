<?php


namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhraseGeneratorControllerTest extends WebTestCase
{

    private $url = "http://api.lookover.app/phrase_generator";

    function testGetAll()
    {
        $client = self::createClient();
        $client->request('GET', $this->url);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertCount(2, $content);
    }

    function testCreate()
    {
        $client = self::createClient();
        $client->request('POST', $this->url, ['phrase' => "some text"]);
        $response = $client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
    }

    function testGetOne()
    {
        $client = self::createClient();
        $id = 2;
        $client->request('GET', $this->url . "/" . $id);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        $this->assertEquals("oops", $content[$id]['phrase']);
    }

    function testUpdate()
    {
        $client = self::createClient();
        $id = 0;
        $data = ['phrase' => "super phrase"];
        $client->request('PUT', $this->url . "/" . $id, $data);
        $response = $client->getResponse();
        $this->assertEquals(202, $response->getStatusCode());
        $this->assertTrue((bool)$response->getContent());

        $client = self::createClient();
        $client->request('GET', $this->url . "/" . $id);
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals("super phrase", $content[$id]['phrase']);
    }

    function testDelete()
    {
        $client = self::createClient();
        $id = 0;
        $client->request('DELETE', $this->url . "/" . $id);
        $response = $client->getResponse();
        $response_data = json_decode($response->getContent(), true);
        $this->assertTrue($response_data);
        $client->request('GET', $this->url);
        $this->assertCount(2,  json_decode($client->getResponse()->getContent(), true));
    }
}
