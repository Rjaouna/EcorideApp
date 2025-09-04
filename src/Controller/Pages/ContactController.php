<?php
namespace App\Controller\Pages;

use App\Form\ContactType;
use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactMessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $contactMessage->setName($data['nom']);
            $contactMessage->setEmail($data['email']);
            $contactMessage->setMessage($data['message']);
            $contactMessage->setStatus(ContactMessage::STATUS_NEW);
            $contactMessage->setCreatedAt(new \DateTimeImmutable);

            $entityManager->persist($contactMessage);
            $entityManager->flush();

            $this->addFlash('success', 'Message envoyé avec success !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
