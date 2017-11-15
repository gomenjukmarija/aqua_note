<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/api/user")
     * @Method("POST")
     */
    public function newAction()
    {
        $nickname = 'ObjectOrienter'.rand(0, 999);
        $data = array(
            'nickname' => $nickname,
            'avatarNumber' => 5,
            'tagLine' => 'a test dev!'
        );

        $user = new Test();

        $user->setNickname($data['nickname']);
        $user->setAvatarNumber($data['avatarNumber']);
        $user->setTagLine($data['tagLine']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $data = $this->serializeProgrammer($user);
        $response = new JsonResponse($data, 201);
        $userUrl = $this->generateUrl(
            'api_user_show',
            ['nickname' =>  $user->getNickname()]
        );
        $response->headers->set('Location', $userUrl);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/api/user/{nickname}", name="api_user_show")
     * @Method("GET")
     */
    public function showAction($nickname)
    {

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Test')
            ->findOneByNickname($nickname);

        if (!$user) {
            throw $this->createNotFoundException(sprintf(
                'No user found with nickname "%s"',
                $nickname
            ));
        }

        $data = $this->serializeProgrammer($user);

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/users")
     * @Method("GET")
     */
    public function listAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:Test')
            ->findAll();

        $data = array('users' => array());

        foreach ($users as $user) {
            $data['users'][] = $this->serializeProgrammer($user);
        }

        $response = new JsonResponse($data, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function serializeProgrammer(Test $user)
    {
        return array(
            'nickname' => $user->getNickname(),
            'avatarNumber' => $user->getAvatarNumber(),
            'tagLine' => $user->getTagLine(),
        );
    }
}