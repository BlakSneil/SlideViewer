<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SlideType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SlideController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $name = $request->query->get('name', null);
        $page = $request->query->get('page', 1);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);

        $list = null == $name ? $this->getRepository()->findAll($sort, $direction) : $this->getRepository()->findByName($name, $sort, $direction);

        if ($page * 10  > sizeof($list) + 10) {
            $page = 1;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($list, $page, 10);

        $twigName = 'Slide' . ($request->isXmlHttpRequest() ? '/list_content.html.twig' : '/list.html.twig');

        return $this->render($twigName, array('pagination' => $pagination, 'name' => $name));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id = null)
    {
        $slide = $this->getRepository()->find($id);

        if ($slide == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
            return $this->redirect($this->generateUrl('slide_list'));
        }

        return $this->render('Slide/view.html.twig', array('slide' => $slide));
    }

    /**
     * @param $id
     * @param $level
     * @param $x
     * @param $y
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTileAction($id = null, $level = 0, $x = 0, $y = 0)
    {
//        require "openslide.php";
        require "create_deepzoom_tile.php";

        /** @var \AppBundle\Entity\Slide $slide */
        $slide = $this->getRepository()->find($id);

        if ($slide == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
        }

//        $logger = $this->get('logger');
//        $logger->info('CIAO' . $slide->getVendor()->getFileExtension());

        $tileDir = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/tiles/' . $id . "_files";
        if (!file_exists($tileDir)) {
            mkdir($tileDir);
        }
        $tileDir = $tileDir . "/" . $level;
        if (!file_exists($tileDir)) {
            mkdir($tileDir);
        }
        $tileFilename = $x . "_" . $y . ".jpeg";
        $tilePath = $tileDir . "/" . $tileFilename;

        if (!file_exists($tilePath)) {
            $slidePath = $this->get('kernel')->getRootDir() . '/resources/slides/' . $id . "." . $slide->getVendor()->getFileExtension();

//            $logger = $this->get('logger');
//            $logger->info('CIAO ' . $slidePath);

            createDeepZoomTile($level, $x, $y, $slide->getTileDim(), $slidePath, $tilePath);
    	}

    	$tileFile = file_get_contents($tilePath);

    	$headers = array(
        	'Content-Type' => 'image/jpeg',
        	'Content-Disposition' => 'inline; filename="' . $tileFilename . '"'
        );
        
	    return new Response($tileFile, 200, $headers);
    }

    /**
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function persistAction(Request $request, $id = null)
    {
        /** @var \Doctrine\ORM\EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        $slide = null != $id ? $this->getRepository()->find($id) : $this->getRepository()->newInstance();

        $form = $this->createForm($this->newFormType(), $slide)->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($slide);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('slide_edit', array('id' => $slide->getId())));
        }

        return $this->render('Slide/edit.html.twig', array('form' => $form->createView(), 'slide' => $slide));
    }

    /** @return \AppBundle\Entity\Repository\SlideRepository */
    public function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Slide');
    }

    public function newFormType()
    {
        return new SlideType('AppBundle\Entity\Slide');
    }
}
