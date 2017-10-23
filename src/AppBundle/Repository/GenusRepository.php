<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GenusRepository extends EntityRepository
{
	/**
	* @return Genus[] 
	*/
	public function findAllPublishedOrderBySize()
	{
		return $this->createQueryBuilder('genus')
			->andWhere('genus.isPublished = :isPublished')
			->setParameter('isPublished', true)
			->orderBy('genus.speciesCount','DESC')
			->getQuery()
			->execute();
	}
}