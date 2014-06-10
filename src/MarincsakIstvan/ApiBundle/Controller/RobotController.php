<?php

namespace MarincsakIstvan\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Patch;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\View AS FOSView;


use MarincsakIstvan\ApiBundle\Entity\Robot;
use MarincsakIstvan\ApiBundle\Form\RobotType;

class RobotController extends FOSRestController {

    /**
     * Post Route annotation.
     * @Post("/rob/{id}")
     */
    public function getRobotAction($id) {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MarincsakIstvanApiBundle:Robot')->find($id);
        if ($entity) {
            return $view->setStatusCode(Codes::HTTP_OK)->setData($entity);
        }
        return $view->setStatusCode(404)->setData($entity);
    }

    /**
     * @param $id
     * @return View
     * @Patch("/rob/{id}")
     */
    public function testRobotAction($id) {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('MarincsakIstvanApiBundle:Robot')->find($id);
        $obj = new \stdClass();
        $obj->message = "fasszom";
        $obj->data = $data;
//        var_dump($obj); exit;

        if ($data) {
            return $view->setStatusCode(Codes::HTTP_OK)->setData($obj);
        }
        return $view->setStatusCode(404)->setData($obj);
    }
}