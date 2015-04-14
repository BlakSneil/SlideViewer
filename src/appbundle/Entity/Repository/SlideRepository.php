<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Slide;
use BS\RepositoryBundle\Entity\Repository\BaseRepository;

class SlideRepository extends BaseRepository
{
    public function newInstance()
    {
        return new Slide();
    }
}
