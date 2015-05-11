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
     * @ORM\ManyToOne(targetEntity="Cell", inversedBy="members")
     * @ORM\JoinColumn(name="cell_id", referencedColumnName="id")
     */
    private $cell;

    /**
     * @ORM\Column(name="path_photo", type="string", length=50, nullable=true)
     */
    private $pathPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="Color")
     * @ORM\JoinColumn(name="color_id", referencedColumnName="id")
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
     * @return Cell
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     * @param Cell $cell
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
        $this->color = $color;
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