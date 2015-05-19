<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Slide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SlideType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use AppBundle\Controller\openslide;

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

        $obj = $this->getRepository()->find($id);

        if ($obj == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
        }

        return $this->render('Slide/view.html.twig', array('obj' => $obj));
    }

    /**
     * @param $id
     * @param $level
     * @param $x
     * @param $y
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTileAction($id = null, $level = 0, $x = 0, $y = 0, $tile_w = 240, $tile_h = 240)
    {
        // $level = $request->query->get('level', 0);
        // $x = $request->query->get('x', 0);
        // $y = $request->query->get('y', 0);
        //die($x . $y . $level . $w . $h);

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var Slide $obj */
        $obj = $this->getRepository()->find($id);

        if ($obj == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
        }

        // $tile_w = 256;
        // $tile_h = 256;
        // $tile_w = 240;
        // $tile_h = 240;

        $pngDir = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/tiles/' . $obj->getId() . "/";
        if (!file_exists($pngDir)) {
        	mkdir($pngDir);
        }
        $pngFilename = $level . "_" . $x . "_" . $y . ".png";
        $pngPath = $pngDir . $pngFilename;

        if (!file_exists($pngPath)) {
	        $slidePath = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/test.svs';
            $slidePath = $this->get('kernel')->getRootDir() . '/resources/slides/' . $obj->getId() . ".svs";

	        $slide = openslide_open($slidePath);

	        if ($slide == NULL) {
	            echo "File is not supported.\n";
	        } else if (openslide_get_error($slide)) {
	            echo "Failed to open slide: " . openslide_get_error($slide). ".\n";
	            openslide_close($slide);
	        } else

	        // TODO: png progressiva?
	        write_png($slide, $pngPath, $x, $y, $level, $tile_w, $tile_h);

	        openslide_close($slide);
    	}

    	$pngFile = file_get_contents($pngPath);

    	$headers = array(
        	'Content-Type'     => 'image/png',
        	'Content-Disposition' => 'inline; filename="' . $pngFilename . '"'
        );
        
	    return new Response($pngFile, 200, $headers);
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

        $obj = null != $id ? $this->getRepository()->find($id) : $this->getRepository()->newInstance();

        $form = $this->createForm($this->newFormType(), $obj)->handleRequest($request);

        if ($form->isValid()) {

            $manager->persist($obj);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le modifiche sono state salvate con successo.');

            return $this->redirect($this->generateUrl('slide_edit', array('id' => $obj->getId())));
        }

        return $this->render('Slide/edit.html.twig', array('form' => $form->createView(), 'obj' => $obj));
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
