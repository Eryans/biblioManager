<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Entity\History;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle;

class BookController extends AbstractController
{
    #[Route('/book', name: 'book')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/listing', name: 'book_listing')]
    public function showBooks(ManagerRegistry $registry): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $books = $registry->getRepository(Book::class)->findAll();
        return $this->render('book/listing.html.twig', [
            'controller_name' => 'BookController',
            'books' => $books,
        ]);
    }
    #[Route('/book/create', name: 'book_create')]
    public function createBook(Request $request,EntityManagerInterface $event): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $book = new Book();

        $form = $this->createForm(BookType::class,$book);
        $book->setAvailable(true);
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
    #[Route('/book/edit/{id}', name: 'book_edit')]
    public function editBook(ManagerRegistry $registry,Request $request,EntityManagerInterface $event,int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $id]);

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
            'controller_name' => 'Edit Book',
            'form' => $form
        ]);
    }
    #[Route('/book/delete/{id}', name: 'book_delete')]
    public function deleteBook(ManagerRegistry $registry,EntityManagerInterface $event, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $id]);
        $history = $registry->getRepository(History::class)->findBy(["book" => $book]);
        foreach($history as $h){
            $h->setClient(null);
            $event->remove($h);
        }
        $book->setClient(null);
        $event->remove($book);
        $event->flush();
        return $this->redirectToRoute("book_listing");
    }
}
