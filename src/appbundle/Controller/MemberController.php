<?php

namespace AppBundle\Controller;

use BS\CRUDBundle\Controller\BSController;
use AppBundle\Form\MemberType;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends BSController
{
    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function partecipationsAction(Request $request, $id = null)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        $member = $this->getRepository()->find($id);

        if ($member == null) {
            $this->get('session')->getFlashBag()->add('error', 'L\'oggetto selezionato non è stato trovato.');
        }

        // tiro fuori le partecipazioni
        $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

        $list = null == $name ? $repo->findAllWithPartecipations($member, $sort, $direction) : $repo->findByNameWithPartecipations($member, $name, $sort, $direction);

        if ($page * 10  > sizeof($list) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($list, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Member/partecipation_list_content.html.twig' : 'Member/partecipation_list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name, 'member' => $member));
    }

    public function newFormType()
    {
        return new MemberType('AppBundle\Entity\Member');
    }

    public function getBaseClass()
    {
        return 'Member';
    }
}
