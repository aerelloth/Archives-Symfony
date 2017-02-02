<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use AppBundle\Entity\Story;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChroniclesController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    /*public function homepageAction()
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();
        return $this->render('AppBundle:stories:homepage.html.twig', ['articles' => $articles]);
    }*/

    // "articles"

}
