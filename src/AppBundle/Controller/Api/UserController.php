<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Test;
use AppBundle\Form\Api\TestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/api/user")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(TestFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('api_user_list');
        }

        return $this->render('api/new.html.twig', [
            'testForm' => $form->createView()
        ]);
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

        $json = $this->serialize($user);

        return new JsonResponse($json, 200);
    }

    /**
     * @Route("/api/users", name="api_user_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:Test')
            ->findAll();

        $json = array('users' => array());

        foreach ($users as $user) {
            $json['users'][] = $this->serialize($user);
        }

        $response = new JsonResponse($json, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/api/user/{nickname}")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($nickname)
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

        $data = array(
            'tagLine' => 'an update test dev!'
        );

        $user->setTagLine($data['tagLine']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $json = $this->serialize($user);
        $response = new JsonResponse($json, 200);
        return $response;
    }

    /**
     * @Route("/api/user/{nickname}")
     * @Method("DELETE")
     */
    public function deleteAction($nickname)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Test')
            ->findOneByNickname($nickname);
        if ($user) {
            // debated point: should we 404 on an unknown nickname?
            // or should we just return a nice 204 in all cases?
            // we're doing the latter
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
        return new Response(null, 204);
    }

    protected function serialize(Test $user)
    {
        return $this->container->get('jms_serializer')
            ->serialize($user, 'json');
    }

}