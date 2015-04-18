<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Cell;
use AppBundle\Entity\Repository\CellRepository;
use AppBundle\Form\CellType;

class CellController extends Controller
{
    /**
     * @MVC\Route("/cells", name="admin_cell_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        /** @var CellRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Cell');

        $cells = null == $name ? $repo->findAll($sort, $direction) : $repo->findByName($name, $sort, $direction);

        if ($page * 10  > sizeof($cells) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($cells, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Cell/list_content.html.twig' : 'Cell/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name, 'cells' => $cells));
    }

    /**
     * @MVC\Route("/cell/view/{id}", name="cell_view")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var CellRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Cell');

        /** @var Cell $cell */
        $cell = $repo->find($id);

        if ($cell == null) {
            $this->get('session')->getFlashBag()->add('error', 'La cellula selezionata non è stata trovata.');
        }

        // TODO: cercare i membri di quella cellula e visualizzarli
        $members = $repo->findCell($cell->getId(), $sort, $direction);

        return $this->render('Members/list.html.twig', array('cell' => $cell, 'members' => $members));
    }

    /**
     * @MVC\Route("/admin/cell/create", name="admin_cell_create")
     * @MVC\Route("/admin/cell/edit/{id}", name="admin_cell_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var CellRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Cell');


        /** @var Cell $cell */
        $cell = null != $id ? $repo->find($id) : new Cell();

        $form = $this->createForm(new CellType('AppBundle\Entity\Cell'), $cell)
            ->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($cell);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('cell_edit', array('id' => $cell->getId())));
        }

        return $this->render('Cell/edit.html.twig', array('form' => $form->createView(), 'name' => $cell->getName()));
    }

    public function navbarListAction()
    {
        /** @var CellRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Cell');

        $cells = $repo->findAll();

        return $this->render('Cell/navbar_list.html.twig', array('cells' => $cells));
    }
}
