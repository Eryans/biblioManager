<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\Book;
use App\Form\ClientType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'clientController',
        ]);
    }
    #[Route('/client/listing', name: 'client_listing')]
    public function showClients(ManagerRegistry $registry): Response
    {
        $clients = $registry->getRepository(Client::class)->findAll();
        return $this->render('client/listing.html.twig', [
            'controller_name' => 'clientController',
            'clients' => $clients,
        ]);
    }
    #[Route('/client/details/{id}', name: 'client_details')]
    public function showClient(ManagerRegistry $registry, int $id): Response
    {
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);
        $books = $registry->getRepository(Book::class)->findBy(["client" => $client]);
        return $this->render('client/details.html.twig', [
            'controller_name' => 'client Detail',
            'client' => $client,
            'books' => $books
        ]);
    }
    #[Route('/client/select/{id}', name: 'client_select')]
    public function selectClient(ManagerRegistry $registry,int $id): Response
    {
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $id]);
        $clients = $registry->getRepository(Client::class)->findAll();
        return $this->render('client/select.html.twig', [
            'controller_name' => 'clientController',
            'clients' => $clients,
            'book' => $book
        ]);
    }
    #[Route('/client/link/{idB},{idC}', name: 'client_book_link')]
    public function linkClientToBook(EntityManagerInterface $event, ManagerRegistry $registry, int $idB, int $idC): Response
    {
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $idB]);
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $idC]);
        $book->setClient($client);
        $book->setAvailable(false);
        $client->addBook($book);
        $event->persist($book, $client);
        $event->flush();
        return $this->redirectToRoute("book_listing");
    }
    #[Route('/client/unlink/{idB},{idC}', name: 'client_book_unlink')]
    public function unlinkClientToBook(EntityManagerInterface $event, ManagerRegistry $registry, int $idB, int $idC): Response
    {
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $idB]);
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $idC]);
        $book->setClient(null);
        $book->setAvailable(true);
        $client->removeBook($book);
        $event->persist($book, $client);
        $event->flush();
        return $this->redirectToRoute("client_details", ["id" => $client->getId()]);
    }
    #[Route('/client/create', name: 'client_create')]
    public function createclient(Request $request, EntityManagerInterface $event): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $form->add("submit", SubmitType::class, ["attr" => ["class" => "btn btn-primary"]]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $event->persist($client);
            $event->flush();
            return $this->redirectToRoute('client_listing');
        }

        return $this->renderForm('client/create.html.twig', [
            'controller_name' => 'Create client',
            'form' => $form
        ]);
    }
    #[Route('/client/edit/{id}', name: 'client_edit')]
    public function editclient(ManagerRegistry $registry, Request $request, EntityManagerInterface $event, int $id): Response
    {
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);

        $form = $this->createForm(ClientType::class, $client);
        $form->add("submit", SubmitType::class, ["attr" => ["class" => "btn btn-primary"]]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $event->persist($client);
            $event->flush();
            return $this->redirectToRoute('client_listing');
        }

        return $this->renderForm('client/create.html.twig', [
            'controller_name' => 'Edit client',
            'form' => $form
        ]);
    }
    #[Route('/client/delete/{id}', name: 'client_delete')]
    public function deleteclient(ManagerRegistry $registry, EntityManagerInterface $event, int $id): Response
    {
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);
        $event->remove($client);
        $event->flush();
        return $this->redirectToRoute("client_listing");
    }
}
