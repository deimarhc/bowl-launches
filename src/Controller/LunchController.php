<?php

namespace App\Controller;

use App\Entity\Lunch;
use App\Form\LunchType;
use App\Repository\LunchRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lunch")
 */
class LunchController extends AbstractController
{
    /**
     * @Route("/", name="lunch_index", methods={"GET"})
     */
    public function index(LunchRepository $lunchRepository): Response
    {
        return $this->render('lunch/index.html.twig', [
            'lunches' => $lunchRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lunch_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $lunch = new Lunch();
        $form = $this->createForm(LunchType::class, $lunch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photoImage')->getData();
            if ($photoFile) {
                $photoFilename = $fileUploader->upload($photoFile, $this->getParameter('lunches_directory'));
                $lunch->setPhoto($photoFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lunch);
            $entityManager->flush();

            return $this->redirectToRoute('lunch_index');
        }

        return $this->render('lunch/new.html.twig', [
            'lunch' => $lunch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lunch_show", methods={"GET"})
     */
    public function show(Lunch $lunch): Response
    {
        return $this->render('lunch/show.html.twig', [
            'lunch' => $lunch,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lunch_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lunch $lunch, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(LunchType::class, $lunch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photoImage')->getData();
            if ($photoFile) {
                $photoFilename = $fileUploader->upload($photoFile, $this->getParameter('lunches_directory'));
                $lunch->setPhoto($photoFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lunch_index');
        }

        return $this->render('lunch/edit.html.twig', [
            'lunch' => $lunch,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lunch_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lunch $lunch): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lunch->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lunch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lunch_index');
    }
}
