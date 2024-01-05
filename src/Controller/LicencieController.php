<?php

namespace App\Controller;

use App\Entity\Licencie;
use App\Form\LicencieType;
use App\Repository\LicencieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LicencieController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/licencie', name: 'app_licencie')]
    public function index(LicencieRepository $licencie): Response
    {
        $licencies = $licencie->findAll();
        return $this->render('licencie/index.html.twig', [
            'controller_name' => 'LicencieController',
            'licencies' => $licencies
        ]);
    }

    #[Route('/licencie/add', name: 'add_licencie')]
    public function addLicencie(Request $request): Response
    {
        $licencie = new Licencie();
        $form = $this->createForm(LicencieType::class, $licencie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($licencie);
            $this->em->flush();

            return $this->redirectToRoute('app_licencie');
        }
        return $this->render('licencie/add_licencie.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/licencie/edit/{id}', name: 'edit_licencie')]
    public function editLicencie(Request $request, Licencie $licencie): Response
    {
        $form = $this->createForm(LicencieType::class, $licencie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();

            return $this->redirectToRoute('app_licencie');
        }
        return $this->render('licencie/edit_licencie.html.twig', [
            "form" => $form->createView(),
            "licencie" => $licencie
        ]);
    }

    #[Route('/licencie/delete/{id}', name: 'delete_licencie')]
    public function delLicencie(Licencie $licencie): RedirectResponse
    {
        $this->em->remove($licencie);
        $this->em->flush();

        return $this->redirectToRoute('app_licencie');
    }
}
