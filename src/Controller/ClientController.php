<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function showclients(ManagerRegistry $registry): Response
    {
        $clients = $registry->getRepository(Client::class)->findAll();
        return $this->render('client/listing.html.twig', [
            'controller_name' => 'clientController',
            'clients' => $clients,
        ]);
    }
    #[Route('/client/create', name: 'client_create')]
    public function createclient(Request $request,EntityManagerInterface $event): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class,$client);
        $form->add("submit",SubmitType::class,["attr" => ["class" => "btn btn-primary"]]);
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
    public function editclient(ManagerRegistry $registry,Request $request,EntityManagerInterface $event,int $id): Response
    {
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);

        $form = $this->createForm(ClientType::class,$client);
        $form->add("submit",SubmitType::class,["attr" => ["class" => "btn btn-primary"]]);
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
    public function deleteclient(ManagerRegistry $registry,EntityManagerInterface $event, int $id): Response
    {
        $client = $registry->getRepository(Client::class)->findOneBy(["id" => $id]);
        $client->setClient(null);
        $event->remove($client);
        $event->flush();
        return $this->redirectToRoute("client_listing");
    }
}