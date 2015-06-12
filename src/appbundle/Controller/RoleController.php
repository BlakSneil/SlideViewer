<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\Repository\RoleRepository;
use AppBundle\Form\RoleType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{
    /**
     * @MVC\Route("/admin/roles", name="admin_role_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);


        /** @var RoleRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Role');

        $roles = null == $name ? $repo->findAll($sort, $direction) : $repo->findByName($name, $sort, $direction);

        if ($page * 10  > sizeof($roles) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($roles, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Admin/Role/list_content.html.twig' : 'Admin/Role/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name));
    }

    /**
     * @MVC\Route("/admin/role/create", name="admin_role_create")
     * @MVC\Route("/admin/role/edit/{id}", name="admin_role_edit")
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var RoleRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:Role');


        /** @var Role $role */
        $role = null != $id ? $repo->find($id) : new Role();

        $form = $this->createForm(new RoleType('AppBundle\Entity\Role'), $role)
            ->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($role);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('admin_role_edit', array('id' => $role->getId())));
        }

        return $this->render('Admin/Role/edit.html.twig', array('form' => $form->createView(), 'name' => $role->getName()));
    }
}
