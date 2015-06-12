<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="BS\UserBundle\Entity\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    // public function addRole($roleObj)
    // {
    //     $role = $roleObj->getRole();

    //     return parent::addRole($role);
    // }
}
