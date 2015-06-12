<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @MVC\Route("/admin", name="admin_home")
     */
    public function indexAction()
    {
        return $this->render('Admin\index.html.twig');
    }
}
