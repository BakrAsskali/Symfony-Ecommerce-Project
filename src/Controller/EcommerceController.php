<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcommerceController extends AbstractController
{
    #[Route('/ecommerce', name: 'app_ecommerce')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('ecommerce/index.html.twig', [
            'products' => $products,
        ]);
    }


    #[Route('/ecommerce/product/{id}',name:'show_product')]
    public function showProduct($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('ecommerce/afficherProduit.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/ecommerce/add_product',name:'add_product')]
    public function addProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_ecommerce');
        }

        return $this->render('ecommerce/ajouterProduit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ecommerce/add_category',name:'add_category')]
    public function addCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_ecommerce');
        }

        return $this->render('ecommerce/ajouterCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
