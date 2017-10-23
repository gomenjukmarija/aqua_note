<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class GenusNoteRepository extends EntityRepository
{
	public function findAllRecentNotesForGenus(Genus $genus)
	{
		return $this->createQueryBuilder('genus_notes')
		    ->andWhere('genus_note.genus = :genus')
		    ->setParameter('genus',$genus)
		    ->andWhere('genus_note.createAt > :recentDate')
		    ->setParameter('recentDate', new \DateTime('-3 months'))
			->getQuery()
			->execute();		
	}
}