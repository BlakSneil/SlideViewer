<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\EventType;

class EventController extends BaseController
{
    protected $baseClass = 'Event';

    /**
     * @MVC\Route("/admin/events", name="admin_event_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        return parent::listAction($request);
    }

    /**
     * @MVC\Route("/admin/event/create", name="admin_event_create")
     * @MVC\Route("/admin/event/edit/{id}", name="admin_event_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        return parent::persistAction($request, $id);
    }

    public function newFormType()
    {
        return new EventType('AppBundle\Entity\Event');
    }
}