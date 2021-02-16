<?php

namespace App\Controller;

use App\Repository\ArticleLikeRepository;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\ArticleLike;

use App\Form\ArticleFormType;
use App\Form\CategoryFormType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    
                            //////////////////////////////////////////////////////
                            // Method to get the articles from the database     //
                            //////////////////////////////////////////////////////    
     public function article(): Response 
    {
        $bdd_article = $this->getDoctrine()->getRepository(Article::class)->findAll();
         
        return $this->render('article/article.html.twig', [
            'articles'=>$bdd_article
        ]);
    }
    
                            /////////////////////////////////////////////
                            // method of adding artcile in the database //
                            //         (reserved for the admin)         //
                            /////////////////////////////////////////////
    public function addArticle( Request $request,SluggerInterface $slugger ): Response
    {
            /***********************************/
            /*new instance of my article entity*/
            /***********************************/ 
            
        $article = new Article();
        
            /*******************************************/
            /*   creation of an article addition form  */
            /*******************************************/
        $formArticle = $this->createForm( ArticleFormType::class, $article  );
        
            /******************************************************************/
            /*          we request the analysis of the http request           */
            /* search for the elements of the form (handlerequest($ request)) */
            /******************************************************************/
        
        $formArticle->handleRequest($request);
        
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
        
        if ($formArticle->isSubmitted() && $formArticle->isValid() ) {
            //var_dump($formArticle);
             $pictureFile = $formArticle->get('picture')->getData();
             
            /********************************************/ 
            /*  we check if an image has been uploaded  */
            /*            and we give it a unique name  */
            /********************************************/ 
    
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                ///////////////////////////////////////////////////////////////////////
                // this is needed to safely include the file name as part of the URL //
                /////////////////////////////////////////////////////////////////////// 
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename =  $safeFilename.'-'.uniqid().".".$pictureFile->guessExtension();

            /******************************************************************/ 
            /*  move the file to the directory where the pictures are stored */
            /******************************************************************/
                try {
                    $pictureFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('message','une erreur est survenu lors de l\'upload de l\'image!');
                    return $this->redirectToRoute('admin');
                }
            $article_data = $formArticle->getData();
            /************************************************/ 
            /*  we put the date at the current addition date*/
            /************************************************/
            $article_data->setCreatedAt(new \DateTime('NOW') ); 
            
            /******************************************************************/ 
            /*  setting up the upload image in the database with the unique name*/
            /******************************************************************/    

            $article->setPicture($newFilename);
            
            /****************************************************/ 
            /*  we send the data from the form to the database  */
            /****************************************************/ 
            $articleManager = $this->getDoctrine()->getManager();
            
            $articleManager->persist($article_data);
            
            $articleManager->flush();
            
             $this->addFlash('message','Article à bien été ajouter!');
            
            /***************************/ 
            /*  redirect to admin page */
            /***************************/
            
            return $this->redirectToRoute('admin');
            return new Response("Article ajouté");
        }
            /***************************/ 
            /*   make the form empty   */
            /***************************/       
            unset($formArticle); 
            $article = new Article();
            $formArticle= $this->createForm( ArticleFormType::class, $article);
            
        }
            /*******************************************************/ 
            /*  we indicate to the controller the associated view  */
            /*******************************************************/       
        return $this->render("admin/addArticle.html.twig",[
            'formArticle'=>$formArticle->createView()
            ]);
    }
                        
                        
                        /////////////////////////////////////////
                        ///    method to modify an article    ///
                        /////////////////////////////////////////
    
    public function editArticle(Request $request, SluggerInterface $slugger, Article $idArticle): Response 
    {
            /********************************************************/             
            /*           We get the form to add an article          */
            /*  without create a new instance of the article entity */
            /********************************************************/            
        
        $formArticle = $this->createForm( ArticleFormType::class, $idArticle);
        
        $formArticle->handleRequest($request);
        
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
        if ($formArticle->isSubmitted() && $formArticle->isValid() ) {
            //var_dump($formArticle);
            
             $pictureFile = $formArticle->get('picture')->getData();
             
           //var_dump($_FILES);
            
            //var_dump($pictureFile);
        
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                /********************************************************************/
                /* this is needed to safely include the file name as part of the URL*/
                /********************************************************************/
               
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename =  $safeFilename.'-'.uniqid().".".$pictureFile->guessExtension();

                try {
                    $pictureFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('message','une erreur est survenu lors de l\'upload de l\'image!');
                    return $this->redirectToRoute('admin');
                }
                
            $article_data = $formArticle->getData();
            $article_data->setCreatedAt(new \DateTime('NOW') ); 
            
            $idArticle->setPicture($newFilename);
    
            $articleManager = $this->getDoctrine()->getManager();
            /*****************************************************************/
            /* useless to persist  because it already comes from the database*/
            /*****************************************************************/
            $articleManager->flush();
            
            /*************************/
            /* adding a flash message*/
            /*************************/
            
            $this->addFlash('message','Article à bien été modifié!');
            /***************************/ 
            /*  redirect to admin page */
            /***************************/
            return $this->redirectToRoute('admin');
            return new Response("Article modifié");
        }
        
            
    }
            /*******************************************************/ 
            /*  we indicate to the controller the associated view  */
            /*******************************************************/
        return $this->render("admin/addArticle.html.twig",[
            'formArticle'=>$formArticle->createView()
            ]);
        
        
    }    
                        
                            //////////////////////////////////
                            // methode to delete an article //
                            //////////////////////////////////
    
    public function deleteArticle(Article $idArticle)
    {
        $deleteArticle= $this->getDoctrine()->getManager();
        $deleteArticle->remove($idArticle);
        $deleteArticle->flush();
        
        $this->addFlash('message','Article à bien été supprimé!');
        
        return $this->redirectToRoute('admin');
    }
                            ////////////////////////////////
                            //  methode to add a category //
                            ////////////////////////////////    
    public function addCategory(Request $request): Response
    {
        
            /***********************************/
            /* new instance of Category entity */
            /***********************************/
        $category= new Category();
        
            /*******************************************/
            /*     creation of a Category add form     */
            /*******************************************/
            
        $formCategory = $this->createForm( CategoryFormType::class, $category );
        
            /******************************************************************/
            /*          we request the analysis of the http request           */
            /* search for the elements of the form (handlerequest($ request)) */
            /******************************************************************/
            
        $formCategory->handleRequest($request);
            
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
            
         if ($formCategory->isSubmitted() && $formCategory->isValid() ) {
            //var_dump($formCateogry);
            
            $category_data = $formCategory->getData();
            
            $categoryManager = $this->getDoctrine()->getManager();
            $categoryManager->persist($category_data);
            $categoryManager->flush();
            
            $this->addFlash('message','Une Category à bien été ajouter!');    
                
            return $this->redirectToRoute('admin');
            return new Response("category ajouter");
            
            
        }
            /***************************/ 
            /*   make the form empty   */
            /***************************/ 
        unset($formCategory); 
        $article = new Article();
        $formCategory= $this->createForm( CategoryFormType::class, $category);
            
            /*******************************************************/ 
            /*  we indicate to the controller the associated view  */
            /*******************************************************/
            
        return $this->render("admin/addCategory.html.twig",[
            'formCategory'=>$formCategory->createView()
            ]);
        
    }
    
    public function editCategory(Request $request, Category $idCategory): Response 
    {
          $formCategory = $this->createForm( CategoryFormType::class, $idCategory );
        
            /******************************************************************/
            /*          we request the analysis of the http request           */
            /* search for the elements of the form (handlerequest($ request)) */
            /******************************************************************/
            
        $formCategory->handleRequest($request);
            
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
            
         if ($formCategory->isSubmitted() && $formCategory->isValid() ) {
            //var_dump($formCateogry);
            
            $category_data = $formCategory->getData();
            
            $categoryManager = $this->getDoctrine()->getManager();
            //$categoryManager->persist($category_data);
            $categoryManager->flush();
            
            $this->addFlash('message','Une Category à bien été modifé!');    
                
            return $this->redirectToRoute('admin');
            return new Response("category modifé");
        }
            /*******************************************************/ 
            /*  we indicate to the controller the associated view  */
            /*******************************************************/
            
        return $this->render("admin/addCategory.html.twig",[
            'formCategory'=>$formCategory->createView()
            ]);
    }    

                ///////////////////////////////////////////////
                //methode like / unlike system in the article//
                //             use json for that             //
                ///////////////////////////////////////////////

    public function like(Article $article, ArticleLikeRepository $likeRepo  ) :Response
    {
       
            /*****************************/ 
            /* on recupere l'utilisateur */
            /*****************************/       
        $user= $this->getUser();
            /*******************************************/ 
            /* logic to see if the user is logged in   */ 
            /* and if he has already liked the article */
            /*******************************************/
            
            
            /* if the user is not logged in*/    
        if(!$user) {
            return $this->json([
                'code'=>403,
                'message'=> "Vous devez etre connecté"
                ],403);
        }
            /* case where the article is already likedé*/
        if($article->likedByUser($user)) {
            $like =$likeRepo->findOneBy([
                'article'=>$article,
                'user'=>$user
                ]); 
                
            $em= $this->getDoctrine()->getManager();
            $em->remove($like);
            $em->flush();
            
            return $this->json([
                'code'=>200,
                'message'=>'like supprimé',
                'nb_likes'=>$likeRepo->count(['article' => $article])
                ],200);
        }
             /* case where the user has not yet like*/
        else {
            $like = new ArticleLike();
            $like->setArticle($article);
            $like->setUser($user);
            $em= $this->getDoctrine()->getManager();
            $em->persist($like);
            $em->flush();
            
            return $this->json([
                    'code'=>200, 
                    'message'=>'like ajouté',
                    'nb_likes'=>$likeRepo->count(['article' => $article])
                ],200);
        }
        
    }                        
}
