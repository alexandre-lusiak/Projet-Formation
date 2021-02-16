<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Form\CommentFormType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/home.html.twig', []);
    }
    
                    ////////////////////////////////////////
                    //  methode for law of datacollection //
                    ///////////////////////////////////////
    public function Rgpd(): Response
    {
        return $this->render('default/rgpd.html.twig', []);
    }
                    ///////////////////////////////////
                    //  methode for the comment Form //
                    ///////////////////////////////////
    
    public function comment(Request $request, MailerInterface $mailer): Response 
    {
        
            /***********************************/
            /* new instance of Category entity */
            /***********************************/
        $comment= new Comment();
            
            /*******************************************/
            /*     creation of a comment form     */
            /*******************************************/ 
        $commentForm = $this->createForm(CommentFormType::class, $comment );
        
            /******************************************************************/
            /*          we request the analysis of the http request           */
            /* search for the elements of the form (handlerequest($ request)) */
            /******************************************************************/
            
        $commentForm->handleRequest($request);
                    
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
                    
        if ($commentForm->isSubmitted() && $commentForm->isValid() ) {
            
            $comment_data = $commentForm->getData();
            $comment_data->setCreatedAt(new \DateTime('NOW') );
            
            $commentManager = $this->getDoctrine()->getManager();
            /*********************************************************/ 
            /*  we push the data of the comment form in the database */
            /*********************************************************/ 
            $commentManager->persist($comment_data);
            $commentManager->flush();
            
            /**************************************************/ 
            /* we send an email to the admin with the comment */
            /**************************************************/ 
            $email=(new TemplatedEmail())
                ->from($commentForm->get('email')->getData())
                ->to("projet.formation3wa@gmail.com")
                ->subject("un commentaire")
                ->htmlTemplate('mailer/mailer.html.twig')
                ->context([
                    'nickname'=>$commentForm->get('nickname')->getData(),
                    'content'=>$commentForm->get('content')->getData(),
                    ]);
                    
            $mailer->send($email);    
            
            /*************************/
            /* adding a flash message*/
            /*************************/
            
        $this->addFlash('message','Votre commentaire a bien été envoyé!');
        
            /***************************/ 
            /*   make the form empty   */
            /***************************/
            
        unset($commentForm); 
        $comment= new Comment();
        $commentForm= $this->createForm( CommentFormType::class, $comment);
        }
            /*******************************************************/ 
            /*  we indicate to the controller the associated view  */
            /*******************************************************/
            
        return $this->render('default/comment.html.twig', [
            // on crée la vue du formulaire//
            'commentForm'=>$commentForm->createView(),
        ]);
    }
}
