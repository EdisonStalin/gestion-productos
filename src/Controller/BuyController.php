<?php

namespace App\Controller;

use App\Entity\Buy;
use App\Form\BuyType;
use App\Repository\BuyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/compra")
 */
class BuyController extends AbstractController
{
    /**
     * @Route("/", name="buy_index", methods={"GET"})
     */
    public function index(BuyRepository $buyRepository): Response
    {
        
        return $this->render('buy/index.html.twig', [
            'buys' => $buyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nuevo", name="buy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $buy = new Buy();
        $form = $this->createForm(BuyType::class, $buy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $buy->setUser($this->getUser());
            $entityManager->persist($buy);
            $entityManager->flush();

            return $this->redirectToRoute('buy_index');
        }

        return $this->render('buy/new.html.twig', [
            'buy' => $buy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="buy_show", methods={"GET"})
     */
    public function show(Buy $buy): Response
    {
        return $this->render('buy/show.html.twig', [
            'buy' => $buy,
        ]);
    }

    /**
     * @Route("/{id}/editar", name="buy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Buy $buy): Response
    {
        $form = $this->createForm(BuyType::class, $buy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('buy_index');
        }

        return $this->render('buy/edit.html.twig', [
            'buy' => $buy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="buy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Buy $buy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$buy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($buy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('buy_index');
    }
}
