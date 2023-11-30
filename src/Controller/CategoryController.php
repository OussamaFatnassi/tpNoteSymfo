<?php

namespace App\Controller;

use App\Entity\Category;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categories', name: 'categories')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $repo,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Category/index.html.twig', [
            'categories' => $this->repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($category);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie créée avec succès');

            return $this->redirectToRoute('categories.index');
        }

        return $this->render('Category/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Category $category, Request $request): Response|RedirectResponse
    {
        if (!$category instanceof Category) {
            $this->addFlash('error', 'Catégorie non trouvée');

            return $this->redirectToRoute('categories.index');
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès');

            return $this->redirectToRoute('categories.index');
        }

        return $this->render('Category/update.html.twig', [
            'form' => $form,
            'category' => $category,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['GET', 'POST'])]
    public function delete(?Category $category, Request $request): Response|RedirectResponse
    {
        if (!$category instanceof Category) {
            $this->addFlash('error', 'Catégorie non trouvée');

            return $this->redirectToRoute('categories.index');
        }

        $this->em->remove($category);
        $this->em->flush();
        $this->addFlash('success', 'Catégorie supprimée avec succès');

        return $this->redirectToRoute('categories.index');
    }
}
