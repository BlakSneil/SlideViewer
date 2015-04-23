<?php

namespace AppBundle\Controller;

use AppBundle\Form\EventType;
use BS\CRUDBundle\Controller\BSController;

class EventController extends BSController
{
    protected $baseClass = 'Event';

    public function newFormType()
    {
        return new EventType('AppBundle\Entity\Event');
    }

    public function getBaseClass()
    {
        return 'Event';
    }
}