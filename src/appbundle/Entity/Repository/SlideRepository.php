<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Slide;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class SlideRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Slide();
    }
}
