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
     * @ORM\Column(name="school", type="string", length=50, nullable=true)
     */
    private $school;

    /**
     * @ORM\Column(name="live_year", type="string", length=10, nullable=true)
     */
    private $liveYear;

    /**
     * @ORM\Column(name="role", type="string", length=10, nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(name="id_cell", type="integer", nullable=true)
     */
    private $cell;

    /**
     * @ORM\Column(name="path_photo", type="string", length=50, nullable=true)
     */
    private $pathPhoto;

    /**
     * @ORM\Column(name="id_color", type="integer", nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;


    /**
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param string $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @return string
     */
    public function getLiveYear()
    {
        return $this->liveYear;
    }

    /**
     * @param string $liveYear
     */
    public function setLiveYear($liveYear)
    {
        $this->liveYear = $liveYear;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     * @param string $cell
     */
    public function setCell($cell)
    {
        $this->cell = $cell;
    }

    /**
     * @return string
     */
    public function getPathPhoto()
    {
        return $this->pathPhoto;
    }

    /**
     * @param string $pathPhoto
     */
    public function setPathPhoto($pathPhoto)
    {
        $this->pathPhoto = $pathPhoto;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->cell = $color;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param string $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }   

}