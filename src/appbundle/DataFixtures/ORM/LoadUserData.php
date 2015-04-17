<?php

/*
 * Use it typing
 *
 * php app/console doctrine:fixtures:load
 *
 *
 *
 * Type
 *
 * php app/console doctrine:database:create
 *
 * to create database
 *
 *
 *
 * Type
 *
 * php app/console doctrine:schema:update --force
 *
 * to update database
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Slide;
use AppBundle\Entity\Cell;
use AppBundle\Entity\Member;
use AppBundle\Entity\MemberRole;
use AppBundle\Entity\Color;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var EntityManager $manager */
        $manager = $this->container->get('doctrine')->getManager();

        $color = new Color();
        $color->setName('red');
        $color->setValue('#ff0000');
        $manager->persist($color);

        $color2 = new Color();
        $color2->setName('green');
        $color2->setValue('#00ff00');
        $manager->persist($color2);

        $role = new MemberRole();
        $role->setName('animatore');
        $manager->persist($role);

        $role = new MemberRole();
        $role->setName('ragazzo');
        $manager->persist($role);

        for ($i = 0; $i < 20 ; $i++) { 
            /** @var Slide $slide */
            $slide = new Slide();
            $slide->setName('Slide ' . $i);
            $slide->setDescription('This is the slide n°' . $i);
            $slide->setDateCreation(date_create(date('Y-m-d H:i:s')));
            $slide->setNotes('Created from data fixtures');
            $manager->persist($slide);
        }

        for ($i = 0; $i < 12 ; $i++) { 
            /** @var Cell $cell */
            $cell = new Cell();
            $cell->setName('Cell ' . ($i + 1));
            $cell->setNotes('Here are some notes of Cell ' . ($i + 1));
            $manager->persist($cell);
        }

        $cell = new Cell();
        $cell->setName('Directive');
        $cell->setNotes('Here are some notes of Directive');
        $manager->persist($cell);

        $member = new Member();
        $member->setFirstName('Paolo');
        $member->setSurname('Rossi');
        $member->setBirthday(date_create('2000-01-01'));
        $member->setLocality('Udine');
        $member->setCellularNumber('3331234567');
        $member->setRole($role);
        $member->setCell($cell);
        $member->setIsActive(true);
        $member->setColor($color);
        $manager->persist($member);

        $member = new Member();
        $member->setFirstName('Rolando');
        $member->setSurname('Bianchi');
        $member->setBirthday(date_create('1997-01-01'));
        $member->setLocality('Gonars');
        $member->setCellularNumber('3339876543');
        $member->setRole($role);
        $member->setCell($cell);
        $member->setIsActive(false);
        $member->setColor($color2);

        $manager->persist($member);
        $manager->flush();
   }
}
