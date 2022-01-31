<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;

class BookController extends AbstractController
{
    #[Route('/book', name: 'book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/listing', name: 'book_listing')]
    public function showBooks(ManagerRegistry $registry): Response
    {
        $books = $registry->getRepository(Book::class)->findAll();
        dump($books);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/Create', name: 'book_create')]
    public function createBook(ManagerRegistry $registry): Response
    {
        $books = $registry->getRepository(Book::class)->findAll();
        dump($books);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
