<?php

namespace App\Controller\Passager;

use App\Entity\Couvoiturage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AnnulerCouvoiturageController extends AbstractController
{
    #[Route('/passager/covoiturage/{id}/annuler', name: 'app_passager_annuler_couvoiturage', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(Couvoiturage $covoiturage, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // Le conducteur ne peut pas s’annuler en tant que passager
        if ($user === $covoiturage->getDriver()) {
            $this->addFlash('warning', 'Vous êtes le conducteur de ce trajet.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // L'utilisateur participe-t-il ?
        if (!$covoiturage->getPassagers()->contains($user)) {
            $this->addFlash('info', 'Vous ne participez pas à ce covoiturage.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // Optionnel : interdire l’annulation après le départ
        if (($covoiturage->getDepartAt() instanceof \DateTimeInterface) && $covoiturage->getDepartAt() <= new \DateTimeImmutable()) {
            $this->addFlash('warning', 'Le trajet a déjà commencé ou est terminé.');
            return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
        }

        // Déblocage de l'argent en attente -> disponible
        $wallet = $user->getWallet();
        if ($wallet) {
            $wallet->setSoldeDisponible($wallet->getSoldeDisponible() + 2);
            $wallet->setSoldeEnAttente(max(0, $wallet->getSoldeEnAttente() -2));
        }

        // Retirer l'utilisateur des passagers
        $covoiturage->removePassager($user);

        // Libérer une place
        $covoiturage->setNbPlace($covoiturage->getNbPlace() + 1);

        // Si c’était FULL, repasser à PUBLISHED (ou PLANNED selon ta logique)
        if ($covoiturage->getStatut() === 'FULL') {
            $covoiturage->setStatut('PUBLISHED');
        }

        // Entités déjà managed : pas besoin de persist()
        $em->flush();

        $this->addFlash('success', 'Votre réservation a été annulée.');
        return $this->redirectToRoute('app_couvoiturage_show', ['id' => $covoiturage->getId()]);
    }
}
