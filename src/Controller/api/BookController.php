<?php

namespace App\Controller\api;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BookController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(EntityManagerInterface $em)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->em = $em;
    }

    /**
     * @Route("/api/books", name="books_index",methods={"GET"})
     */
    public function list()
    {
        $books = $this->em->getRepository(Book::class)->findAll();
        if (empty($books)) {
            return $this->json(["The list of books is empty"], Response::HTTP_NOT_FOUND);
        }
        return $this->json($books, Response::HTTP_OK);
    }

    /**
     * @Route("api/books/{id}",name="books_show",methods={"GET"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id)
    {
        $book = $this->em->getRepository(Book::class)->find($id);
        if (null === $book) {
            return $this->json(["The book cannot be found"], Response::HTTP_NOT_FOUND);
        }
        return $this->json($book, Response::HTTP_OK);
    }

    /**
     * @Route("api/books/{id}",name="books_delete",methods={"DELETE"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(int $id)
    {
        $book = $this->em->getRepository(Book::class)->find($id);
        if (null === $book) {
            return $this->json(["The book cannot be found"], Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($book);
        $this->em->flush();
        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("api/books/{id}",name="books_update",methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $book = $this->em->getRepository(Book::class)->find($id);
        if (null === $book) {
            return $this->json(["The book cannot be found"], Response::HTTP_NOT_FOUND);
        }
        $book = $this->serializer->deserialize($request->getContent(), Book::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $book]);
        $this->em->flush();
        return $this->json(['Book updated with success'], Response::HTTP_OK);
    }

    /**
     * @Route("api/books/",name="books_create",methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $book = $this->serializer->deserialize($request->getContent(), Book::class, 'json');
        $this->em->persist($book);
        $this->em->flush();
        return $this->json(['Book created with success'], Response::HTTP_CREATED);
    }
}
