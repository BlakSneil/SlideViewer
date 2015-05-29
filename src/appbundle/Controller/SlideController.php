<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Slide;
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
     * @param Request $request
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id = null)
    {
        //require_once "openslide.php";

    	// TODO: aprire openslide_t* openslide_open	(	const char * 	filename	)	e tenerlo aperto per tutta la richiesta


        $level = $request->query->get('level', 0);
        $x = $request->query->get('x', 0);
        $y = $request->query->get('y', 0);

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        $slide = $this->getRepository()->find($id);

        if ($slide == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
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
        require "openslide.php";
        require "create_deepzoom_tile.php";

        $logger = $this->get('logger');
        $logger->info("TILETILE: $level $x $y");

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var Slide $slide */
        $slide = $this->getRepository()->find($id);

        if ($slide == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
        }

        $tileWidth = 256;
        $tileHeight = 256;
        // $tile_w = 240;
        // $tile_h = 240;


        $tileDir = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/tiles/' . $slide->getId() . "_filess";
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
            $slidePath = $this->get('kernel')->getRootDir() . '/resources/slides/' . $slide->getId() . ".svs";

            createDeepZoomTile($level, $x, $y, $tileWidth, $tileHeight, $slidePath, $tilePath);
    	}

    	$tileFile = file_get_contents($tilePath);

    	$headers = array(
        	'Content-Type'     => 'image/jpeg',
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
        /** @var EntityManager $manager */
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

    /** @return BSRepositoryInterface */
    public function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Slide');
    }

    public function newFormType()
    {
        return new SlideType('AppBundle\Entity\Slide');
    }
}
