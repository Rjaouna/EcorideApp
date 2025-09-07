<?php

namespace App\Controller\Driver;

use App\Entity\Couvoiturage;
use App\Form\CouvoiturageType;
use App\Repository\CouvoiturageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/couvoiturage')]
final class CouvoiturageController extends AbstractController
{
    #[Route(name: 'app_couvoiturage_index', methods: ['GET'])]
    public function index(CouvoiturageRepository $couvoiturageRepository): Response
    {
        $user = $this->getUser();
        return $this->render('driver/couvoiturage/index.html.twig', [
            'couvoiturages' => $couvoiturageRepository->findBy(['driver' => $user]),
        ]);
    }

    #[Route('/new', name: 'app_couvoiturage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $couvoiturage = new Couvoiturage();
        $form = $this->createForm(CouvoiturageType::class, $couvoiturage);
        $form->handleRequest($request);
        $driver = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $couvoiturage->setDriver($driver);
            $couvoiturage->setStatut('PLANIFIER');
            $entityManager->persist($couvoiturage);
            $entityManager->flush();

            return $this->redirectToRoute('app_couvoiturage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('driver/couvoiturage/new.html.twig', [
            'couvoiturage' => $couvoiturage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_couvoiturage_show', methods: ['GET'])]
    public function show(Couvoiturage $couvoiturage): Response
    {
        return $this->render('driver/couvoiturage/show.html.twig', [
            'couvoiturage' => $couvoiturage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_couvoiturage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Couvoiturage $couvoiturage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CouvoiturageType::class, $couvoiturage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_couvoiturage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('driver/couvoiturage/edit.html.twig', [
            'couvoiturage' => $couvoiturage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_couvoiturage_delete', methods: ['POST'])]
    public function delete(Request $request, Couvoiturage $couvoiturage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$couvoiturage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($couvoiturage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_couvoiturage_index', [], Response::HTTP_SEE_OTHER);
    }
}
