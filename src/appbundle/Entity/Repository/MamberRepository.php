<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Member;
use BS\RepositoryBundle\Entity\Repository\BaseRepository;

class MemberRepository extends BaseRepository
{
    public function newInstance()
    {
        return new Member();
    }
}
