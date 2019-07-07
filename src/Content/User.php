<?php
/**
 * This file contains code to implement the class Content.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Content;

/**
 * Content class for My Content Database.
 */
class User
{
    /**************************************************************************************
                                        Private properties
    ***************************************************************************************/

    /**
     * @var string $db    The database in which the content is stored.
     */
    private $db = null;

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
     * Verify that a user password is correct.
     * @param string $name The name of the user.
     * @return string $password The password of the user.
     */
    public function passwordIsCorrect($name, $password)
    {
        $sql = "SELECT * FROM user WHERE name = ?";

        $user = $this->db->executeFetch($sql, [$name]);

        if ($user && $user->password === sha1($password)) {
            return true;
        } else {
            return false;
        }
    }


    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/
}
