<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\Book;
use App\Entity\History;
use App\Form\ClientType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('client/index.html.twig', [
            'controller_name' => 'clientController',
        ]);
    }
    #[Route('/client/listing', name: 'client_listing')]
    public function showClients(Request $request, ManagerRegistry $registry): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $locale = $request->getLocale();
        if ($locale === "fr") {
            $language = '//cdn.datatables.net/plug-ins/1.11.4/i18n/fr_fr.json';
        } else {
            $language = '//cdn.datatables.net/plug-ins/1.11.4/i18n/en-gb.json';
        }
        $clients = $registry->getRepository(Client::class)->findAll();
        return $this->render('client/listing.html.twig', [
            'controller_name' => 'clientController',
            'clients' => $clients,
            'language' => $language
        ]);
    }
    #[Route('/client/details/{id}', name: 'client_details')]
    public function showClient(ManagerRegistry $registry, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);
        $Borrowedhistory = $registry->getRepository(History::class)->findBy(["client" => $client, "returned_date" => null]);
        $history = $registry->getRepository(History::class)->findBy(["client" => $client]);
        return $this->render('client/details.html.twig', [
            'controller_name' => 'client Detail',
            'client' => $client,
            'histories' => $history,
            'bookHist' => $Borrowedhistory
        ]);
    }
    #[Route('/client/select/{id}', name: 'client_select')]
    public function selectClient(Request $request,ManagerRegistry $registry, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $locale = $request->getLocale();
        if ($locale === "fr") {
            $language = '//cdn.datatables.net/plug-ins/1.11.4/i18n/fr_fr.json';
        } else {
            $language = '//cdn.datatables.net/plug-ins/1.11.4/i18n/en-gb.json';
        }
        $borrowDay = 7;
        $form = $this->createFormBuilder()
        ->add("borrowDay",NumberType::class,["label" => "Borrow day","data" => 7])
        ->add("submit",SubmitType::class,["attr" => ["class" => "btn btn-primary"]])
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $borrowDay = $data["borrowDay"];
        }
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $id]);
        $clients = $registry->getRepository(Client::class)->findAll();
        return $this->renderForm('client/select.html.twig', [
            'controller_name' => 'clientController',
            'clients' => $clients,
            'book' => $book,
            'language' => $language,
            'form' => $form,
            'numOfDay' => $borrowDay
        ]);
    }
    #[Route('/client/link/{idB},{idC},{numOfDay}', name: 'client_book_link')]
    public function linkClientToBook(EntityManagerInterface $event, ManagerRegistry $registry, int $idB, int $idC, $numOfDay): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $doctrine = $registry->getManager();
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $idB]);
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $idC]);
        $history = new History();
        $history->setClient($client);
        $history->setBook($book);
        $history->setBorrowDate(new DateTime("now"));
        $history->setDueDate(new DateTime("now + ".$numOfDay."days"));
        $history->setUser($user);
        //$book->setClient($client);
        $book->setQuantity($book->getQuantity() - 1);
        $client->addBook($book);
        $doctrine->persist($history);
        $event->persist($book, $client);
        $doctrine->flush();
        $event->flush();
        return $this->redirectToRoute("book_listing");
    }
    #[Route('/client/unlink/{idB},{idC}', name: 'client_book_unlink')]
    public function unlinkClientToBook(EntityManagerInterface $event, ManagerRegistry $registry, int $idB, int $idC): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $book = $registry->getRepository(Book::class)->findOneBy(["id" => $idB]);
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $idC]);
        $history = $registry->getRepository(History::class)->findOneBy(["client" => $client, "book" => $book, "returned_date" => null]);
        $history->setReturnedDate(new DateTime("now"));
        $book->setQuantity($book->getQuantity() + 1);
        //$book->setClient(null);
        $client->removeBook($book);
        $event->persist($book, $client, $history);
        $event->flush();
        return $this->redirectToRoute("client_details", ["id" => $client->getId()]);
    }
    #[Route('/client/create', name: 'client_create')]
    public function createclient(TranslatorInterface $translator, Request $request, EntityManagerInterface $event): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $client = new Client();
        $title = $translator->trans("Create Client");
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $event->persist($client);
            $event->flush();
            return $this->redirectToRoute('client_listing');
        }

        return $this->renderForm('client/create.html.twig', [
            'controller_name' => 'Create client',
            'form' => $form,
            'title' => $title
        ]);
    }
    #[Route('/client/edit/{id}', name: 'client_edit')]
    public function editClient(TranslatorInterface $translator, ManagerRegistry $registry, Request $request, EntityManagerInterface $event, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);
        $title = $translator->trans("Edit Client");
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $event->persist($client);
            $event->flush();
            return $this->redirectToRoute('client_listing');
        }

        return $this->renderForm('client/create.html.twig', [
            'controller_name' => 'Edit client',
            'form' => $form,
            'title' => $title
        ]);
    }
    #[Route('/client/delete/{id}', name: 'client_delete')]
    public function deleteClient(ManagerRegistry $registry, EntityManagerInterface $event, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);
        $clientBooks = $registry->getRepository(History::class)->findBy(["client" => $client,"returned_date" => null]);
        if (count($clientBooks) === 0) {
            $history = $registry->getRepository(History::class)->findBy(["client" => $client]);
            foreach ($history as $h) {
                $h->setBook(null);
                $event->remove($h);
            }
            $event->remove($client);
            $event->flush();
        }
        return $this->redirectToRoute("client_listing");
    }
}
