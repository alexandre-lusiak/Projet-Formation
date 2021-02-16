<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\ResetPasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
    
    
    public function passwordForgotten(Request $request , MailerInterface $mailer)
    {
        // on crée le formulaire
        
        $form=$this->createForm(ResetPasswordType::class);
        
        //on traite le formulaire
        $form->handleRequest($request);
        //si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupere les différentes données
            $data = $form->getData();
            $user= $this->getDoctrine()->getRepository(User::class)->findOneByEmail($data['email']);
    
            if(!$user) {
               throw $this->createNotFoundException("cet adresse email n'existe pas");
               return $this->redirectToRoute("login");
            }
            else {
                
                $user->setResetToken(md5(uniqid()));
            }
            
            try{
                $em =$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                //on gere les exception si il y a une erreur 
            }catch(\Exception $e) {
                $this->addFlash('info', 'attention une erreur est survenue');
                $this->redirectToRoute("login");
                
            }
            //envoie du mail pour la réanitialisation du mot de passe
            $email=(new TemplatedEmail())
                ->from("alexandre.lusiak@3wa.io")
                ->to($user->getEmail())
                ->subject("réinitialisation Mot De passe")
                ->htmlTemplate('mailer/reset-password-mail.html.twig')
                ->context([
                    'reset_token'=>$user->getResetToken(),
                    ]);
               
            $mailer->send($email);
            
            
            $this->addFlash('info','un email pour votre réanitialisation de mot de passe a été envoyé sur votre adresse');
            return $this->redirectToRoute('login');
            
        }
        
        return $this->render('security/password-forgotten.html.twig', [
            'formEmail'=>$form->createView()
            ]);
    }
    
    
    public function resetPassword($reset_token,Request $request, UserPasswordEncoderInterface $passwordEncoder) 
    {
        //on cherche l'utilisateur avec le  token attribué
         $user= $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token'=>$reset_token]);
         
        
         if (!$user) {
             $this->addFlash('info', 'token iconnu');
             return $this->redirectToRoute('login');
         }
         
         if ($request->isMethod('POST')) {
             
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user,$request->get('plainPassword')));
            $em =$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('info', 'Mot de passe modifié');
            return $this->redirectToRoute('login');
         } 
         else {
             return $this->render('security/resetpassword.html.twig', [
                 'reset_token'=> $reset_token
             ]);
         }
    }
}
