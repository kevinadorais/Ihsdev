<?php

namespace App\Controller;

use App\Entity\About;
use App\Entity\AboutText;
use App\Entity\Languages;
use App\Form\AboutType;
use App\Form\AboutTextType;
use App\Form\LanguagesType;
use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/about")
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/", name="about_index", methods={"GET"})
     */
    public function index(AboutRepository $aboutRepository): Response
    {
        # Ouverture de la base de données, récuperation des données et stockage dans une variable.
        $em = $this->getDoctrine()->getManager(); 
        $aboutTexts = $em->getRepository(AboutText::class)->findAll();
        $languages = $em->getRepository(Languages::class)->findAll();

        # Calcule de l'âge automatiquement et stockage dans une variable.
        $datetime1 = new \DateTime('now');
        $datetime2 = new \DateTime('1991-12-18');
        $age = $datetime1->diff($datetime2, true)->y;

        return $this->render('about/index.html.twig', [
            'abouts' => $aboutRepository->findAll(),
            'aboutTexts' => $aboutTexts ,
            'age' => $age ,
            'languages' => $languages ,
        ]);
    }

    /**
     * @Route("/new", name="about_new", methods={"GET","POST"})
     */
    public function aboutNew(Request $request): Response
    {
        $about = new About();
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($about);
            $entityManager->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('about/new.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="about_edit", methods={"GET","POST"})
     */
    public function aboutEdit(Request $request, About $about): Response
    {
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('about/edit.html.twig', [
            'about' => $about,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_delete", methods={"DELETE"})
     */
    public function aboutDelete(Request $request, About $about): Response
    {
        if ($this->isCsrfTokenValid('delete'.$about->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($about);
            $entityManager->flush();
        }

        return $this->redirectToRoute('about_index');
    }

    /**
     * @Route("/text/new", name="aboutText_new", methods={"GET","POST"})
     */
    public function textNew(Request $request): Response
    {
        $aboutText = new AboutText();
        $form = $this->createForm(AboutTextType::class, $aboutText);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aboutText);
            $entityManager->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('abouttext/new.html.twig', [
            'aboutText' => $aboutText,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/lang/new", name="lang_new", methods={"GET","POST"})
     */
    public function languageNew(Request $request): Response
    {
        $languages = new Languages();
        $form = $this->createForm(LanguagesType::class, $languages);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($languages);
            $entityManager->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('languages/new.html.twig', [
            'languages' => $languages,
            'form' => $form->createView(),
        ]);
    }
}
