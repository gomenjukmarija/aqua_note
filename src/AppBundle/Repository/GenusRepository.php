<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Genus;

class GenusRepository extends EntityRepository
{
	/**
	* @return Genus[] 
	*/
	public function findAllPublishedOrderByRecentlyActive()
	{
		return $this->createQueryBuilder('genus')
			->andWhere('genus.isPublished = :isPublished')
			->setParameter('isPublished', true)
			->leftJoin('genus.notes', 'genus_note')
            ->orderBy('genus_note.createdAt', 'DESC')
            ->leftJoin('genus.genusScientists', 'genusScientist')
            ->addSelect('genusScientist')
			->getQuery()
			->execute();
	}

}