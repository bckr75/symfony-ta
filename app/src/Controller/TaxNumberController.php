<?php

namespace App\Controller;

use App\Entity\TaxNumber;
use App\Form\TaxNumberType;
use App\Repository\TaxNumberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tax_number')]
class TaxNumberController extends AbstractController
{
    #[Route('/', name: 'app_tax_number_index', methods: ['GET'])]
    public function index(TaxNumberRepository $taxNumberRepository): Response
    {
        return $this->render('tax_number/index.html.twig', [
            'tax_numbers' => $taxNumberRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tax_number_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaxNumberRepository $taxNumberRepository): Response
    {
        $taxNumber = new TaxNumber();
        $form = $this->createForm(TaxNumberType::class, $taxNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taxNumberRepository->save($taxNumber, true);

            return $this->redirectToRoute('app_tax_number_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tax_number/new.html.twig', [
            'tax_number' => $taxNumber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tax_number_show', methods: ['GET'])]
    public function show(TaxNumber $taxNumber): Response
    {
        return $this->render('tax_number/show.html.twig', [
            'tax_number' => $taxNumber,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tax_number_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaxNumber $taxNumber, TaxNumberRepository $taxNumberRepository): Response
    {
        $form = $this->createForm(TaxNumberType::class, $taxNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taxNumberRepository->save($taxNumber, true);

            return $this->redirectToRoute('app_tax_number_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tax_number/edit.html.twig', [
            'tax_number' => $taxNumber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tax_number_delete', methods: ['POST'])]
    public function delete(Request $request, TaxNumber $taxNumber, TaxNumberRepository $taxNumberRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxNumber->getId(), $request->request->get('_token'))) {
            $taxNumberRepository->remove($taxNumber, true);
        }

        return $this->redirectToRoute('app_tax_number_index', [], Response::HTTP_SEE_OTHER);
    }
}
