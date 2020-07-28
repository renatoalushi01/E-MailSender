<?php

namespace App\Controller;
use App\Entity\Emails;
use App\Entity\User;
use DateTime;
use Doctrine\DBAL\Types\DateTimeType as TypesDateTimeType;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmailController extends Controller 
{
    /**
     * @Route("/index",name="index")
     * Method({"GET"})
     */
    public function Index()
    {
      $user = $this->getUser()->getId();
      if( $user > 1 )
      {
        $emails= $this->getDoctrine()->getRepository(Emails::class)->findBy(array('usr_id' => $user));
      }
      else
      {
        $emails= $this->getDoctrine()->getRepository(Emails::class)->findall();
      }
        return $this->render('Email/index.html.twig', array('mail' => $emails));
    }

     /**
     * @Route("/Email/new")
     * Method({"GET","POST"})
     */

    public function new(Request $request)
    {
      $userid = $this->getUser()->getId();
        $mails=new Emails();
        $form= $this->createFormBuilder($mails)->add('too' ,TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('subject', TextType::class, array(
           'attr' => array('class' => 'form-control')))
           ->add('body', TextareaType::class, array(
               'required' => false,
               'attr' => array('class' => 'form-control')
             ))->add('date' , DateTimeType::class,array('attr'=> array('class'=> 'form-date')))
             ->add('usr_id' , EntityType::class ,[
               'class' => 'App\Entity\User',
               'query_builder' => function(EntityRepository $er){
                $userid = $this->getUser()->getId();
                 return $er->createQueryBuilder('e')
                           ->where('e.id = :u_id')
                           ->setParameter('u_id', $userid);                 
               }
             ])
             ->add('save', SubmitType::class, array(
               'label' => 'Send',
               'attr' => array('class' => 'btn btn-primary mt-3')
             ))
             ->getForm();

             $form->handleRequest($request);

             if($form->isSubmitted() && $form->isValid()) {
              $mails=$form->getData();
              
              
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($mails);
               $entityManager->flush();

               return $this->redirectToRoute("/index");
            }
             return $this->render('Email/new.html.twig', array(
               'form' => $form->createView()
             ));

    
    }
      /**
      * @Route("Email/edit/{id}")
      * Method({"GET","POST"})
      */
      public function edit(Request $request,$id)
      {
         $mails=new Emails();
         $mails = $this->getDoctrine()->getRepository(Emails::class)->find($id);

         $form= $this->createFormBuilder($mails)->add('too' ,TextType::class, array('attr' => array('class' => 'form-control')))
         ->add('subject', TextType::class, array(
            'attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'attr' => array('class' => 'form-control')
              ))->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
              ))
              ->getForm();

              $form->handleRequest($request);

              if($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute("/index");
             }
              return $this->render('Email/edit.html.twig', array(
                'form' => $form->createView()
              ));

    }

     /**
       * @Route("/Email/delete/{id}")
       * @Method("DELETE")
       */

      public function delete(Request $request ,$id)
      {
       $mails=$this->getDoctrine()->getRepository(Emails::class)->find($id);
       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->remove($mails);
       $entityManager->flush();
       $response = new Response();
       $response->send();
       return $this->redirectToRoute('/E-MailSender/public/');
      }



     /**
     * @Route("Email/{id}")
     */
    public function show($id)
    {
        $mails=$this->getDoctrine()->getRepository(Emails::class)->find($id);
        return $this->render('Email/show.html.twig', array('email'=> $mails));
    }
}