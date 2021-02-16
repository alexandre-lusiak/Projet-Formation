<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Form\ProductFormType;
use App\Form\ArticleFormType;
use App\Form\CategoryFormType;
use App\Entity\Product;
use App\Entity\Article;
use App\Entity\Category;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        ///////////////////////////////////////////
        // we look and we retrieve the articles  //
        //  CategoryArticle  and products        //
        //          from the data base           //
        ///////////////////////////////////////////
        
        $bdd_article = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $bdd_products = $this->getDoctrine()->getRepository(Product::class)->findAll(); 
        $bdd_Category = $this->getDoctrine()->getRepository(Category::class)->findAll(); 
        return $this->render('admin/admin.html.twig', [
             'articles'=>$bdd_article,
             'products'=>$bdd_products,
             'categories'=>$bdd_Category
            ]);
    }
    
}
