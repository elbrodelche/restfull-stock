<?php
/**
 * Created by PhpStorm.
 * User: Roverandom
 * Date: 28/5/17
 * Time: 20:44
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Stock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class StockController extends FOSRestController
{
    /**
     * @Rest\Get("/v1/stock")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Stock')->findAll();
        if ($restresult === null) {
            return new View("There are no stock", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/v1/product/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Stock')->find($id);
        if ($singleresult === null) {
            return new View("Stock not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/v1/product/")
     */
    public function postAction(Request $request)
    {
        $data = new Stock();
        $prod = $request->get('producto');
        $desc = $request->get('descripcion');
        $cant = $request->get('cantidad');
        if (empty($prod) || empty($desc) || empty($cant)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setProducto($prod);
        $data->setDescripcion($desc);
        $data->setCantidad($cant);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Product Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/v1/product/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $data = new Stock();
        $prod = $request->get('producto');
        $desc = $request->get('descripcion');
        $cant = $request->get('cantidad');
        $sn = $this->getDoctrine()->getManager();
        $stock = $this->getDoctrine()->getRepository('AppBundle:Stock')->find($id);
        if (empty($stock)) {
            return new View("Product not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($prod) && !empty($desc) && !empty($cant)){
            $stock->setProducto($prod);
            $stock->setDescripcion($desc);
            $stock->setCantidad($cant);
            $sn->flush();
            return new View("Product Updated Successfully", Response::HTTP_OK);
        }
        elseif(empty($prod) && !empty($desc)){
            $stock->setDescripcion($desc);
            $sn->flush();
            return new View("Description Updated Successfully", Response::HTTP_OK);
        }
        elseif(empty($prod) && !empty($cant)){
            $stock->setCantidad($cant);
            $sn->flush();
            return new View("Quantity Updated Successfully", Response::HTTP_OK);
        }
        elseif(!empty($prod)){
            $stock->setProducto($prod);
            $sn->flush();
            return new View("Product Name Updated Successfully", Response::HTTP_OK);
        }
        else return new View("Product name cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
    * @Rest\Delete("/v1/product/{id}")
    */
    public function deleteAction($id)
    {
        $data = new Stock();
        $sn = $this->getDoctrine()->getManager();
        $stock = $this->getDoctrine()->getRepository('AppBundle:Stock')->find($id);
        if (empty($stock)) {
            return new View("Product not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($stock);
            $sn->flush();
        }
        return new View("Deleted successfully", Response::HTTP_OK);
    }

}

