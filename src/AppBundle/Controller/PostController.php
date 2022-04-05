<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostController extends Controller
{
    /**
     * @Route("/post", name="view_posts_route")
     */
    public function showAllPostsAction(Request $request)
    {
        // replace this example code with whatever you need
        $post=$this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        
        return $this->render('pages/index.html.twig',['posts'=>$post]);
    }
    /**
     * @Route("/home", name="home_posts_route")
     */
    public function homePostAction()
    {
        // replace this example code with whatever you need
        
        return $this->render('pages/home.html.twig');
    }
    /**
     * @Route("/about", name="about_posts_route")
     */
    public function aboutPostAction()
    {
        // replace this example code with whatever you need
        
        return $this->render('pages/aboutus.html.twig');
    }
    /**
     * @Route("/products", name="products_posts_route")
     */
    public function productsPostAction()
    {
        // replace this example code with whatever you need
        
        return $this->render('pages/products.html.twig');
    }
    /**
     * @Route("/contact", name="contact_posts_route")
     */
    public function contactPostAction()
    {
        // replace this example code with whatever you need
        
        return $this->render('pages/contact.html.twig');
    }
    /**
     * @Route("/create", name="create_post_route")
     */
    public function createPostAction(Request $request)
    {
        // replace this example code with whatever you need
        $post = new Post;
        $form = $this->createFormBuilder($post)
        ->add('title',TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
        ->add('category',TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Create Post','attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:10px')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $title = $form['title']->getData();
            $description = $form['description']->getData();
            $category = $form['category']->getData();

            $post->setTitle($title);
            $post->setTitle($description);
            $post->setTitle($category);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('message','Post Created Successfully!');
            return $this->redirectToRoute('view_posts_route');
        }
        return $this->render('pages/create.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/view/{id}", name="view_post_route")
     */
    public function viewPostAction($id)
    {
        $post=$this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
        
        return $this->render('pages/view.html.twig',['post'=>$post]);
    }
    /**
     * @Route("/edit/{id}", name="edit_post_route")
     */
    public function editPostAction(Request $request, $id)
    {
        $post=$this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
        $post->setTitle($post->getTitle());
        $post->setDescription($post->getDescription());
        $post->setCategory($post->getCategory());
        $form = $this->createFormBuilder($post)
        ->add('title',TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
        ->add('category',TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add('save',SubmitType::class,array('label'=>'Update Post','attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:10px')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();
            
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('AppBundle:Post')->find($id);

            $post->setTitle($title);
            $post->setDescription($description);
            $post->setCategory($category);

            $em->flush();
            $this->addFlash('message','Post Updated Successfully!');
            return $this->redirectToRoute('view_posts_route');
        }
        
        
        return $this->render('pages/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete_post_route")
     */
    public function deletePostAction($id)
    {
        
        // replace this example code with whatever you need
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository('AppBundle:Post')->find($id);
        $em->remove($post);
        $em->flush();
        $this->addFlash('message','Post Deleted Successfully!');
        return $this->redirectToRoute('view_posts_route');
    }

}
