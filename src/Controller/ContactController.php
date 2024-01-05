<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContactController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contact): Response
    {
        $contacts = $contact->findAll();
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contacts' => $contacts
        ]);
    }

    #[Route('/contact/add', name: 'add_contact')]
    public function addContact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($contact);
            $this->em->flush();

            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/add_contact.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/contact/edit/{id}', name: 'edit_contact')]
    public function editContact(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();

            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/edit_contact.html.twig', [
            "form" => $form->createView(),
            "contact" => $contact
        ]);
    }

    #[Route('/contact/delete/{id}', name: 'delete_contact')]
    public function delContact(contact $contact): RedirectResponse
    {
        $licencies = $contact->getLicencies();
        if(count($licencies) == 0){
            $this->em->remove($contact);
            $this->em->flush();
            return $this->redirectToRoute('app_contact');
        } else {
            return $this->redirectToRoute('licencies_contact', [
                'id' => $contact->getId(),
                'delete' => true
            ]);
        }
    }

    #[Route('/contact/{id}/licencies/{delete}', name: 'licencies_contact', defaults: ['delete' => false])]
    public function licenciesContact(Contact $contact, $delete): Response
    {
        return $this->render('contact/licencies.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $contact,
            'delete' => $delete
        ]);
    }
}
