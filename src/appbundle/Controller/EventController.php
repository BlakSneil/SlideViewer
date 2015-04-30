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
        return 'admin_event_edit';
    }

    public function getListRoute()
    {
        return 'admin_event_list';
    }

// nel twig mettere  {% render(controller('AppBundle:Event:partecipations', {'member' : member, 'request' : null})) %}

    public function partecipationsAction(Request $request, $member)
    {
        var_dump("<h4>ciao</h4>");die();

    }
}