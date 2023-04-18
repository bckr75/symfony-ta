<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\TaxNumber;
use App\Form\CalculatorType;
use App\Repository\ProductRepository;
use App\Repository\TaxNumberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        Request $request,
        TaxNumberRepository $taxNumberRepository
    ): Response {
        $form = $this->createForm(CalculatorType::class);

        $form->handleRequest($request);

        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            /** @var Product $product */
            $product = $data['product'];

            $formTaxNumber = $data['tax_number'];

            $prefix = substr($formTaxNumber, 0, 2);

            $taxNumber = $taxNumberRepository->findTaxNumberByPrefix($prefix);

            if ($taxNumber !== null) {
                $price = (string)$product->getPrice();

                $tax = bcmul($price, (string)$taxNumber->getTax(), 5);

                $result = bcadd($price, $tax, 5);
            } else {
                $form->get('tax_number')->addError(new FormError('Tax Number not found'));
            }
        }

        return $this->renderForm('index/index.html.twig', [
            'form' => $form,
            'result' => $result,
        ]);
    }
}
