<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CrudController extends WebTestCase
{
    public function testShowAllUsers()
    {
        $client = static::createClient();
        $client->request('GET', '/users');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $response->getContent();
    }   

    public function testGetUserId()
    {

        $client = static::createClient();
        $client->request('GET', '/user/1');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $response->getContent();
    }

    public function testCreateNewUser()
    {
        $client = static::createClient();
        $client->request('POST', '/user/create');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $response->getContent();
    }
//
//    public function testUpdateUserInId()
//    {
//        $client = static::createClient();
//        $client->request('PUT', '/user/1');
//        $response = $client->getResponse();
//        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
//        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
//        $response->getContent();
//    }
//
//    public function testDeleteUser()
//    {
//        $client = static::createClient();
//        $client->request('DELETE', '/user/1');
//        $response = $client->getResponse();
//        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
//        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
//        $response->getContent();
//    }
}