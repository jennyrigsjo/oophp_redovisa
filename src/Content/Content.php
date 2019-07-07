<?php
/**
 * This file contains code to implement the class Content.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Content;

/**
 * General content class for My Content Database.
 */
class Content
{
    /**************************************************************************************
                                        Private/protected properties
    ***************************************************************************************/

    /**
     * @var string $db    The database in which the content is stored.
     */
    protected $db = null;

    /**************************************************************************************
                                        Public methods
    ***************************************************************************************/

    /**
     * Constructor to initiate a Content object.
     * @param $database The database from which content will be fetched.
     */
    public function __construct(\Anax\Database\Database $database)
    {
        $this->db = $database;
        $this->db->connect();
    }

    /**
     * Show all items.
     * @param string $orderby The column by which data should be sorted, default "id".
     * @param string $order The sorting order (ascending "asc" or descending "desc"), default "asc".
     * @param integer $hits The number of hits/items per page, default 4.
     * @param integer $page The target page, default 1.
     * @return string as the result of the query.
     */
    public function showAll($orderby = "id", $order = "asc", $hits = 4, $page = 1)
    {
        $offset = $hits * ($page - 1);

        $sql = "SELECT *,";
        $sql .= " CASE";
        $sql .= " WHEN (deleted <= NOW()) THEN 'isDeleted'";
        $sql .= " WHEN (published <= NOW()) THEN 'isPublished'";
        $sql .= " ELSE 'notPublished'";
        $sql .= " END AS status";
        $sql .= " FROM content";
        $sql .= " ORDER BY $orderby $order";
        $sql .= " LIMIT $hits OFFSET $offset;";

        $res = $this->db->executeFetchAll($sql);

        return $res;
    }

    /**
     * Show an item with a specific id.
     * @param int $id The ID of the item.
     * @param string $columns The columns to be selected (default all columns).
     * @return object as the item.
     */
    public function showItem($id, $columns = "")
    {
        $sql = "";
        if ($columns === "") {
            $sql = "SELECT * FROM content WHERE id = ?;";
        } else {
            $sql = "SELECT $columns FROM content WHERE id = ?;";
        }
        $content = $this->db->executeFetch($sql, [$id]);
        return $content;
    }

    /**
     * Get the maximum/highest number of pages.
     * @param integer $hits The number of hits/items per page.
     * @return integer The max number of pages.
     */
    public function getMaxPage($hits)
    {
        $sql = "SELECT COUNT(id) AS max FROM content;";
        $max = $this->db->executeFetchAll($sql);
        $max = ceil($max[0]->max / $hits);
        return $max;
    }

    /**
     * Add an item.
     * @param string $title The name/title of the item.
     * @return int as the ID of the last row insertion.
     */
    public function create($title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    /**
     * Update an item.
     * @param array $params The parameters, including ID, needed to update the row.
     */
    public function update($params)
    {
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";

        if (!$params["path"]) {
            $params["path"] = null;
        }

        if (!$params["slug"]) {
            $params["slug"] = slugify($params["title"]);
        }

        try {
            $this->db->execute($sql, array_values($params));
        } catch (\Anax\Database\Exception\Exception $e) {
            $slug = $params["slug"];
            $message = "Error: The slug '$slug' is already in use. Please select a different slug.";
            throw new \Anax\Database\Exception\Exception($message);
        }
    }

    /**
     * Delete an item.
     * @param int $id The ID of the item to be deleted.
     */
    public function delete($id)
    {
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->db->execute($sql, [$id]);
    }

    /**
     * Restore a previously deleted item.
     * @param int $id The ID of the item to be restored.
     */
    public function restore($id)
    {
        $sql = "UPDATE content SET deleted=NULL WHERE id=?;";
        $this->db->execute($sql, [$id]);
    }


    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/
}
