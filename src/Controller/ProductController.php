<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Comment;
use App\Entity\User; 

use App\Form\ProductFormType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
                            //////////////////////////////////////////////////////
                            //    Method to get the product from the database   //
                            //////////////////////////////////////////////////////
    /**
     * @Route("/product", name="product")
     */
    public function product(): Response 
    {
        $bdd_products = $this->getDoctrine()->getRepository(Product::class)->findAll();
         
        return $this->render('product/product.html.twig', [
            'products'=>$bdd_products
        ]);
    }
    
    
                            //////////////////////////////////////////////
                            // method of adding product in the database //
                            //         (reserved for the admin)         //
                            //////////////////////////////////////////////
    public function addProduct( Request $request,SluggerInterface $slugger ): Response
    {
            /***********************************/
            /* new instance of product entity  */
            /***********************************/
        $product = new Product();
        
            /*******************************************/
            /*   creation of a product addition form  */
            /*******************************************/
        
        $formProduct = $this->createForm( ProductFormType::class, $product );
            
            /******************************************************************/
            /*          we request the analysis of the http request           */
            /* search for the elements of the form (handlerequest($ request)) */
            
            /******************************************************************/
        $formProduct->handleRequest($request);
        
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
        
        if ($formProduct->isSubmitted() && $formProduct->isValid() ) {

              
            $pictureFile = $formProduct->get('picture')->getData();
            
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
                

            $product_data = $formProduct->getData();
            
            /************************************************/ 
            /*  we put the date at the current addition date*/
            /************************************************/
            $product_data->setDate(new \DateTime('NOW') );
            
            /******************************************************************/ 
            /*  setting up the upload image in the database with the unique name*/
            /******************************************************************/
            
            $product->setPicture($newFilename);
            
            $entityManager = $this->getDoctrine()->getManager();
            
            /****************************************************/ 
            /*  we send the data from the form to the database  */
            /****************************************************/
                 
            $entityManager->persist($product_data);
            $entityManager->flush();
            
            $this->addFlash('message','Le Produit à bien été ajouter!');
            
            /***************************/ 
            /*  redirect to admin page */
            /***************************/
            
            return $this->redirectToRoute('admin');
            return new Response("produit ajouté");
        }

            /***************************/ 
            /*   make the form empty   */
            /***************************/
            
            unset($formProduct); 
            $product = new Product();
            $formProduct= $this->createForm( ProductFormType::class, $product);
        }
            
            /*******************************************************/ 
            /*  we indicate to the controller the associated view  */
            /*******************************************************/

        return $this->render("admin/addproduct.html.twig",[
            'formProduct'=>$formProduct->createView()
            
            ]);
    }
    
    
                            ///////////////////////////////////////
                            ///  methode to modify a product    ///
                            ///////////////////////////////////////
    
    public function editProduct(Request $request,SluggerInterface $slugger, Product $product)
    {
        
            /********************************************************/             
            /*           We get the form to add a Product           */
            /*  without create a new instance of the product entity */
            /********************************************************/
                            
        $formProduct = $this->createForm( ProductFormType::class, $product );
        
        $formProduct->handleRequest($request);
        
            /**************************************************/ 
            /*  we check that the form is submitted and valid */
            /**************************************************/
            
        if ($formProduct->isSubmitted() && $formProduct->isValid() ) {
            
             $pictureFile = $formProduct->get('picture')->getData();
             
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
                
            $product_data = $formProduct->getData();
            $product_data->setDate(new \DateTime('NOW') );
            $product->setPicture($newFilename);
            
            $entityManager = $this->getDoctrine()->getManager();
            
            // $entityManager->persist($product_data);
            
            $entityManager->flush();
            
            /*************************/
            /* adding a flash message*/
            /*************************/
            
            $this->addFlash('message','Le Produit à bien été modifié!');    
            return $this->redirectToRoute('admin');
            return new Response("produit modifé");
        }   
            /***************************/ 
            /*   make the form empty   */
            /***************************/
            
            unset($formProduct); 
            $product = new Product();
            $formProduct= $this->createForm( ProductFormType::class, $product);
        }
        
        return $this->render("admin/addproduct.html.twig",[
            'formProduct'=>$formProduct->createView()
            
            ]);
    }
    
    
                            /////////////////////////////////
                            // methode to delete a product //
                            /////////////////////////////////
    
    public function deleteProduct(Product $product)
    {
        $delete=$this->getDoctrine()->getManager();
        $delete->remove($product);
        $delete->flush();
        
        $this->addFlash('message','Le Produit à bien été supprimé!');
        
        return $this->redirectToRoute('admin');
    }
    
                             
           //////////////////////////////////////////////////////////////////                 
           // methode d'ajout de produit au panier en utilisant la session //
           //////////////////////////////////////////////////////////////////
    
      public function addBasket(SessionInterface $session, int $id )
    {   
            /*****************************************/
            /* we get a 'basket' data in the session */
            /*****************************************/ 
            
        $basket = $session->get('basket', []);
            /*****************************************************************/
            /* logic of the basket if it is empty or already has a product   */
            /*****************************************************************/  
        
        if(!empty($basket[$id])) {
            $basket[$id]++;
        } 
        else {
            $basket[$id]=1;
        }
//on sauvegarde le panier avec l'id reçu//
            
            /*******************************************/
            /* we save the basket with the id received */
            /*******************************************/  
            
        $session->set('basket',$basket);
             /*************************/
            /* adding a flash message*/
            /*************************/
        $this->addFlash('message','Produit ajouté au panié!');
        
        return $this->redirectToRoute('product');
        return new Response("Article ajouté");
    }
   
            
           //////////////////////////////////////////////////////////                
           //            basket viewing method                     // 
           //       by retrieving the session data                 //
           // use of SessionInterface which represents our session //
           //////////////////////////////////////////////////////////      
    
    public function basket(SessionInterface $session)
    {
        $session=new Session();
        $session->start();

            /*******************************************/
            /* we save the basket with the id received */
            /*******************************************/
        $basket = $session->get('basket');

            /************************************************************/
            /* we creaate an empty array for our product in our basket  */
            /************************************************************/
        $basket_data=[];
        
            /*********************************************************/
            /* we check if the session exists                        */ 
            /* if so we will loop on the product id with a quantity  */
            /*********************************************************/
            
       if($session->has('basket')) {
        foreach($basket as $id =>$quantity) { 
            /*******************************************/
            /* we retrieve the products by their "id" */
            /*******************************************/

            $bdd_products = $this->getDoctrine()->getRepository(Product::class)->find($id);
            
            /*********************************************************/
            /* we push in our empty table the product                */ 
            /* whose id is present in the session with this quantity */
            /*********************************************************/
            
            $basket_data[]=[
                'product'=>$bdd_products,
                'quantity'=>$quantity
                ];
        } 
       }
            /*********************************/
            /* total calculation of basket  */
            /********************************/
       
       $total_basket =0;
       
       foreach($basket_data as $item) {
           
           $totalItem = $item['product']->getPrice()*$item['quantity'];
           $total_basket += $totalItem;
       }
       
        return $this->render('product/basket.html.twig', [
            'items'=> $basket_data,
            'total'=>$total_basket
        ]); 
    } 
    
            ///////////////////////////////////////////////////////////////                 
            // method of deleting a product from the basket using the id //
            ///////////////////////////////////////////////////////////////
    
    public function removeProduct(int $id, SessionInterface $session) 
    {   
            /**************************************************************/
            /* recovery of our basket with the session and the product id */
            /**************************************************************/
            
         $basket = $session->get('basket', []);
            /***********************************************************/
            /* we check if the basket is not empty and if it is not    */
            /* we can "remove (unset) the product whose id corresponds */
            /***********************************************************/
         if(!empty($basket[$id])){
             unset($basket[$id]);
         }
        $session->set('basket',$basket);
        return $this->redirectToRoute('basket');
    }
}  
