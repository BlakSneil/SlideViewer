<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Cell;
use BS\CRUDBundle\Entity\Repository\BSBaseRepository;
use Doctrine\ORM\Query;

class CellRepository extends BSBaseRepository
{
    public function newInstance()
    {
        return new Cell();
    }
}
