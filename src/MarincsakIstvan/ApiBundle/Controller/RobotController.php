<?php

namespace MarincsakIstvan\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

use FOS\RestBundle\Controller\FOSRestController;
use MarincsakIstvan\ApiBundle\Service\ResponseFormatter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View AS FOSView;

use MarincsakIstvan\ApiBundle\Entity\Robot;
use MarincsakIstvan\ApiBundle\Form\RobotType;

class RobotController extends FOSRestController {

    /**
     * @GET("/robots/owerview")
     */
    public function overviewAction() {

    }

    /**
     * @GET("/robots/{id}")
     * @param $id
     */
    public function getOneRobotAction($id) {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robot = $em->getRepository('MarincsakIstvanApiBundle:Robot')->find($id);

        if($robot) {
            $responseObj->setStatus(ResponseFormatter::STATUS_FOUND);
            $responseObj->setData($robot);

            return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
        }

        $responseObj->setStatus(ResponseFormatter::STATUS_NOT_FOUND);

        return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
    }

    /**
     * @Post("/robot")
     */
    public function createRobotAction(Request $request) {
//        echo "df";exit;
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $em = $this->getDoctrine()->getManager();
        $view = FOSView::create();
        $robot = new Robot();

        $form = $this->createForm(new RobotType(), $robot,  array(
            'em' => $em,
        ));

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em->persist($robot);
            $em->flush();
            $responseObj->setStatus(ResponseFormatter::STATUS_CREATED);
            $responseObj->setData($robot);

            return $view->setStatusCode(Codes::HTTP_CREATED)->setData($responseObj);
        } else {
            $responseObj->setStatus(ResponseFormatter::STATUS_ERROR);
            $responseObj->setMessage($responseObj->getAllErrorAsString($form));

            return $view->setStatusCode(Codes::HTTP_CONFLICT)->setData($responseObj);
        }
    }

    /**
     * @Put("/robots/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function updateAction(Request $request, $id) {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robot = $em->getRepository('MarincsakIstvanApiBundle:Robot')->find($id);

        if(!$robot) {
            $responseObj->setStatus(ResponseFormatter::STATUS_NOT_FOUND);
            $responseObj->setMessage(ResponseFormatter::MSG_NOT_FOUND);
            return $view->setStatusCode(Codes::HTTP_CONFLICT)->setData($responseObj);
        }

        $form = $this->createForm(new RobotType(), $robot);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em->flush();
            $responseObj->setStatus(ResponseFormatter::STATUS_UPDATED);
            $responseObj->setData($robot);

            return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
        } else {
            $responseObj->setStatus(ResponseFormatter::STATUS_ERROR);
            $responseObj->setMessage($responseObj->getAllErrorAsString($form));

            return $view->setStatusCode(Codes::HTTP_CONFLICT)->setData($responseObj);
        }
    }

    /**
     * @Delete("/robots/{id}")
     * @param $id
     * @return FOSView
     */
    public function deleteAction($id) {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robot = $em->getRepository('MarincsakIstvanApiBundle:Robot')->find($id);

        if(!$robot) {
            $responseObj->setStatus(ResponseFormatter::STATUS_ERROR);
            $responseObj->setMessage(ResponseFormatter::MSG_NOT_FOUND);
            return $view->setStatusCode(Codes::HTTP_CONFLICT)->setData($responseObj);
        }

        $em->remove($robot);
        $em->flush();
        $responseObj->setStatus(ResponseFormatter::STAUS_DELETED);
        return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
    }

    /**
     * @GET("/robots")
     */
    public function allAction() {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robots = $em->getRepository('MarincsakIstvanApiBundle:Robot')->findAll();

        $responseObj->setStatus(ResponseFormatter::STATUS_OK);
        $responseObj->setData($robots);

        return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
    }


    /**
     * @GET("/robots/search/{name}")
     * @param $name
     * @return FOSView
     */
    public function searchAction($name) {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robot = $em->getRepository('MarincsakIstvanApiBundle:Robot')->findByName($name);

        if(!$robot) {
            $responseObj->setStatus(ResponseFormatter::STATUS_NOT_FOUND);
            return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
        }

        $responseObj->setStatus(ResponseFormatter::STATUS_OK);
        $responseObj->setData($robot);
        return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
    }

    /**
     * @GET("/robots/filter")
     * @return FOSView
     */
    public function filterAction() {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robotTypes = $em->getRepository('MarincsakIstvanApiBundle:Robot')->getAllType();
        $responseObj->setStatus(ResponseFormatter::STATUS_OK);

        $responseObj->setData($robotTypes);
        return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
    }

    /**
     * @GET("/robots/filter/{name}")
     * @return FOSView
     */
    public function filterByTypeAction($name) {
        $responseObj = $this->get('marincsak_istvan_api.response_formatter');
        $view = FOSView::create();

        $em = $this->getDoctrine()->getManager();
        $robots = $em->getRepository('MarincsakIstvanApiBundle:Robot')
            ->findRobotsByTypeName($name);

        if($robots) {
            $responseObj->setStatus(ResponseFormatter::STATUS_FOUND);
            $responseObj->setData($robots);
            return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
        }

        $responseObj->setStatus(ResponseFormatter::STATUS_NOT_FOUND);
        return $view->setStatusCode(Codes::HTTP_OK)->setData($responseObj);
    }

}