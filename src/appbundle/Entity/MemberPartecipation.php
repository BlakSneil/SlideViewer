<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="member_partecipation")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class MemberPartecipation
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     */
    private $member;

    /**
     * @ORM\OneToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @ORM\Column(name="expected", type="boolean", nullable=true)
     */
    private $expected;

    /**
     * @ORM\Column(name="happened", type="boolean", nullable=true)
     */
    private $happened;

    /**
     * @ORM\Column(name="notes", type="string", nullable=true)
     */
    private $notes;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param string $member
     */
    public function setMember($member)
    {
        $this->member = $member;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }



    /**
     * @return boolean
     */
    public function getExpected()
    {
        return $this->expected;
    }

    /**
     * @param string $expected
     */
    public function setExpected($expected)
    {
        $this->expected = $expected;
    }   

    /**
     * @return boolean
     */
    public function getHappened()
    {
        return $this->happened;
    }

    /**
     * @param string $happened
     */
    public function setHappened($happened)
    {
        $this->happened = $happened;
    }   

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
}