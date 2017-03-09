<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use AppBundle\Entity\Story;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StoriesController extends Controller
{

    /**
     * @Route("/stories/add", name="add_story")
     */
    public function addStoryAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        $story = new Story();
        $formulaire = $this -> createFormBuilder($story) -> add('title', TextType::class, array('label' => 'Titre : ')) -> add('text', TextareaType::class, array('label' => 'Texte')) -> add('category', EntityType::class, array('label' => 'Catégorie', 'class' => 'AppBundle:Category', 'choice_label' => 'name')) -> add('Save', SubmitType::class, array('label' => 'Enregistrer')) -> getForm();
        $formulaire -> handleRequest($request);
        if($formulaire -> isSubmitted() && $formulaire -> isValid())
        {
            $story = $formulaire -> getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();
            return $this->redirectToRoute('show_stories');
        }

        return $this -> render('AppBundle:stories:addStory.html.twig', ['formulaire' => $formulaire -> createView()]);
    }

    /**
     * @Route("/stories/show/{id}", name="show_story")
     */
    public function showStoryAction(Story $story)
    {
        $stories = $this->getDoctrine()->getRepository('AppBundle:Story')->findAll();
        return $this->render('AppBundle:stories:showStory.html.twig', ['story' => $story, 'stories' => $stories]);
    }

    /**
     * @Route("/stories/show", name="show_stories")
     */
    public function showStoriesAction()
    {
        $stories = $this->getDoctrine()->getRepository('AppBundle:Story')->findAll();
        return $this->render('AppBundle:stories:showStories.html.twig', ['stories' => $stories]);
    }

    /**
     * @Route("/stories/update/{id}", name="update_story")
     */
    public function updateStoryAction(Request $request, Story $story)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        //$story = new Story();
        $formulaire = $this -> createFormBuilder($story) -> add('title', TextType::class, array('label' => 'Titre : ')) -> add('text', TextareaType::class, array('label' => 'Texte')) -> add('category', EntityType::class, array('label' => 'Catégorie', 'class' => 'AppBundle:Category', 'choice_label' => 'name')) -> add('Save', SubmitType::class, array('label' => 'Enregistrer')) -> getForm();
        $formulaire -> handleRequest($request);
        if($formulaire -> isSubmitted() && $formulaire -> isValid())
        {
            $story = $formulaire -> getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();
            return $this->redirectToRoute('show_stories');
        }
        return $this -> render('AppBundle:stories:updateStory.html.twig', ['formulaire' => $formulaire -> createView()]);
    }

    /**
     * @Route("/stories/remove/{id}", name="remove_story")
     */
    public function removeStoryAction(Story $story)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        $em = $this -> getDoctrine()->getManager();
        $em->remove($story);
        $em->flush();
        return $this->redirectToRoute('show_stories');
    }

}
