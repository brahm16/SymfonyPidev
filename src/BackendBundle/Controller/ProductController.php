<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 21/03/2020
 * Time: 00:11
 */

namespace BackendBundle\Controller;

use BackendBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use BackendBundle\Form\PostType;


class ProductController extends Controller
{
    public function addAction(Request $request)
    {

        $produit = new Product();
        $form = $this->createForm(ProductType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $produit->getPhoto();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $produit->setPhoto($filename);
            $produit->setCreator($this->getUser());
            $produit->setPostdate(new \DateTime('now'));

            $em->persist($produit);
            $em->flush();

            $this->addFlash('info', 'Created Successfully !');
        }
        return $this->render('@Backend/Product/add.html.twig', array(
            "Form" => $form->createView()
        ));
    }

    public function listpostAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BackendBundle:Product')->findAll();
        return $this->render('@Backend/Product/list.html.twig', array(
            "posts" => $posts
        ));

    }
}
