<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use AppBundle\Entity\Story;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoriesController extends Controller
{
    /**
     * @Route("/categories/add", name="add_category")
     */
    public function addCategoryAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        $category = new Category();
        $formulaire = $this -> createFormBuilder($category) -> add('name', TextType::class, array('label' => 'Nom : ')) -> add('Save', SubmitType::class, array('label' => 'Enregistrer')) -> getForm();
        $formulaire -> handleRequest($request);
        if($formulaire -> isSubmitted() && $formulaire -> isValid())
        {
            $category = $formulaire -> getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('show_categories');
        }

        return $this -> render('AppBundle:stories:addCategory.html.twig', ['formulaire' => $formulaire -> createView()]);
    }

    /**
     * @Route("/categories/show/{id}", name="show_category")
     */
    public function showCategoryAction(Category $category)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        return $this->render('AppBundle:stories:showCategory.html.twig', ['category' => $category]);
    }

    /**
     * @Route("/categories/show", name="show_categories")
     */
    public function showCategoriesAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('AppBundle:stories:showCategories.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/categories/update/{id}", name="update_category")
     */
    public function updateCategoryAction(Request $request, Category $category)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        //$category = new Category();
        $formulaire = $this -> createFormBuilder($category) -> add('name', TextType::class, array('label' => 'Nom : ')) -> add('Save', SubmitType::class, array('label' => 'Enregistrer')) -> getForm();
        $formulaire -> handleRequest($request);
        if($formulaire -> isSubmitted() && $formulaire -> isValid())
        {
            $category = $formulaire -> getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('show_categories');
        }
        return $this -> render('AppBundle:stories:updateCategory.html.twig', ['formulaire' => $formulaire -> createView()]);
    }

    /**
     * @Route("/categories/remove/{id}", name="remove_category")
     */
    public function removeCategoryAction(Category $category)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'êtes pas autorisé à accéder à cette page !');
        $em = $this -> getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('show_categories');
    }
}
