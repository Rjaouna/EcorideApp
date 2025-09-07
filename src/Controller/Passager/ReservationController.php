<?php

namespace App\Controller\Passager;

use App\Entity\Couvoiturage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ReservationController extends AbstractController
{
    #[Route('/passager/reservation/{id}', name: 'app_passager_reservation', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function reserver(Couvoiturage $covoiturage, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // CSRF (facultatif mais recommandé)
        if (!$this->isCsrfTokenValid('reserver' . $covoiturage->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // Le conducteur ne peut pas se réserver lui-même
        if ($user === $covoiturage->getDriver()) {
            $this->addFlash('warning', 'Vous êtes le conducteur de ce trajet.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // Déjà inscrit ?
        if ($covoiturage->getPassagers()->contains($user)) {
            $this->addFlash('warning', 'Vous participez déjà à ce covoiturage.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // Places restantes = nbPlace total - passagers actuels
        $placesRestantes = $covoiturage->getNbPlace() - $covoiturage->getPassagers()->count();
        if ($placesRestantes <= 0) {
            $this->addFlash('error', 'Il ne reste plus de places disponibles.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // Réserver
        $covoiturage->addPassager($user);
        // Décrémenter les places restantes
        $covoiturage->setNbPlace($covoiturage->getNbPlace() - 1);


        // (Facultatif) si plus de place après ajout, passer le statut à FULL
        if ($covoiturage->getNbPlace() === 0) {
            $covoiturage->setStatut('FULL');
        }else{
            $covoiturage->setStatut('EN COURS');
        }
        $em->persist($covoiturage);

        $em->flush();

        $this->addFlash('success', 'Votre réservation est confirmée 🚗');
        return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()], Response::HTTP_SEE_OTHER);
    }
}
