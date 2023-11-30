<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private BookRepository $bookRepo,
        private CategoryRepository $categoryRepo,
        private AuthorRepository $authorRepo
    ) {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('Home/index.html.twig', [
            'books' => $this->bookRepo->findAll(),
            'categories' => $this->categoryRepo->findAll(),
            'authors' => $this->authorRepo->findAll(),
        ]);
    }
}
