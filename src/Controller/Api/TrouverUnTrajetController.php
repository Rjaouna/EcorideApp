<?php // src/Controller/Api/TrouverUnTrajetController.php
namespace App\Controller\Api;

use App\Repository\CouvoiturageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TrouverUnTrajetController extends AbstractController
{
    #[Route('/trouver-un-trajet', name: 'app_trouver_un_trajet_page', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return $this->render('api/trouver_un_trajet/index.html.twig', [
            'depart'   => $request->query->get('depart'),
            'arrivee'  => $request->query->get('arrivee'),
            'departAt' => $request->query->get('departAt'),
        ]);
    }

    #[Route('/api/trouver/un/trajet', name: 'app_api_trouver_un_trajet', methods: ['GET'])]
    public function index(CouvoiturageRepository $repo, Request $request): Response
    {
        $depart   = trim((string) $request->query->get('depart', ''));
        $arrivee  = trim((string) $request->query->get('arrivee', ''));
        $departAtRaw = trim((string) $request->query->get('departAt', '')); // <-- unifie le nom
        $page     = max(1, (int) $request->query->get('page', 1));
        $limit    = min(100, max(1, (int) $request->query->get('limit', 20)));

        // Parse en DateTimeImmutable si fourni (ex. '2025-09-12' ou '2025-09-12T14:30')
        $departAt = null;
        if ($departAtRaw !== '') {
            try {
                $departAt = new \DateTimeImmutable($departAtRaw);
            } catch (\Throwable $e) {
                // tu peux renvoyer une 400 si tu veux être strict
                // return $this->json(['error' => 'Format date invalide'], 400);
            }
        }

        // ✅ repository avec typage clair et ordre cohérent
        $items = $repo->search(
            $depart ?: null,
            $arrivee ?: null,
            $departAt,         // \DateTimeInterface|null
            $page,
            $limit
        );

        $data = array_map(function ($c) {
            $driver = $c->getDriver();
            return [
                'id'           => $c->getId(),
                'lieuDepart'   => $c->getLieuDepart(),
                'lieuArrivee'  => $c->getLieuArrivee(),
                'departAt'     => $c->getDepartAt()?->format(DATE_ATOM),
                'arriveeAt'    => $c->getArriveeAt()?->format(DATE_ATOM),
                'prixPersonne' => (float) $c->getPrixPersonne(),
                'nbPlace'      => (int) $c->getNbPlace(),
                'statut'       => $c->getStatut(),
                'driver'       => $driver ? [
                    'id'     => $driver->getId(),
                    'prenom' => $driver->getPrenom(),
                    'nom'    => $driver->getNom(),
                ] : null,
            ];
        }, $items);

        return $this->json([
            'count' => count($data),
            'page'  => $page,
            'limit' => $limit,
            'data'  => $data,
        ]);
    }
}
