<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Member;
use AppBundle\Entity\Repository\MemberRepository;
use AppBundle\Form\MemberType;

class MemberController extends Controller
{
    /**
     * @MVC\Route("/members", name="member_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        /** @var MemberRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Member');

        $members = null == $name ? $repo->findAll($sort, $direction) : $repo->findByName($name, $sort, $direction);


        if ($page * 10  > sizeof($members) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($members, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Member/list_content.html.twig' : 'Member/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name));
    }

    /**
     * @MVC\Route("/member/view/{id}", name="member_view")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var MemberRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Member');

        /** @var Member $member */
        $member = $repo->find($id);

        if ($member == null) {
            $this->get('session')->getFlashBag()->add('error', 'Il member selezionata non è stata trovata.');
        }

        return $this->render('Member/view.html.twig', array('member' => $member));
    }

    /**
     * @MVC\Route("/member/create", name="member_create")
     * @MVC\Route("/member/edit/{id}", name="member_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var MemberRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Member');


        /** @var Member $member */
        $member = null != $id ? $repo->find($id) : new Member();

        $form = $this->createForm(new MemberType('AppBundle\Entity\Member'), $member)
            ->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($member);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('member_edit', array('id' => $member->getId())));
        }

        return $this->render('Member/edit.html.twig', array('form' => $form->createView(), 'name' => $member->getFirstName() . ' ' . $member->getSurname()));
    }
}
