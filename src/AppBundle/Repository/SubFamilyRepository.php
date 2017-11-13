<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class SubFamilyRepository extends EntityRepository
{
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('sub_family')
            ->orderBy('sub_family.name', 'ASC');
    }

    public function findAny()
    {
        $sql = "
              SELECT s.* FROM sub_family as s
              ORDER BY RAND()
              LIMIT 1
        ";

        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('AppBundle\Entity\SubFamily', 's');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        return $query->getSingleResult();
    }

}