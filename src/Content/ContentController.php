<?php
/**
 * This file contains code to implement the class ContentController.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */
namespace Anri16\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * Controller class for My Content Database.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var Content $content A class/api for general content management.
     */
    private $content = null;

    /**
     * @var Blog $blog A class/api for managing content of type 'blog'.
     */
    private $blog = null;

    /**
     * @var Page $page A class/api for managing content of type 'page'.
     */
    private $page = null;

    /**
     * @var User $user A class/api for managing user-related information.
     */
    private $user = null;


    /**
     * Initialize the Content, Blog and Page classes before calling the target method/action.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->content = new Content($this->app->db);
        $this->blog = new Blog($this->app->db);
        $this->page = new Page($this->app->db);
        $this->user = new User($this->app->db);
        $this->config = new \Anax\Configure\Configuration();
    }

    /**
     * Show landing page for the CMS.
     *
     * @return object
     */
    public function indexAction() : object
    {
        $this->app->session->set("pageTitle", "Start here");
        $this->app->session->set("views", ["index"]);

        return $this->app->response->redirect("content/result");
    }

    /**
     * Log in.
     *
     * @return object
     */
    public function loginAction() : object
    {
        if ($this->app->session->get("user")) {
            return $this->app->response->redirect("content/logout");
        }

        $this->app->session->set("views", ["login"]);
        $redirect = "content/result";

        if ($this->app->request->getPost("doLogin", null)) {
            $params = getPostValues([
                "name",
                "password"
            ]);

            if ($this->user->passwordIsCorrect($params["name"], $params["password"])) {
                $user = $params["name"];
                $this->app->session->set("user", $user);
                $this->app->session->set("okMessage", "Successfully logged in as '$user'.");
                $redirect = "content/show-all";
            } else {
                $this->app->session->set("error", "Incorrect user name and/or password!");
            }
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Log out.
     *
     * @return object
     */
    public function logoutAction() : object
    {
        $this->app->session->set("views", ["logout"]);
        $redirect = "content/result";

        if ($this->app->request->getPost("doLogout", null)) {
            $user = $this->app->session->getOnce("user");
            $this->app->session->set("okMessage", "User '$user' has logged out.");
            $redirect = "content/show-all";
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Show all items.
     *
     * @return object
     */
    public function showAllAction() : object
    {
        $orderby = $this->app->request->getGet("orderby", "id");
        $order = $this->app->request->getGet("order", "asc");

        $hits = $this->app->request->getGet("hits", 4); // How many rows to display per page
        $page = $this->app->request->getGet("page", 1); // Current page, use to calculate offset value
        $max = $this->content->getMaxPage($hits); // Max pages available

        try {
            validateSort($orderby, $order);

            verifyIsNumeric($hits);
            validateHitsRange($hits);

            verifyIsNumeric($page);
            validatePageNumber($page, $max);
        } catch (\Anax\Database\Exception\Exception $e) {
            $this->app->session->set("exception", $e->getMessage());
            $orderby = "id";
            $order = "asc";
            $hits = 4;
            $page = 1;
        }

        $this->app->session->set("pageTitle", "Show all content");
        $this->app->session->set("views", ["show-all"]);

        $this->app->session->set("hits", $hits);
        $this->app->session->set("page", $page);
        $this->app->session->set("pages", $max);

        $this->app->session->set("resultset", $this->content->showAll($orderby, $order, $hits, $page));

        return $this->app->response->redirect("content/result");
    }

    /**
     * Show a list of blog posts or a specific blog post.
     * @param string $slug The slug of a specific post (optional)
     * @return object
     */
    public function blogAction($slug = null) : object
    {
        $res = null;

        if ($slug) {
            $res = $this->blog->showPost($slug);
            $this->app->session->set("pageTitle", "Blog post");
            $this->app->session->set("views", ["post"]);
        } else {
            $res = $this->blog->showAllPosts();
            $this->app->session->set("pageTitle", "Blog");
            $this->app->session->set("views", ["blog"]);
        }

        $redirect = "content/result";

        if (!$res) {
            $redirect = ($slug) ? "content/not-found?route=blog/$slug" : "content/not-found?route=blog";
        } else {
            $res = formatText($res);
            $this->app->session->set("resultset", $res);
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Show a list of all pages or a specific page.
     * @param string $path The path to a specific page (optional)
     * @return object
     */
    public function pageAction($path = null) : object
    {
        $res = null;

        if ($path) {
            $res = $this->page->showPage($path);
            $this->app->session->set("pageTitle", "Page");
            $this->app->session->set("views", ["page"]);
        } else {
            $res = $this->page->showAllPages();
            $this->app->session->set("pageTitle", "All pages");
            $this->app->session->set("views", ["pages"]);
        }

        $redirect = "content/result";

        if (!$res) {
            $redirect = ($path) ? "content/not-found?route=page/$path" : "content/not-found?route=page";
        } else {
            $res = formatText($res);
            $this->app->session->set("resultset", $res);
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Create an item.
     *
     * @return object
     */
    public function createAction() : object
    {
        $this->app->session->set("pageTitle", "Add content");
        $this->app->session->set("views", ["create"]);
        $redirect = "content/result";

        if ($this->app->request->getPost("doCreate", null)) {
            $title = $this->app->request->getPost("title");
            $id = $this->content->create($title);
            $redirect = "content/edit?id=$id";
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Edit an item.
     *
     * @return object
     */
    public function editAction() : object
    {
        $this->app->session->set("pageTitle", "Edit content");
        $this->app->session->set("views", ["edit"]);

        $id = $this->app->request->getGet("id") ?? $this->app->request->getPost("id");

        try {
            verifyIsNumeric($id);
        } catch (\Anax\Database\Exception\Exception $e) {
            $this->app->session->set("exception", $e->getMessage());
        }

        if ($this->app->request->getPost("doSave", null)) {
            $params = getPostValues([
                "title",
                "path",
                "slug",
                "data",
                "type",
                "filter",
                "published",
                "id"
            ]);

            try {
                $this->content->update($params);
            } catch (\Anax\Database\Exception\Exception $e) {
                $this->app->session->set("exception", $e->getMessage());
                $this->app->session->set("views", ["edit"]);
            }
        }

        $this->app->session->set("resultset", $this->content->showItem($id));

        return $this->app->response->redirect("content/result");
    }

    /**
     * Delete an item.
     *
     * @return object
     */
    public function deleteAction() : object
    {
        $this->app->session->set("pageTitle", "Delete content");
        $this->app->session->set("views", ["delete"]);
        $redirect = "content/result";

        $id = $this->app->request->getGet("id") ?? $this->app->request->getPost("id");

        try {
            verifyIsNumeric($id);
        } catch (\Anax\Database\Exception\Exception $e) {
            $this->app->session->set("exception", $e->getMessage());
        }

        if ($this->app->request->getPost("doDelete", null)) {
            $this->content->delete($id);
            $redirect = "content/show-all";
        } else {
            $this->app->session->set("resultset", $this->content->showItem($id, "id, title"));
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Restore a previously deleted item.
     *
     * @return object
     */
    public function restoreAction() : object
    {
        $this->app->session->set("pageTitle", "Restore content");
        $this->app->session->set("views", ["restore"]);
        $redirect = "content/result";

        $id = $this->app->request->getGet("id") ?? $this->app->request->getPost("id");

        try {
            verifyIsNumeric($id);
        } catch (\Anax\Database\Exception\Exception $e) {
            $this->app->session->set("exception", $e->getMessage());
        }

        if ($this->app->request->getPost("doRestore", null)) {
            $this->content->restore($id);
            $redirect = "content/show-all";
        } else {
            $this->app->session->set("resultset", $this->content->showItem($id, "id, title"));
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Reset the database.
     *
     * @return object
     */
    public function resetAction() : object
    {
        $this->app->session->set("views", ["reset"]);
        $redirect = "content/result";

        if ($this->app->request->getPost("doReset", null)) {
            $dir = ["../config"];
            $this->config->setBaseDirectories($dir);
            $configFile = $this->app->get("configuration")->load("database");
            $config = $configFile["config"];
            $dsn = $config["dsn"];
            $host = getStringBetween($dsn, "host=", ";");
            $database = getStringBetween($dsn, "dbname=", ";");
            $login = $config["username"];
            $password = $config["password"];
            $mysql = ($host === "127.0.0.1") ? "C:\cygwin64\bin\mysql.exe" : "mysql";

            $sqlFile = "../sql/content/setup.sql";

            $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $sqlFile 2>&1";
            $output = [];
            $status = null;

            exec($command, $output, $status);

            $output = "<p>The command exit status was $status."
                //. "<br>The command was: <code>$command</code>."
                . "<br>The output from the command was:</p>"
                . "<pre>"
                . print_r($output, 1)
                . "</pre>";

            $this->app->session->set("reset", $output);
            $redirect = "content/show-all";
        }

        return $this->app->response->redirect($redirect);
    }

    /**
     * Show an error message if a page cannot be found.
     *
     * @return object
     */
    public function notFoundAction() : object
    {
        $this->app->session->set("pageTitle", "404 Not Found");
        $this->app->session->set("views", ["404"]);

        $route = $this->app->request->getGet("route");
        $this->app->session->set("notFound", $route);

        return $this->app->response->redirect("content/result");
    }

    /**
     * Show the result of the lastest action/query.
     *
     * @return object
     */
    public function resultAction() : object
    {
        $pageTitle = $this->app->session->getOnce("pageTitle");
        $views = $this->app->session->getOnce("views", []);

        $data = [
            "resultset" => $this->app->session->getOnce("resultset"),
            "reset" => $this->app->session->getOnce("reset"),
            "notFound" => $this->app->session->getOnce("notFound"),
            "exception" => $this->app->session->getOnce("exception"),
            "error" => $this->app->session->getOnce("error"),
            "okMessage" => $this->app->session->getOnce("okMessage"),
            "user" => $this->app->session->get("user"),
            "hits" => $this->app->session->get("hits"),
            "page" => $this->app->session->get("page"),
            "pages" => $this->app->session->get("pages")
        ];

        $this->app->page->add("content/wrapper-opening");

        $this->app->page->add("content/header", $data);

        $this->app->page->add("content/message", $data);

        foreach ($views as $view) {
            $this->app->page->add("content/{$view}", $data);
        }

        $this->app->page->add("content/wrapper-closing");

        //$this->app->page->add("content/debug");

        return $this->app->page->render([
            "title" => "{$pageTitle} | My Content Database"
        ]);
    }
}
