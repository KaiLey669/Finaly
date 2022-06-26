<?php

namespace App\Controller;

use App\Entity\Continents;
use App\Form\ContinentsType;
use App\Repository\ContinentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/continents")
 */
class ContinentsController extends AbstractController
{
    /**
     * @Route("/", name="app_continents_index", methods={"GET"})
     */
    public function index(ContinentsRepository $continentsRepository): Response
    {
        return $this->render('continents/index.html.twig', [
            'continents' => $continentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_continents_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContinentsRepository $continentsRepository): Response
    {
        $continent = new Continents();
        $form = $this->createForm(ContinentsType::class, $continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $continentsRepository->add($continent, true);

            return $this->redirectToRoute('app_continents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('continents/new.html.twig', [
            'continent' => $continent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_continents_show", methods={"GET"})
     */
    public function show(Continents $continent): Response
    {
        return $this->render('continents/show.html.twig', [
            'continent' => $continent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_continents_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Continents $continent, ContinentsRepository $continentsRepository): Response
    {
        $form = $this->createForm(ContinentsType::class, $continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $continentsRepository->add($continent, true);

            return $this->redirectToRoute('app_continents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('continents/edit.html.twig', [
            'continent' => $continent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_continents_delete", methods={"POST"})
     */
    public function delete(Request $request, Continents $continent, ContinentsRepository $continentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$continent->getId(), $request->request->get('_token'))) {
            $continentsRepository->remove($continent, true);
        }

        return $this->redirectToRoute('app_continents_index', [], Response::HTTP_SEE_OTHER);
    }
}
