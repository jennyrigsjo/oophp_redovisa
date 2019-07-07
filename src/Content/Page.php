<?php
/**
 * This file contains code to implement the class Page.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Content;

/**
 * Page class for My Content Database.
 */
class Page extends Content
{
    /**************************************************************************************
                                        Private properties
    ***************************************************************************************/

    /**************************************************************************************
                                        Public methods
    ***************************************************************************************/

    /**
     * Constructor to initiate a Page object.
     * @param $database The database from which content will be fetched.
     */
    public function __construct(\Anax\Database\Database $database)
    {
        parent::__construct($database);
    }

    /**
     * Show all items of type 'page'.
     * @return array as a list of the items.
     */
    public function showAllPages()
    {
        $sql = "SELECT *,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published";
        $sql .= " FROM content WHERE type = ?";
        $sql .= " AND (deleted IS NULL OR deleted > NOW())";
        $sql .= " AND published <= NOW()";
        $sql .= " ORDER BY published DESC;";

        $content = $this->db->executeFetchAll($sql, ["page"]);
        return $content;
    }

    /**
     * Show a page with a specific path.
     * @param string $path The path to the page.
     * @return object The page.
     */
    public function showPage($path)
    {
        $sql = "SELECT *,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified";
        $sql .= " FROM content WHERE type = ? AND path = ?";
        $sql .= " AND (deleted IS NULL OR deleted > NOW())";
        $sql .= " AND published <= NOW();";

        $content = $this->db->executeFetch($sql, ["page", $path]);
        return $content;
    }


    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/
}
