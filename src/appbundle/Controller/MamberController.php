<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Slide;
use AppBundle\Entity\Repository\SlideRepository;
use AppBundle\Form\SlideType;

class SlideController extends Controller
{
    /**
     * @MVC\Route("/slides", name="slide_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        /** @var SlideRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Slide');

        $slides = null == $name ? $repo->findAll($sort, $direction) : $repo->findByName($name, $sort, $direction);

        if ($page * 10  > sizeof($slides) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($slides, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Slide/list_content.html.twig' : 'Slide/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name));
    }

    /**
     * @MVC\Route("/slide/view/{id}", name="slide_view")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var RoleRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Slide');

        /** @var Slide $slide */
        $slide = $repo->find($id);

        if ($slide == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
        }

        return $this->render('Slide/view.html.twig', array('slide' => $slide));
    }

    /**
     * @MVC\Route("/slide/create", name="slide_create")
     * @MVC\Route("/slide/edit/{id}", name="slide_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var RoleRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Slide');


        /** @var Slide $slide */
        $slide = null != $id ? $repo->find($id) : new Slide();

        $form = $this->createForm(new SlideType('AppBundle\Entity\Slide'), $slide)
            ->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($slide);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('slide_edit', array('id' => $slide->getId())));
        }

        return $this->render('Slide/edit.html.twig', array('form' => $form->createView(), 'name' => $slide->getName()));
    }
}
