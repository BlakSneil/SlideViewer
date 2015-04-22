<?php

namespace AppBundle\Controller;

use AppBundle\Form\EventType;

class EventController extends BaseController
{
    protected $baseClass = 'Event';

    public function newFormType()
    {
        return new EventType('AppBundle\Entity\Event');
    }
}