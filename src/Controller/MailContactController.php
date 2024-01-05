<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\MailContact;
use App\Form\MailContactType;
use App\Repository\MailContactRepository;
use App\Repository\CategorieRepository;
use App\Repository\EducateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MailContactController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/mail/contact/{id}', name: 'app_mail_contact')]
    public function index(Categorie $categorie): Response
    {
        return $this->render('mail_contact/index.html.twig', [
            'controller_name' => 'MailContactController',
            'mailContacts' => $categorie->getMailContacts(),
            'categorie' => $categorie
        ]);
    }

    #[Route('/mail/add/contact', name: 'add_mail_contact')]
    public function addMailContact(Request $request, EducateurRepository $edu): Response
    {
        $educateur = $edu->findOneBy(array('email' => $this->getUser()->getUserIdentifier()));
        $mailContact = new MailContact();
        $mailContact->setEducateur($educateur);
        $form = $this->createForm(MailContactType::class, $mailContact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contacts = array();
            $categories = $mailContact->getCategories();
            foreach ($categories as $categorie) {
                $licencies = $categorie->getLicencies();
                foreach ($licencies as $licencie) {
                    if (!in_array($licencie->getContact(), $contacts)) {
                        array_push($contacts, $licencie->getContact());
                        $mailContact->addContact($licencie->getContact());
                    }
                }
            }
            $this->em->persist($mailContact);
            $this->em->flush();

            return $this->redirectToRoute('app_categorie');
        }
        return $this->render('mail_contact/add_mailContact.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/mail/delete/contact/{mailContact}/{categorie}', name: 'delete_mail_contact')]
    public function delMailContact(MailContact $mailContact, Categorie $categorie): RedirectResponse
    {
        $this->em->remove($mailContact);
        $this->em->flush();

        return $this->redirectToRoute('app_mail_contact', [
            'id' => $categorie->getId()
        ]);
    }

    #[Route('/mail/details/contact/{mailContact}/{categorie}', name: 'details_mail_contact')]
    public function detailMailContact(MailContact $mailContact, Categorie $categorie): Response
    {
        return $this->render('mail_contact/details.html.twig', [
            'contacts' => $mailContact->getContacts(),
            'mailContact' => $mailContact,
            'categorie' => $categorie
        ]);
    }
}
