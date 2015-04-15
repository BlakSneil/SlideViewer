<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="member")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MemberRepository")
 */
class Member extends Person
{
    /**
     * @ORM\Column(name="school", type="string", length=50)
     */
    private $school;

    /**
     * @ORM\Column(name="live_year", type="string", length=10)
     */
    private $liveYear;

    /**
     * @ORM\Column(name="role", type="string", length=10)
     */
    private $role;

    /**
     * @ORM\Column(name="id_cell", type="integer")
     */
    private $cell;

    /**
     * @ORM\Column(name="path_photo", type="string", length=50)
     */
    private $pathPhoto;

    /**
     * @ORM\Column(name="id_color", type="integer")
     */
    private $color;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

}