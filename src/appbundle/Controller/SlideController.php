<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\SlideType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use openslide;

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
        require_once "openslide.php";

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
     * @param id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTileAction(Request $request, $id = null)
    {
        $level = $request->query->get('level', 0);
        $x = $request->query->get('x', 0);
        $y = $request->query->get('y', 0);

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        $obj = $this->getRepository()->find($id);

        if ($obj == null) {
            $this->get('session')->getFlashBag()->add('error', 'La slide selezionata non è stata trovata.');
        }

        // estrae la tile
        $w = 100;
        $h = 100;

        $path = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/avatar.jpg';
        $slide = openslide_open($path);

//        var_dump($slide);
        // if ($slide == NULL) {
        //     echo "File is not supported\n";
        // } else if (openslide_get_error($slide)) {
        //     echo "Failed to open slide: " . openslide_get_error($slide). "\n";
        //     openslide_close($slide);
        // }

        $filePath = $path = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/ciao.png';
//        write_png($slide, $filePath, $x, $y, $level, $w, $h);

        
        $image = "avatar.jpg";
    	//$path = $this->container->get('templating.helper.assets')->getUrl('bundles/app/img/avatar.jpg');
		$path = $this->get('kernel')->getRootDir() . '/../web/bundles/app/img/avatar.jpg';
    	$file = file_get_contents($path);

    	$headers = array(
        	'Content-Type'     => 'image/png',
        	'Content-Disposition' => 'inline; filename="' . $image . '"'
        );
	    return new Response($file, 200, $headers);
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
