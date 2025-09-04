<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\ContactMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact/message')]
final class ContactMessageController extends AbstractController
{
    #[Route(name: 'app_contact_message_index', methods: ['GET'])]
    public function index(ContactMessageRepository $contactMessageRepository): Response
    {
        return $this->render('contact_message/index.html.twig', [
            'contact_messages' => $contactMessageRepository->findNotArchived(),
        ]);
    }

    #[Route('/new', name: 'app_contact_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact_message/new.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_message_show', methods: ['GET'])]
    public function show(ContactMessage $contactMessage, EntityManagerInterface $entityManager): Response
    {
        if(!$contactMessage->getReadAt()){
            $contactMessage->setReadAt(new \DateTimeImmutable());
            $contactMessage->setStatus('Read');
            $entityManager->persist($contactMessage);
            $entityManager->flush();
        }

        return $this->render('contact_message/show.html.twig', [
            'contact_message' => $contactMessage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContactMessage $contactMessage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact_message/edit.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/note', name: 'app_contact_message_note_update', methods: ['POST'])]
    public function updateNote(
        Request $request,
        ContactMessage $contactMessage,
        EntityManagerInterface $em
    ): Response {
        // Vérif CSRF (même id que dans le Twig : 'note' ~ id)
        $submittedToken = (string) $request->request->get('_token', '');
        if (!$this->isCsrfTokenValid('note' . $contactMessage->getId(), $submittedToken)) {
            $this->addFlash('danger', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_contact_message_index');
        }

        // Récup note
        $note = trim((string) $request->request->get('note', ''));
        if ($note === '') {
            $this->addFlash('warning', 'La note ne peut pas être vide.');
            return $this->redirectToRoute('app_contact_message_index');
        }

        // Sauvegarde sur le message (champ "note" supposé exister)
        $contactMessage->setNote($note);
        $em->flush();

        $this->addFlash('success', 'La note a bien été enregistrée.');
        return $this->redirectToRoute('app_contact_message_index');
    }

    #[Route('/{id}/archive', name: 'app_contact_message_archive', methods: ['GET', 'POST'])]
    public function archive(ContactMessage $contactMessage, EntityManagerInterface $entityManager): Response
    {
        if ($contactMessage->getStatus() === ContactMessage::STATUS_NEW) {
            $this->addFlash('warning', 'Veuillez lire le mail avant de l\'archiver');
        } else {
            $contactMessage->setStatus(ContactMessage::STATUS_ARCHIVED);
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            $this->addFlash('success', 'Le message a bien été archivé.');
        }

        return $this->redirectToRoute('app_contact_message_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_contact_message_delete', methods: ['POST'])]
    public function delete(Request $request, ContactMessage $contactMessage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactMessage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contactMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
