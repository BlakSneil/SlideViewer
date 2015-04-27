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

// nel twig mettere  {% render(controller('AppBundle:Event:partecipations', {'member' : member, 'request' : null})) %}

    public function partecipationsAction($member, Request $request = null)
    {
    	if (null != $request) {
	        //$name = $request->query->get('name', null);
	        $page = $request->query->get('page', 1);
	        $sort = $request->query->get('sort', 'dateFrom');
	        $direction = $request->query->get('direction', 'DESC');
	    }

    	$events = $this->getRepository()->findByNameWithPartecipations($member, $orderBy = null, $direction = 'ASC');

        return $this->render('Event/partecipations.html.twig', array('events' => $events));
    }
}