<?php

namespace Everlution\EmailBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{

    /**
     * @param $entity
     */
    public function save($entity)
    {
        $this->persist($entity);
        $this->_em->flush($entity);
    }

    public function persist($entity)
    {
        $this->_em->persist($entity);
    }

    public function flushAll()
    {
        $this->_em->flush();
    }

}
