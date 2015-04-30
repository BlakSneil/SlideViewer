<?php

namespace AppBundle\Controller;

use BS\CRUDBundle\Controller\BSController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CellType;

class CellController extends BSController
{
    /**
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id = null)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var CellRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Cell');

        /** @var Cell $cell */
        $cell = $repo->find($id);
        if ($cell == null) {
            $this->get('session')->getFlashBag()->add('error', 'La cellula selezionata non è stata trovata.');
        }

        /** @var MemberRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Member');

        $members = null == $name ? $repo->findByCell($cell, $sort, $direction) : $repo->findByCellAndName($cell, $name, $sort, $direction);

        if ($page * 10  > sizeof($members) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($members, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Member/list_content_cell.html.twig' : 'Member/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name, 'cell' => $cell));
    }

    public function navbarListAction()
    {
        /** @var CellRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Cell');

        $cells = $repo->findAll();

        return $this->render('Cell/navbar_list.html.twig', array('cells' => $cells));
    }

    public function newFormType()
    {
        return new CellType('AppBundle\Entity\Cell');
    }

    public function getBaseClass()
    {
        return 'Cell';
    }

    public function getPersistRoute()
    {
        return 'admin_cell_edit';
    }

    public function getListRoute()
    {
        return 'admin_cell_list';
    }
}
