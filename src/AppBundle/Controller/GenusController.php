<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller 
{
	/**
	* @Route("/genus/{genusName}") 
	*/
	public function showAction($genusName) 
	{
		$notes = [
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
			'Ut enim ad minim veniam, quis nostrud exercitation',
			'Quis!'
		];		
		return $this->render('genus/show.html.twig', [
			'name' => $genusName,
			'notes' => $notes
		]);		
	}
}