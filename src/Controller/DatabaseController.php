<?php

namespace FromSelect\Controller;

use FromSelect\Repository\DatabaseRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class DatabaseController extends AbstractController
{
    /**
     * @var DatabaseRepository
     */
    private $databaseRepository;

    /**
     * DatabaseController constructor, sets database tree as Twig global
     * variable because it is being used on all views.
     *
     * @param DatabaseRepository $databaseRepository
     */
    public function __construct(DatabaseRepository $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
    }

    /**
     * databases.all: GET /
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function all(Request $request, Response $response)
    {
        $databases = $this->databaseRepository->all();

        return $this->twig->render($response, '@fromselect/databases/all.twig', [
            'databases' => $databases
        ]);
    }

    /**
     * databases.show: GET /db/{database}
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');

        $tables = $this->databaseRepository->tablesByDatabase($database);

        return $this->twig->render($response, '@fromselect/databases/show.twig', [
            'tables' => $tables,
            'current' => [
                'database' => $database
            ],
        ]);
    }
}
