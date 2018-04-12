<?php

namespace App\Controller;

use App\Entity\CovertFormEntity;
use App\Service\CurrencyService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CurrencyController extends Controller
{
    private $currencyService;

    function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index(Request $request)
    {
        $covertFormEntity = new CovertFormEntity();
        $covertFormEntity->setFrom('USD');
        $covertFormEntity->setTo('RON');
        $covertFormEntity->setValue('1');
        $response = '';

        $form = $this->createFormBuilder($covertFormEntity)
            ->add('from', ChoiceType::class, array('choices'  => $this->currencyService->getCurrencies()))
            ->add('to', ChoiceType::class, array('choices'  => $this->currencyService->getCurrencies()))
            ->add('value', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Convert'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CovertFormEntity $covertFormEntity */
            $covertFormEntity = $form->getData();
            $result = $this->currencyService->convert(
                $covertFormEntity->getFrom(),
                $covertFormEntity->getTo(),
                $covertFormEntity->getValue()
            );
            $response = $result !== null ? $covertFormEntity->getValue() . ' ' . $covertFormEntity->getFrom() . ' = '
                . number_format($result, 2) . ' ' . $covertFormEntity->getTo()
                : 'Conversion Error';
        }

        return $this->render('currency/index.html.twig', [
            'response' => $response ,
            'form' => $form->createView(),
        ]);
    }
}
