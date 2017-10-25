<?php

namespace AppBundle\Controller;

use AppBundle\Service\MarkdownTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;

class GenusController extends Controller 
{
	/**
	* @Route("/genus/new") 
	*/
	public function newAction() 
	{
	    $genus = new Genus();
	    $genus->setName('Octopus'.rand(1,100));
		$genus->setSubFamily('Octoppdinae');
		$genus->setSpeciesCount(rand(100,99999));

		$genusNote = new GenusNote(); 
		$genusNote->setUsername('Mary');
		$genusNote->setuserAvatarFilename('leanna.jpeg');
		$genusNote->setNote('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
		$genusNote->setCreatedAt(new \DateTime('-1 month'));
		$genusNote->setGenus($genus);

		$em = $this->getDoctrine()->getManager();
		$em->persist($genus);
		$em->persist($genusNote);
		$em->flush();

		return new Response('<html><body>Genus created!</body></html>');
	}

	/**
	* @Route("/genus") 
	*/
	public function listAction() 
	{
		$em = $this->getDoctrine()->getManager();		
		$genuses = $em->getRepository('AppBundle:Genus')
			->findAllPublishedOrderByRecentlyActive();
		return $this->render('genus/list.html.twig', [
			'genuses' => $genuses,		
		]);	
	}	

	/**
	* @Route("/genus/{genusName}", name="genus_show") 
	*/
	public function showAction($genusName) 
	{
		$em = $this->getDoctrine()->getManager();
		$genus = $em->getRepository('AppBundle:Genus')->findOneBy(['name' => $genusName]);

		if(!$genus) {
			throw $this->createNotFoundException("No genus found!");

		}

		$transformer = $this->get('app.markdown_transformer');
		$funFact = $transformer->parse($genus->getFunFact());

		$this->get('logger')
			->info('Showing genus: '.$genusName);

		$recentNotes = $em->getRepository('AppBundle:GenusNote')
		 ->findAllRecentNotesForGenus($genus);

		return $this->render('genus/show.html.twig', [
			'genus' => $genus,
			'funFact' => $funFact,
			'recentNotecount' => count($recentNotes),

		]);
	}

	/**
	* @Route("/genus/{name}/notes", name="genus_show_notes") 
	* @Method("GET")
	*/
	public function getNotesAction(Genus $genus)
	{
		$notes = [];
		foreach ($genus->getNotes() as $note) {
			$notes[] = [
				'id' => $note->getId(),
				'username' => $note->getUsername(),
				'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
				'note' => $note->getNote(),
				'date' => $note->getCreatedAt()->format('M d, Y')
			];
		}

		$data = [
			'notes' => $notes,			
		];

		return new JsonResponse($data);
	}
}