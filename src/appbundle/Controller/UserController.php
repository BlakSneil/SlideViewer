<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserType;
use FOS\UserBundle\Model\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as MVC;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @MVC\Route("/admin/users", name="admin_user_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $username = $request->query->get('username', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        /** @var UserRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:User');

        $users = null == $username ? $repo->findAll($sort, $direction) : $repo->findByName($username, $sort, $direction);

        if ($page * 10  > sizeof($users) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($users, $page, 10);

        $twigName = $request->isXmlHttpRequest() ? 'Admin/User/list_content.html.twig' : 'Admin/User/list.html.twig';

        return $this->render($twigName, array('pagination' => $pagination, 'username' => $username));
    }

    /**
     * @MVC\Route("/admin/user/create", name="admin_user_create")
     * @MVC\Route("/admin/user/edit/{username}", name="admin_user_edit")
     * @param Request $request
     * @param $username
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $username = null)
    {
        /** @var UserManager $manager */
        $manager = $this->container->get('fos_user.user_manager');

        $user = (null != $username) ? $manager->findUserByUsername($username) : $manager->createUser();

        $form = $this->createForm('app_bundle_user_type', $user)->handleRequest($request);

        if ($form->isValid()) {

            $manager->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('admin_user_edit', array('username' => $user->getUsername())));
        }

        return $this->render('Admin/User/edit.html.twig', array('form' => $form->createView(), 'username' => $user->getUsername()));
    }

    /**
     * @MVC\Route("/admin/user/changepassword/{username}", name="admin_user_change_password")
     * @param Request $request
     * @param $username
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request, $username = null)
    {
        /** @var UserManager $manager */
        $manager = $this->container->get('fos_user.user_manager');

        $user = (null != $username) ? $manager->findUserByUsername($username) : $manager->createUser();

        $form = $this->createForm(new UserPasswordType('AppBundle\Entity\User'), $user)
            ->handleRequest($request);

        if ($form->isValid()) {

            $manager->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('admin_user_edit', array('username' => $user->getUsername())));
        }

        return $this->render('AppBundle:Admin:User/edit.html.twig', array('form' => $form->createView(), 'username' => $user->getUsername()));
    }
}
