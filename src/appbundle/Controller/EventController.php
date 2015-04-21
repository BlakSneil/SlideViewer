<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;

class EventController extends Controller
{
    /**
     * @MVC\Route("/events", name="event_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

        $events = null == $name ? $repo->findAll($sort, $direction) : $repo->findByName($name, $sort, $direction);

        if ($page * 10  > sizeof($events) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($events, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Event/list_content.html.twig' : 'Event/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name));
    }

    /**
     * @MVC\Route("/event/view/{id}", name="event_view")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

        /** @var Event $event */
        $event = $repo->find($id);

        if ($event == null) {
            $this->get('session')->getFlashBag()->add('error', 'L\'evento selezionato non è stato trovato.');
        }

        return $this->render('Event/view.html.twig', array('event' => $event));
    }

    /**
     * @MVC\Route("/event/create", name="event_create")
     * @MVC\Route("/event/edit/{id}", name="event_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

        /** @var Event $event */
        $event = null != $id ? $repo->find($id) : new Event();

        $form = $this->createForm(new EventType('AppBundle\Entity\Event'), $event)
            ->handleRequest($request);

        if ($form->isValid()) {
            
            $manager->persist($event);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('event_edit', array('id' => $event->getId())));
        }

        return $this->render('Event/edit.html.twig', array('form' => $form->createView(), 'name' => $event->getName()));
    }
}
