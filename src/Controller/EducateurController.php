<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Form\EducateurType;
use App\Repository\EducateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EducateurController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/educateur', name: 'app_educateur')]
    public function index(EducateurRepository $educateur): Response
    {
        $educateurs = $educateur->findAll();
        return $this->render('educateur/index.html.twig', [
            'controller_name' => 'EducateurController',
            'educateurs' => $educateurs
        ]);
    }

    #[Route('/educateur/add', name: 'add_educateur')]
    public function addEducateur(Request $request): Response
    {
        $educateur = new Educateur();
        $form = $this->createForm(EducateurType::class, $educateur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($educateur);
            $this->em->flush();

            return $this->redirectToRoute('app_educateur');
        }
        return $this->render('educateur/add_educateur.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/educateur/edit/{id}', name: 'edit_educateur')]
    public function editEducateur(Request $request, Educateur $educateur): Response
    {
        $form = $this->createForm(EducateurType::class, $educateur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();

            return $this->redirectToRoute('app_educateur');
        }
        return $this->render('educateur/edit_educateur.html.twig', [
            "form" => $form->createView(),
            "educateur" => $educateur
        ]);
    }

    #[Route('/educateur/delete/{id}', name: 'delete_educateur')]
    public function delEducateur(Educateur $educateur): RedirectResponse
    {
        if($this->getUser()->getUserIdentifier() == $educateur->getEmail()){
            $this->container->get('security.token_storage')->setToken(null);
        }
        $this->em->remove($educateur);
        $this->em->flush();
        return $this->redirectToRoute('app_educateur');
    }

}
