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
use FOS\UserBundle\Model\UserManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;

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


        /* inserting vendors */
        $aperio = new Vendor();
        $aperio->setName("Aperio");
        $aperio->setFileExtension("svs");
        $manager->persist($aperio);

        $vendor = new Vendor();
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


        /* Inserting slides */
        $slide = new Slide();
        $slide->setName('JP2K-33003-1');
        $slide->setDescription('JP2K-33003-1');
        $slide->setDateCreation(new DateTime(date('Y-m-d H:i:s')));
        $slide->setWidth(15374);
        $slide->setHeight(17497);
        $slide->setTileDim(256);
        $slide->setVendor($aperio);
        $slide->setNotes('Info collected from http://openslide.org/demo/');
        $manager->persist($slide);

        $slide = new Slide();
        $slide->setName('CMU-1');
        $slide->setDescription('CMU-1');
        $slide->setDateCreation(new DateTime(date('Y-m-d H:i:s')));
        $slide->setWidth(46000);
        $slide->setHeight(32914);
        $slide->setTileDim(256);
        $slide->setVendor($aperio);
        $slide->setNotes('Info collected from http://openslide.org/demo/');
        $manager->persist($slide);

        $slide = new Slide();
        $slide->setName('CMU-1-Small-Region');
        $slide->setDescription('CMU-1-Small-Region');
        $slide->setDateCreation(new DateTime(date('Y-m-d H:i:s')));
        $slide->setWidth(2220);
        $slide->setHeight(2967);
        $slide->setTileDim(256);
        $slide->setVendor($aperio);
        $slide->setNotes('Info collected from http://openslide.org/demo/');
        $manager->persist($slide);


        /* Inserting users */

        /** @var UserManager $fosUserManager */
        $fosUserManager = $this->container->get('fos_user.user_manager');

        /** @var User $user */
        $user = $fosUserManager->createUser();
        $user->setUsername('admin');
        $user->setPlainPassword('password');
        $user->setEmail('admin@mail.com');
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMIN');

        $fosUserManager->updateUser($user);

        for ($i = 1; $i <= 20; $i++) {
            $user = $fosUserManager->createUser();
            $user->setUsername('paolo.rossi.' . $i);
            $user->setPlainPassword('password');
            $user->setEmail('paolo.rossi.' . $i . '@mail.com');
            $user->setEnabled($i % 2);

            $fosUserManager->updateUser($user);
        }

        /* inserting roles */

        /** @var Role $role */
        $role = new Role();
        $role->setName('admin');
        $role->setRole('ROLE_ADMIN');
        $manager->persist($role);

        $role = new Role();
        $role->setName('user');
        $role->setRole('ROLE_USER');
        $manager->persist($role);

        /* flushing all... */
        $manager->flush();
    }
}
