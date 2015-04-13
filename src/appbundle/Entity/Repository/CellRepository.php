<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Cell;
use BS\RepositoryBundle\Entity\Repository\BaseRepository;

class CellRepository extends BaseRepository
{
    public function newInstance()
    {
        return new Cell();
    }

    public function findByName($text, $orderBy = null, $direction = 'ASC', $name = 'description')
    {
        return parent::findByName($text, $orderBy, $direction, $name);
    }
}
