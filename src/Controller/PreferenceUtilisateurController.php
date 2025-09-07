<?php

namespace App\Controller;

use App\Entity\PreferenceUtilisateur;
use App\Form\PreferenceUtilisateurType;
use App\Repository\PreferenceUtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/preference/utilisateur')]
final class PreferenceUtilisateurController extends AbstractController
{
    #[Route(name: 'app_preference_utilisateur_index', methods: ['GET'])]
    public function index(PreferenceUtilisateurRepository $preferenceUtilisateurRepository): Response
    {
        return $this->render('preference_utilisateur/index.html.twig', [
            'preference_utilisateurs' => $preferenceUtilisateurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_preference_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $preferenceUtilisateur = new PreferenceUtilisateur();
        $form = $this->createForm(PreferenceUtilisateurType::class, $preferenceUtilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preferenceUtilisateur->setUser($this->getUser());
            $entityManager->persist($preferenceUtilisateur);
            $entityManager->flush();

            $this->addFlash('warning', 'Vous pouvez désormais switcher en mode conducteur.');


            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('preference_utilisateur/new.html.twig', [
            'preference_utilisateur' => $preferenceUtilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_preference_utilisateur_show', methods: ['GET'])]
    public function show(PreferenceUtilisateur $preferenceUtilisateur): Response
    {
        return $this->render('preference_utilisateur/show.html.twig', [
            'preference_utilisateur' => $preferenceUtilisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_preference_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PreferenceUtilisateur $preferenceUtilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PreferenceUtilisateurType::class, $preferenceUtilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_preference_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('preference_utilisateur/edit.html.twig', [
            'preference_utilisateur' => $preferenceUtilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_preference_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, PreferenceUtilisateur $preferenceUtilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$preferenceUtilisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($preferenceUtilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_preference_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
