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

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Slide;
use AppBundle\Entity\Cell;
use AppBundle\Entity\Member;
use AppBundle\Entity\LiveYear;
use AppBundle\Entity\Color;
use AppBundle\Entity\Event;

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

        for ($i = 0; $i < 20 ; $i++) { 
            /** @var Slide $slide */
            $slide = new Slide();
            $slide->setName('Slide ' . $i);
            $slide->setDescription('This is the slide n°' . $i);
            $slide->setDateCreation(new DateTime(date('Y-m-d H:i:s')));
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

        for ($i = 1; $i <= 5 ; $i++) { 
            /** @var LiveYear $liveYear */
            $liveYear = new LiveYear();
            $liveYear->setName($i);
            $manager->persist($liveYear);
        }
        $liveYear = new LiveYear();
        $liveYear->setName('CRA');
        $manager->persist($liveYear);

        $cell = new Cell();
        $cell->setName('Directive');
        $cell->setNotes('Here are some notes of Directive');
        $manager->persist($cell);

        $member = new Member();
        $member->setFirstName('Paolo');
        $member->setSurname('Rossi');
        $member->setBirthday(new DateTime('2000-01-01'));
        $member->setLocality('Udine');
        $member->setCellularNumber('3331234567');
        $member->setLiveYear('2');
        $member->setCell($cell);
        $member->setIsActive(true);
        $member->setColor($color);
        $manager->persist($member);

        $member = new Member();
        $member->setFirstName('Rolando');
        $member->setSurname('Bianchi');
        $member->setBirthday(new DateTime('1997-01-01'));
        $member->setLocality('Gonars');
        $member->setCellularNumber('3339876543');
        $member->setLiveYear('CRA');
        $member->setCell($cell);
        $member->setIsActive(false);
        $member->setColor($color2);
        $manager->persist($member);

        $event = new Event();
        $event->setName('Domenica Live maggio 2015');
        $event->setDescription('La Domenica Live che si tiene a maggio 2015');
        $event->setDateFrom(new DateTime('2015-05-17'));
        $event->setDateTo(new DateTime('2015-05-17'));
        $event->setLocality("Udine");
        $manager->persist($event);

        $event = new Event();
        $event->setName('Domenica Live aprile 2015');
        $event->setDescription('La Domenica Live che si tiene ad aprile 2015');
        $event->setDateFrom(new DateTime('2015-04-19'));
        $event->setDateTo(new DateTime('2015-04-19'));
        $event->setLocality("Santa Maria La Longa");
        $manager->persist($event);

        $event = new Event();
        $event->setName('Campo Live 2015');
        $event->setDescription('Campo Live estivo 2015');
        $event->setDateFrom(new DateTime('2015-08-03'));
        $event->setDateTo(new DateTime('2015-08-09'));
        $event->setLocality("Pierabech");
        $manager->persist($event);

        $manager->flush();
    }
}
