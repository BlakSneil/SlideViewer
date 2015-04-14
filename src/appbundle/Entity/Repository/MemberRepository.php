<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class MemberRepository extends EntityRepository
{
    public function newInstance()
    {
        return new Member();
    }
}
