<?php

namespace App\Controller;

use App\Entity\About;
use App\Entity\AboutText;
use App\Entity\Languages;
use App\Entity\Hobbies;
use App\Form\AboutType;
use App\Form\AboutTextType;
use App\Form\LanguagesType;
use App\Form\HobbiesType;
use App\Repository\AboutRepository;
use App\Repository\AboutTextRepository;
use App\Repository\HobbiesRepository;
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
        $aboutTexts = $em->getRepository(AboutText::class)->sortByPosition();
        $languages = $em->getRepository(Languages::class)->findAll();
        $hobbies = $em->getRepository(Hobbies::class)->sortByName();

        # Calcule de l'âge automatiquement et stockage dans une variable.
        $datetime1 = new \DateTime('now');
        $datetime2 = new \DateTime('1991-12-18');
        $age = $datetime1->diff($datetime2, true)->y;

        return $this->render('about/index.html.twig', [
            'abouts' => $aboutRepository->findAll(),
            'aboutTexts' => $aboutTexts ,
            'age' => $age ,
            'languages' => $languages ,
            'hobbies' => $hobbies ,
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
     * @Route("/text/new", name="text_new", methods={"GET","POST"})
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
     * @Route("/text/{id}/edit", name="text_edit", methods={"GET","POST"})
     */
    public function textEdit(Request $request, AboutText $aboutText)
    {
        $form = $this->createForm(AboutTextType::class, $aboutText);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('aboutText/edit.html.twig', [
            'aboutText' => $aboutText,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/text/{id}", name="text_delete")
     */
    public function textDelete($id)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(AboutText::class)->find($id);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('about_index');
    }

    /**
     * @Route("/lang/{id}/edit", name="lang_edit", methods={"GET","POST"})
     */
    public function langEdit(Request $request, Languages $languages): Response
    {
        $form = $this->createForm(LanguagesType::class, $languages);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('languages/edit.html.twig', [
            'languages' => $languages,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/hobbie/new", name="hobbie_new", methods={"GET","POST"})
     */
    public function hobbieNew(Request $request): Response
    {
        $hobbies = new Hobbies();
        $form = $this->createForm(HobbiesType::class, $hobbies);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hobbies);
            $entityManager->flush();

            return $this->redirectToRoute('about_index');
        }

        return $this->render('hobbies/new.html.twig', [
            'hobbies' => $hobbies,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/hobbie/{id}", name="hobbie_delete")
     */
    public function hobbieDelete($id)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(hobbies::class)->find($id);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('about_index');
    }
}
