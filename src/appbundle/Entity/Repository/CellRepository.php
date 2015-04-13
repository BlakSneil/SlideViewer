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
}
