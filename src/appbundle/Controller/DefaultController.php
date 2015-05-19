<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\CellRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @MVC\Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @MVC\Route("/home", name="home")
     */
    public function homeAction()
    {
        return $this->render('home.html.twig');
    }
}
