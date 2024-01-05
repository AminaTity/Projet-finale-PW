<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategorieController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorie): Response
    {
        $categories = $categorie->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categories' => $categories
        ]);
    }

    #[Route('/categorie/add', name: 'add_categorie')]
    public function addCategorie(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categorie);
            $this->em->flush();

            return $this->redirectToRoute('app_categorie');
        }
        return $this->render('categorie/add_categorie.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/categorie/edit/{id}', name: 'edit_categorie')]
    public function editCategorie(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();

            return $this->redirectToRoute('app_categorie');
        }
        return $this->render('categorie/edit_categorie.html.twig', [
            "form" => $form->createView(),
            "categorie" => $categorie
        ]);
    }

    #[Route('/categorie/delete/{id}', name: 'delete_categorie')]
    public function deleteCategorie(Categorie $categorie): RedirectResponse
    {
        $licencies = $categorie->getLicencies();

        if(count($licencies) == 0){
            $this->em->remove($categorie);
            $this->em->flush();
            return $this->redirectToRoute('app_categorie');
        } else {
            return $this->redirectToRoute('licencies_categorie', [
                'id' => $categorie->getId(),
                'delete' => true
            ]);
        }
    }

    #[Route('/categorie/{id}/licencies/{delete}', name: 'licencies_categorie', defaults: ['delete' => false])]
    public function licenciesCategorie(Categorie $categorie, $delete): Response
    {
        return $this->render('categorie/licencies.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie,
            'delete' => $delete
        ]);
    }

    #[Route('/categorie/{id}/contacts', name: 'contacts_categorie')]
    public function contactsCategorie(Categorie $categorie): Response
    {
        $licencies = $categorie->getLicencies();
        $contacts = array();
        foreach($licencies as $licencie){
            if(!in_array($licencie->getContact(), $contacts)){
                array_push($contacts, $licencie->getContact());
            }
        }
        return $this->render('categorie/contacts.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie,
            'contacts' => $contacts
        ]);
    }
}
