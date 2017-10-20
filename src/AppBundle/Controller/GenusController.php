<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class GenusController extends Controller 
{
	/**
	* @Route("/genus/{genusName}") 
	*/
	public function showAction($genusName) 
	{
		$funFact = 'Octopuses can change the color of their body in just *three-tenths* of a second!';
		$cache = $this->get('doctrine_cache.providers.my_markdown_cache');
		$key = md5($funFact);

		if ($cache->contains($key)) {
			$funFact = $cache->fetch($key);
		} else {
			sleep(1);			
			$funFact = $this->get('markdown.parser')->transform($funFact);
			$cache->save($key, $funFact);
		}


		return $this->render('genus/show.html.twig', [
			'name' => $genusName,
			'funFact' => $funFact,			
		]);		
	}

	/**
	* @Route("/genus/{genusName}/notes", name="genus_show_notes") 
	* @Method("GET")
	*/
	public function getNotesAction()
	{
		$notes = [
			['id' => 1, 'username' => 'Mary', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'date' => 'Dec. 10, 2016'],
			['id' => 2, 'username' => 'John', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'Ut enim ad minim veniam, quis nostrud exercitation', 'date' => 'Dec. 10, 2016'],
			['id' => 3, 'username' => 'Jane', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Quis enim ad minim veniam, quis nostrud exercitation', 'date' => 'Dec. 10, 2016']			
		];

		$data = [
			'notes' => $notes,			
		];

		return new JsonResponse($data);
	}
}