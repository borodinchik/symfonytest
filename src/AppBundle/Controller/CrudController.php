<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;


class CrudController extends Controller
{
/**
 * @Rest\Get("/users")
 */
    public function getAllUsersAction()
    {
        $data = $this->getDoctrine()->getRepository(User::class)->findAll();
//        $dataJson = json_encode($data);
        
        if ($data === null)
        {
            return new View('There are no users exist', Response::HTTP_NOT_FOUND);
        }
        return $data;
    }

    /**
     * @Rest\Get("/user/{id}")
     * @param $id
     */
    public function getUserInIdAction($id)
    {
        $data = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($data === null)
        {
            return new View('User not found', Response::HTTP_NOT_FOUND);
        }
        return $data;
    }

    /**
     * @Rest\Post("/user/create")
     * @param Request $request
     */
    public function createNewUserAction(Request $request)
    {
        $data = new User();
        $name = $request->get('userName');
        $email = $request->get('email');
        $company = $request->get('company');

        if (empty($name) || empty($email) || empty($company))
        {
            return new View('NULL VALUES ARE NOT ALLOWED');
        }

        $data->setUserName($name);
        $data->setEmail($email);
        $data->setCompany($company);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View('User Added Successfully');
    }

    /**
     * @Rest\Put("/user/update")
     * @param $id
     * @param Request $request
     */
    public function updateAction($id, Request $request)
    {
        $data = new User();
        $name = $request->get('userName');
        $email = $request->get('email');
        $company = $request->get('company');
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (empty($user))
        {
            return new View('User not found');
        }
        elseif (!empty($name) && !empty($email) && !empty($company))
        {
            $user->setUserName($name);
            $user->setEmail($email);
            $user->setCompany($company);
            $em->flush();
            return new View('User Updated Successfully', Response::HTTP_OK);
        }
        elseif (!empty($name) && empty($email) && empty($company))
        {
            $user->setUserName($name);
            $em->flush();
            return new View('User name Updated Successfully', Response::HTTP_OK);
        }
        elseif (empty($name) && !empty($email) && empty($company))
        {
            $user->setEmail($email);
            $em->flush();
            return new View('Email Updated Successfully', Response::HTTP_OK);
        }
        elseif (empty($name) && empty($email) && !empty($company))
        {
            $user->setEmail($company);
            $em->flush();
            return new View('Company Updated Successfully', Response::HTTP_OK);
        }
        else return new View('User name or email and company cannot be empty', Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @Rest\Delete("/user/delete")
     * @param $id
     * @param Request $request
     */
    public function deleteUser($id, Request $request)
    {
        $data = new User();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (empty($user))
        {
            return new View('User not found', Response::HTTP_NOT_FOUND);
        }else{
            $em->remove($user);
            $em->flush();
        }
        return new View('Delete successfully', Response::HTTP_OK);
    }
}