<?php

namespace AppBundle\Controller;

use AppBundle\Form\EventType;
use BS\CRUDBundle\Controller\BSController;

class EventController extends BSController
{
    public function newFormType()
    {
        return new EventType('AppBundle\Entity\Event');
    }

    public function getBaseClass()
    {
        return 'Event';
    }

    public function getPersistRoute()
    {
        return 'event_edit';
    }

    public function getListRoute()
    {
        return 'event_list';
    }
}