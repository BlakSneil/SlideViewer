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
use AppBundle\Entity\Vendor;
use AppBundle\Entity\Slide;

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


        /** inserting vendors **/
        $vendor = new Vendor();
        $vendor->setName("Aperio");
        $vendor->setFileExtension("svs");
        $manager->persist($vendor);

        $vendor->setName("Aperio");
        $vendor->setFileExtension("tif");
        $manager->persist($vendor);

        $vendor->setName("Aperio");
        $vendor->setFileExtension("tiff");
        $manager->persist($vendor);

        $vendor->setName("Hamamatsu");
        $vendor->setFileExtension("vms");
        $manager->persist($vendor);

        $vendor->setName("Hamamatsu");
        $vendor->setFileExtension("vmu");
        $manager->persist($vendor);

        $vendor->setName("Hamamatsu");
        $vendor->setFileExtension("ndpi");
        $manager->persist($vendor);

        $vendor->setName("Leica");
        $vendor->setFileExtension("scn");
        $manager->persist($vendor);

        $vendor->setName("MIRAX");
        $vendor->setFileExtension("mrxs");
        $manager->persist($vendor);

        $vendor->setName("Philips");
        $vendor->setFileExtension("tiff");
        $manager->persist($vendor);

        $vendor->setName("Sakura");
        $vendor->setFileExtension("svslide");
        $manager->persist($vendor);

        $vendor->setName("Trestle");
        $vendor->setFileExtension("tif");
        $manager->persist($vendor);

        $vendor->setName("Ventana");
        $vendor->setFileExtension("bif");
        $manager->persist($vendor);

        $vendor->setName("Ventana");
        $vendor->setFileExtension("tif");
        $manager->persist($vendor);

        $vendor->setName("Generic tiled TIFF");
        $vendor->setFileExtension("tif");
        $manager->persist($vendor);

        $vendor->setName("Generic tiled TIFF");
        $vendor->setFileExtension("tiff");
        $manager->persist($vendor);


        for ($i = 0; $i < 20 ; $i++) { 
            /** @var Slide $slide */
            $slide = new Slide();
            $slide->setName('Slide ' . $i);
            $slide->setDescription('This is the slide n°' . $i);
            $slide->setDateCreation(new DateTime(date('Y-m-d H:i:s')));
            $slide->setNotes('Created from data fixtures');
            $manager->persist($slide);
        }

        $manager->flush();
    }
}
