<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\Criteria;
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
          //  ->leftJoin('genus.genusScientists', 'genusScientist')
          //  ->addSelect('genusScientist')
			->getQuery()
			->execute();
	}

    /**
     * @return Genus[]
     */
    public function findAllExperts()
    {
        return $this->createQueryBuilder('genus')
            ->addCriteria(self::createExpertCriteria())
            ->getQuery()
            ->execute();
    }

    static public function createExpertCriteria()
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->gt('yearsStudied', 20))
            ->orderBy(['yearsStudied', 'DESC']);
    }

}