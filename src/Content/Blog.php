<?php
/**
 * This file contains code to implement the class Blog.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Content;

/**
 * Blog class for My Content Database.
 */
class Blog extends Content
{
    /**************************************************************************************
                                        Private properties
    ***************************************************************************************/

    /**************************************************************************************
                                        Public methods
    ***************************************************************************************/

    /**
     * Constructor to initiate a Blog object.
     * @param $database The database from which content will be fetched.
     */
    public function __construct(\Anax\Database\Database $database)
    {
        parent::__construct($database);
    }


    /**
     * Show all items of type 'post'.
     * @return array as a list of the items.
     */
    public function showAllPosts()
    {
        $sql = "SELECT *,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published";
        $sql .= " FROM content WHERE type = ?";
        $sql .= " AND (deleted IS NULL OR deleted > NOW())";
        $sql .= " AND published <= NOW()";
        $sql .= " ORDER BY published DESC;";

        $content = $this->db->executeFetchAll($sql, ["post"]);
        return $content;
    }

    /**
     * Show a post with a specific slug.
     * @param string $slug The slug of the post.
     * @return object The post.
     */
    public function showPost($slug)
    {
        $sql = "SELECT *,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,";
        $sql .= " DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified";
        $sql .= " FROM content WHERE type = ? AND slug = ?";
        $sql .= " AND (deleted IS NULL OR deleted > NOW())";
        $sql .= " AND published <= NOW();";

        $content = $this->db->executeFetch($sql, ["post", $slug]);
        return $content;
    }

    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/
}
