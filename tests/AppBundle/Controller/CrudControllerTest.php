<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CrudController extends WebTestCase
{
    public function testShowAllUsers()
    {
        //создаем клиента который типо будет обращаться к апи
        $client = static::createClient();
         //тут мы проверяем если клиент стучит в этот роут то он должен исаользовать метод  гет
        $client->request('GET', '/users');
            //дальше получаем ответ от сервера
        $response = $client->getResponse();
         //указываем какой ответ должен прийти нам из апи
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        //если все верно тот проверяем с помошью этого метада статус хедеры
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
           //и получаем джейсон на выходе
        $response->getContent();
    }   

    public function testGetUserId()
    {

        $client = static::createClient();
        
        $client->request('GET', '/user/1');
        
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        json_decode($response->getContent());
    }

    public function testCreateNewUser()
    {
        $client = static::createClient();

        $client->request('POST', '/user/create');
        
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        
        json_decode($response->getContent());
        
        


    }

    public function testUpdateUserInId()
    {
        $client = static::createClient();

        $client->request('PUT', '/user/1');
        
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        json_decode($response->getContent());
    }

    public function testDeleteUser()
    {
        $client = static::createClient();
        
        $client->request('DELETE', '/user/1');
        
        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        
        json_decode($response->getContent());
    }
}