<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('book/listing.html.twig', [
            'controller_name' => 'BookController',
            'books' => $books
        ]);
    }
    #[Route('/book/create', name: 'book_create')]
    public function createBook(ManagerRegistry $registry,Request $request,EntityManagerInterface $event): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class,$book);
        $form->add("submit",SubmitType::class,["attr" => ["class" => "btn btn-primary"]]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $event->persist($book);
            $event->flush();
            return $this->redirectToRoute('book_listing');
        }
        
        return $this->renderForm('book/create.html.twig', [
            'controller_name' => 'Create Book',
            'form' => $form
        ]);
    }
    #[Route('/book/edit', name: 'book_edit')]
    public function editBook(ManagerRegistry $registry,Request $request,EntityManagerInterface $event): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class,$book);
        $form->add("submit",SubmitType::class,["attr" => ["class" => "btn btn-primary"]]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $event->persist($book);
            $event->flush();
            return $this->redirectToRoute('book_listing');
        }
        
        return $this->renderForm('book/create.html.twig', [
            'controller_name' => 'Create Book',
            'form' => $form
        ]);
    }
}
