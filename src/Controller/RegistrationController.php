<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator,MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setActivationToken(md5(uniqid()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // Envoi de l'email d'activation du compte
            $email=(new TemplatedEmail())
                ->from("alexandre.lusiak@3wa.io")
                ->to($user->getEmail())
                ->subject("activation du compte")
                ->htmlTemplate('mailer/activation-mail.html.twig')
                ->context([
                    'mail'=>$user->getEmail(),
                    'token'=>$user->getActivationToken(),
                    ]);
                   
            $mailer->send($email);       

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // nom du firewall dans le security.yaml
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
    
    public function countActivation($token)
    {

        $user= $this->getDoctrine()->getRepository(User::class)->findOneBy(['activation_token' =>$token]);
        
        //si il n'y aucun utilisateur existant avec ce token
        if (!$user){
            throw $this->createNotFoundException("cet utilisateur n'existe pas");
        }
        // si il existe on supprime le token 
        $user->setActivationToken(null);
        
        $em =$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        $this->addFlash('message','Votre compte à bien été activé');

        // on retourne a l'acceuille 
        $this->redirectToRoute('index');
        return new Response("compte activé");
    }
}
