<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Entity\MailEdu;
use App\Form\MailEduType;
use App\Repository\MailEduRepository;
use App\Repository\EducateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MailEduController extends AbstractController
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    #[Route('/mail/edu', name: 'app_mail_edu')]
    public function index(MailEduRepository $mailEdu, EducateurRepository $edu): Response
    {
        $educateur = $edu->findOneBy(array('email'=>$this->getUser()->getUserIdentifier()));
        $mailEdus = $mailEdu->findBy(array('educateur'=>$educateur->getId()));
        return $this->render('mail_edu/index.html.twig', [
            'controller_name' => 'MailEduController',
            'mailEdus' => $mailEdus,
            'modeEnvoi' => true
        ]);
    }

    #[Route('/mail/edu/recu', name: 'view_mail_edu')]
    public function MailEduRecu(EducateurRepository $edu): Response
    {
        $educateur = $edu->findOneBy(array('email'=>$this->getUser()->getUserIdentifier()));
        $mailEdus = $educateur->getMailEdus();
        return $this->render('mail_edu/index.html.twig', [
            'controller_name' => 'MailEduController',
            'mailEdus' => $mailEdus,
            'modeEnvoi' => false
        ]);
    }

    #[Route('/mail/add/edu', name: 'add_mail_edu')]
    public function addMailEdu(Request $request, EducateurRepository $edu): Response
    {
        $educateur = $edu->findOneBy(array('email'=>$this->getUser()->getUserIdentifier()));
        $mailEdu = new MailEdu();
        $mailEdu->setEducateur($educateur);
        $form = $this->createForm(MailEduType::class, $mailEdu);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($mailEdu);
            $this->em->flush();

            return $this->redirectToRoute('app_mail_edu');
        }
        return $this->render('mail_edu/add_mailEdu.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/mail/delete/edu/{id}', name: 'delete_mail_edu')]
    public function delMailEdu(MailEdu $mailEdu): RedirectResponse
    {
        $this->em->remove($mailEdu);
        $this->em->flush();
        
        return $this->redirectToRoute('app_mail_edu');
    }

    #[Route('/mail/edu/{id}', name: 'details_mail_edu')]
    public function detailMailEdu(MailEdu $mailEdu): Response
    {
        return $this->render('mail_edu/details.html.twig', [
            'controller_name' => 'MailEduController',
            'mailEdu' => $mailEdu
        ]);
    }
}
