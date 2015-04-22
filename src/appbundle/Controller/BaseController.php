<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;

class BaseController extends Controller
{
    protected $baseClass = "BaseClass";

    /**
     * @MVC\Route("/base_class_list", name="base_class_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        $list = null == $name ? $this->getRepo()->findAll($sort, $direction) : $this->getRepo()->findByName($name, $sort, $direction);

        if ($page * 10  > sizeof($list) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($list, $page, 10);

        $twigName = $this->baseClass . ($request->isXmlHttpRequest() ? '/list_content.html.twig' : '/list.html.twig');

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name));
    }

    /**
     * @MVC\Route("/base_class/create", name="base_class_create")
     * @MVC\Route("/base_class/edit/{id}", name="base_class_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        $obj = null != $id ? $this->getRepo()->find($id) : $this->getRepo()->newInstance();

        $form = $this->createForm($this->newFormType(), $obj)->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($obj);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('admin_' . strtolower($this->baseClass) . '_edit', array('id' => $obj->getId())));
        }

        return $this->render($this->baseClass . '/edit.html.twig', array('form' => $form->createView(), 'name' => $obj->getName()));
    }

    public function getRepo()
    {
        return $this->getDoctrine()->getRepository('AppBundle:' . $this->baseClass);
    }

    /** @return AbstractType */
    public function newFormType()
    {
    }
}
