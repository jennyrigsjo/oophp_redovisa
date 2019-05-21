<?php
/**
 * This file contains code to implement the class MovieController.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */
namespace Anri16\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * Controller class for the 'movie' database. The class uses public functions in the class Query
 * to perform queries towards the table 'movie' in the database oophp (local/development)
 * and anri16 (production).
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Initiate a Query object to handle the queries made to the database.
     *
     * @return object
     */
    public function initAction() : object
    {
        $this->app->session->set("query", null);
        $this->app->session->set("query", new Query());

        return $this->app->response->redirect("movie/index");
    }

    /**
     * Select all items.
     *
     * @return object
     */
    public function indexAction() : object
    {
        $query = $this->app->session->get("query");
        $query->selectAllFromTable($this->app->db, "movie");

        $this->app->session->set("pageTitle", "Show all items");
        $this->app->session->set("views", ["result"]);

        return $this->app->response->redirect("movie/show-result");
    }

    /**
     * Show the result of the query.
     *
     * @return object
     */
    public function showResultAction() : object
    {
        $query = $this->app->session->get("query");

        $pageTitle = $this->app->session->getOnce("pageTitle", null);
        $views = $this->app->session->getOnce("views", []);

        $data = [
            "baseUrl" => $this->app->request->getBaseUrl(),
            "resultset" => $query->getResult(),
            "searchTitle" => $query->getArgs()[0] ?? null,
            "year1" => $query->getArgs()[0] ?? null,
            "year2" => $query->getArgs()[1] ?? null
            //"reset" => $this->app->session->getOnce("reset", null)
        ];

        $query->resetArgs();
        $query->resetResult();

        $this->app->page->add("movie/wrapper-opening");

        $this->app->page->add("movie/header-navbar", $data);

        foreach ($views as $view) {
            $this->app->page->add("movie/{$view}", $data);
        }

        $this->app->page->add("movie/wrapper-closing");

        //$this->app->page->add("movie/debug");

        return $this->app->page->render([
            "title" => "{$pageTitle} | My Movie Database"
        ]);
    }

    /**
     * Search for an item with a particular title.
     *
     * @return object
     */
    public function searchTitleAction() : object
    {
        $doSearch = $this->app->request->getPost("doSearch", null);
        $searchTitle = $this->app->request->getPost("searchTitle", null);

        if ($doSearch && $searchTitle) {
            $query = $this->app->session->get("query");
            $query->selectFromTableWhereLike($this->app->db, "movie", "title", $searchTitle);
        }

        $this->app->session->set("pageTitle", "Search by title");
        $this->app->session->set("views", ["search-title", "result"]);

        return $this->app->response->redirect("movie/show-result");
    }

    /**
     * Search for an item with a particular title.
     *
     * @return object
     */
    public function searchYearAction() : object
    {
        $year1 = $this->app->request->getGet("year1", null);

        $year2 = $this->app->request->getGet("year2", null);

        $doSearch = $this->app->request->getGet("doSearch", null);

        if ($doSearch) {
            $query = $this->app->session->get("query");
            $query->selectCompareOneColumnTwoValues($this->app->db, "movie", "year", $year1, $year2);
        }

        $this->app->session->set("pageTitle", "Search by year");
        $this->app->session->set("views", ["search-year", "result"]);

        return $this->app->response->redirect("movie/show-result");
    }

    /**
     * Select an item and redirect to perform CRUD on it.
     *
     * @return object
     */
    public function selectAction() : object
    {
        $doCRUD = $this->app->request->getPost("doCRUD", null);

        if ($doCRUD) {
            $movieId = $this->app->request->getPost("movieId", null);

            switch ($doCRUD) {
                case "Edit":
                    $redirect = "movie/update?id=$movieId";
                    break;
                case "Delete":
                    $redirect = "movie/delete?id=$movieId";
                    break;
            }
        } else {
            $this->app->session->set("pageTitle", "Edit or delete a movie");
            $this->app->session->set("views", ["select-movie"]);

            $query = $this->app->session->get("query");
            $query->selectAllFromTable($this->app->db, "movie", ["id", "title"]);
            $redirect = "movie/show-result";
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Create (add) an item.
     *
     * @return object
     */
    public function addAction() : object
    {
        $doAdd = $this->app->request->getPost("doAdd");

        if ($doAdd) {
            $movieTitle = $this->app->request->getPost("movieTitle", "No title");
            $movieYear  = $this->app->request->getPost("movieYear", 2019);
            $movieYear = ($movieYear === "") ? 2019 : $movieYear;
            $movieImage = $this->app->request->getPost("movieImage", "img/movie/noimage.png");
            $movieImage = ($movieImage === "") ? "img/movie/noimage.png" : $movieImage;

            $query = $this->app->session->get("query");
            $query->executeInsert($this->app->db, "movie", ["title", "year", "image"], [$movieTitle, $movieYear, $movieImage]);

            return $this->app->response->redirect("movie/index");
        } else {
            $this->app->session->set("pageTitle", "Add a movie");
            $this->app->session->set("views", ["movie-add"]);
            return $this->app->response->redirect("movie/show-result");
        }
    }

    /**
     * Update (edit) an item.
     *
     * @return object
     */
    public function updateAction() : object
    {
        $this->app->session->set("pageTitle", "Update a movie");
        $this->app->session->set("views", ["movie-edit"]);

        $query = $this->app->session->get("query");
        $movieId = $this->app->request->getGet("id");
        $query->selectFromTableWhereFirstEquals($this->app->db, "movie", "id", $movieId);

        return $this->app->response->redirect("movie/show-result");
    }

    /**
     * Save changes made to an item.
     *
     * @return object
     */
    public function saveAction() : object
    {
        $doSave = $this->app->request->getPost("doSave");

        if (!$doSave) {
            return $this->app->response->redirect("movie/index");
        }

        $movieId = $this->app->request->getPost("movieId");
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear  = $this->app->request->getPost("movieYear");
        $movieImage = $this->app->request->getPost("movieImage");

        $query = $this->app->session->get("query");
        $query->executeUpdate($this->app->db, "movie", ["title", "year", "image", "id"], [$movieTitle, $movieYear, $movieImage, $movieId]);

        return $this->app->response->redirect("movie/update?id=$movieId");
    }

    /**
     * Delete an item.
     *
     * @return object
     */
    public function deleteAction() : object
    {
        $movieId = $this->app->request->getGet("id");

        if ($movieId) {
            $query = $this->app->session->get("query");
            $query->executeDelete($this->app->db, "movie", "id", $movieId);
        }

        return $this->app->response->redirect("movie/index");
    }

    /**
     * Reset the database.
     *
     * @return object
     */
    public function resetAction() : object
    {
        $config = getDatabaseConfig();

        $mysql  = $config["mysql"];
        $host = $config["host"];
        $database = $config["database"];
        $login = $config["login"];
        $password = $config["password"];

        $file   = "../sql/movie/setup.sql";

        $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
        $output = [];
        $status = null;

        exec($command, $output, $status);

        $output = "<p>The command exit status was $status."
            //. "<br>The command was: <code>$command</code>."
            . "<br>The output from the command was:</p>"
            . "<pre>"
            . print_r($output, 1)
            . "</pre>";

        //$this->app->session->set("reset", $output);

        return $this->app->response->redirect("movie/index");
    }
}
