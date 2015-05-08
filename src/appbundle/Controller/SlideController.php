<?php

namespace AppBundle\Controller;

use BS\CRUDBundle\Controller\BSController;
use AppBundle\Form\SlideType;

class SlideController extends BSController
{
    public function newFormType()
    {
        return new SlideType('AppBundle\Entity\Slide');
    }

    public function getBaseClass()
    {
        return 'Slide';
    }
}
