<?php

namespace App\Controller;

use App\Entity\Languages;
use App\Form\LanguagesType;
use App\Repository\LanguagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/languages")
 */
class LanguagesController extends AbstractController
{
    /**
     * @Route("/", name="app_languages_index", methods={"GET"})
     */
    public function index(LanguagesRepository $languagesRepository): Response
    {
        return $this->render('languages/index.html.twig', [
            'languages' => $languagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_languages_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LanguagesRepository $languagesRepository): Response
    {
        $language = new Languages();
        $form = $this->createForm(LanguagesType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $languagesRepository->add($language, true);

            return $this->redirectToRoute('app_languages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('languages/new.html.twig', [
            'language' => $language,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_languages_show", methods={"GET"})
     */
    public function show(Languages $language): Response
    {
        return $this->render('languages/show.html.twig', [
            'language' => $language,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_languages_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Languages $language, LanguagesRepository $languagesRepository): Response
    {
        $form = $this->createForm(LanguagesType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $languagesRepository->add($language, true);

            return $this->redirectToRoute('app_languages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('languages/edit.html.twig', [
            'language' => $language,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_languages_delete", methods={"POST"})
     */
    public function delete(Request $request, Languages $language, LanguagesRepository $languagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$language->getId(), $request->request->get('_token'))) {
            $languagesRepository->remove($language, true);
        }

        return $this->redirectToRoute('app_languages_index', [], Response::HTTP_SEE_OTHER);
    }
}
