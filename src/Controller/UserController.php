<?php

namespace App\Controller;
use App\Entity\User;
use DateTime;
use Doctrine\DBAL\Types\DateTimeType as TypesDateTimeType;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserController extends Controller
{
    /**
     * @Route("/user/user",name="usermanage")
     * Method({"GET"})
     */
    public function users()
    {
        $users= $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/user.html.twig', array('user' => $users));
    }

    /**
     * @Route("user/adduser",name="adduser")
     * MMethod({"GET,"POST"})
     */
   public function adduser(Request $request, UserPasswordEncoderInterface $passworden)
   {
    $form= $this->createFormBuilder()->add('email' , EmailType::class,array('attr' => array('class' =>'form-control','type' =>'email')))
    ->add('password' ,RepeatedType::class,array('attr' => array('class' =>'form-control','type' => 'password')),[
        'type' => PasswordType::class,array('attr' => array('class' =>'form-control' ,'type' => 'password')),
        'required' => true,
        'first_options' => ['label' => 'Password'],
        'second_option' => ['label' => 'Confirm Password']
    ])
    ->add('roles' ,ChoiceType::class,[
        'choices' => [
            'User' => 'ROLE_USER',
            'Admin' => 'ROLE_ADMIN'

        ]
    ])
    ->add('save', SubmitType::class, array(
        'label' => 'Create',
        'attr' => array('class' => 'btn btn-primary mt-3')
      ))
      ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
          $data=$form->getData();
          $user=new User();
        $user->setEmail($data['email']);
        $user->setPassword($passworden->encodePassword($user,$data['password']));
        $user->setRoles((array)$data['roles']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute("/user");
     }
     return $this->render('user/adduser.html.twig', array(
        'form' => $form->createView()
      ));
   }

   /**
    * @Route("/user/edit/{id}")
    * Method({"GET","POST"})
    */

    public function edit(Request $request,$id, UserPasswordEncoderInterface $passworden)
    {
        $user=new User();
        $user = $this->getDoctrine($user)->getRepository(User::class)->find($id);
        $form= $this->createFormBuilder()->add('email' , EmailType::class,array('attr' => array('class' =>'form-control','type' =>'email')))
        ->add('password' ,RepeatedType::class,array('attr' => array('class' =>'form-control','type' => 'password')),[
            'type' => PasswordType::class,array('attr' => array('class' =>'form-control' ,'type' => 'password')),
            'required' => true,
            'first_options' => ['label' => 'Password'],
            'second_option' => ['label' => 'Confirm Password']
        ])
        ->add('roles' ,ChoiceType::class,[
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN'
    
            ]
        ])
        ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()) {
             $data=$form->getData();
              
            $user->setEmail($data['email']);
            $user->setPassword($passworden->encodePassword($user,$data['password']));
            $user->setRoles((array)$data['roles']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
    
            return $this->redirectToRoute("/user");
         }
         return $this->render('user/edit.html.twig', array(
            'form' => $form->createView()
          ));
    }
     /**
       * @Route("/user/delete/{id}")
       * @Method("DELETE")
       */

      public function delete(Request $request ,$id)
      {
       $user=$this->getDoctrine()->getRepository(User::class)->find($id);
       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->remove($user);
       $entityManager->flush();
       $response = new Response();
       $response->send();
       return $this->redirectToRoute('/user');
      }
}