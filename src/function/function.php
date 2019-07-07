<?php
/**
 * This file contains general purpose functions which may be used by more than one class and/or file.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */



/**
 * Get value from GET variable or return default value.
 *
 * @param string $key     to look for
 * @param mixed  $default value to set if key does not exists
 *
 * @return mixed value from GET or the default value
 */
function getGet($key, $default = null)
{
    return isset($_GET[$key])
        ? $_GET[$key]
        : $default;
}



/**
 * Get value from POST variable or return default value.
 *
 * @param mixed $key     to look for, or value array
 * @param mixed $default value to set if key does not exists
 *
 * @return mixed value from POST or the default value
 */
function getPostValues($key, $default = null)
{
    if (is_array($key)) {
        $key = array_flip($key);

        $key = array_replace($key, array_intersect_key($_POST, $key));

        $key = array_map(function ($value) {
                return trim($value) === "" ? null : $value;
        }, $key);

        return $key;
    }

    return isset($_POST[$key])
        ? $_POST[$key]
        : $default;
}



/**
 * Create a slug of a string, to be used as url.
 *
 * @param string $str the string to format as slug.
 *
 * @return str the formatted slug.
 */
function slugify($str)
{
    $str = mb_strtolower(trim($str));
    $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = trim(preg_replace('/-+/', '-', $str), '-');
    return $str;
}



/**
 * Sanitize value for output in view.
 *
 * @param string $value to sanitize
 *
 * @return string beeing sanitized
 */
function esc($value)
{
    return htmlentities($value);
}



/**
 * Function to create links for sorting.
 *
 * @param string $column the name of the database column to sort by
 * @param string $route  prepend this to the anchor href
 *
 * @return string with links to order by column.
 */
function orderby($column, $route)
{
    return <<<EOD
<div class="orderby">
<a class="darr" href="{$route}?orderby={$column}&order=asc" title='ascending'>&uarr;</a>
<a class="uarr" href="{$route}?orderby={$column}&order=desc" title='descending'>&darr;</a>
</div>
EOD;
}



/**
 * Function to create links for sorting and keeping the original querystring.
 *
 * @param string $column the name of the database column to sort by
 * @param string $route  prepend this to the anchor href
 *
 * @return string with links to order by column.
 */
function orderby2($column, $route)
{
    $asc = mergeQueryString(["orderby" => $column, "order" => "asc"], $route);
    $desc = mergeQueryString(["orderby" => $column, "order" => "desc"], $route);

    return <<<EOD
<span class="orderby">
<a href="$asc">&darr;</a>
<a href="$desc">&uarr;</a>
</span>
EOD;
}



/**
 * Function to create links for paginating database results.
 *
 * @param string $route The route to which the request is directed.
 * @param string $hits Number of hits/items per page.
  * @param string $currentHits Currently selected hits per page, if any.
 *
 * @return string with a link to paginate results.
 */
function paginate($route, $hits, $currentHits = null)
{
    if ($hits === intval($currentHits)) {
        return "<u><a class='cms-link' href='{$route}?hits={$hits}'>{$hits}</a></u>";
    }

    return "<a class='cms-link' href='{$route}?hits={$hits}'>{$hits}</a>";
}



/**
 * Function to return a link to specific page, with a certain number of hits per page.
 *
 * @param string $route The route to which the request is directed.
 * @param string $hits Currently selected number of hits/items per page.
 * @param string $page The target page number.
 * @param string $currentPage The currently selected page number, if any.
 *
 * @return string with a link to a specific page.
 */
function page($route, $hits, $page, $currentPage = null)
{
    if ($page === intval($currentPage)) {
        return "<u><a class='cms-link' href='{$route}?hits={$hits}&page={$page}'>{$page}</a></u>";
    }
    return "<a class='cms-link' href='{$route}?hits={$hits}&page={$page}'>{$page}</a>";
}



/**
 * Use current querystring as base, extract it to an array, merge it
 * with incoming $options and recreate the querystring using the
 * resulting array.
 *
 * @param array  $options to merge into exitins querystring
 * @param string $prepend to the resulting query string
 *
 * @return string as an url with the updated query string.
 */
function mergeQueryString($options, $prepend = "?")
{
    // Parse querystring into array
    $query = [];
    parse_str($_SERVER["QUERY_STRING"], $query);

    // Merge query string with new options
    $query = array_merge($query, $options);

    // Build and return the modified querystring as url
    return $prepend . http_build_query($query);
}



/**
 * Format a text using the MyTextFilter class.
 *
 * @param mixed $text The text to format
 *
 * @return mixed The formatted text.
 */
function formatText($text)
{
    $textfilter = new \Anri16\MyTextFilter\MyTextFilter();

    if (is_array($text)) {
        foreach ($text as $row) {
            // if (strpos($row->filter, 'markdown') !== false) {
            //     $row->data = nl2br($row->data);
            // }
            $row->data = $textfilter->parse($row->data, $row->filter);
        }
    } else {
        // if (strpos($text->filter, 'markdown') !== false) {
        //     $text->data = nl2br($text->data);
        // }
        $text->data = $textfilter->parse($text->data, $text->filter);
    }

    return $text;
}



/**
 * Verify that a given input is numeric,
 * throw an exception if it isn't.
 *
 * @param mixed $input The input to verify.
 * @throws Exception if the input is not numeric.
 *
 */
function verifyIsNumeric($input)
{
    if (!is_numeric($input)) {
        $input = esc($input);
        $message = "Error: '$input' is not a valid argument.";
        throw new \Anax\Database\Exception\Exception($message);
    }
}

/**
 * Check that the arguments used to sort data are valid.
 *
 * @param string $orderby The column by which data should be sorted
 * @param string $order The sorting order (ascending or descending)
 *
 */
function validateSort($orderby, $order)
{
    // Only these values are valid
    $columns = ["id", "title", "type"];
    $orders = ["asc", "desc"];

    // Incoming matches valid value sets
    if (!(in_array($orderby, $columns) && in_array($order, $orders))) {
        $orderby = esc($orderby);
        $order = esc($order);
        $message = "Error: '$orderby' and/or '$order' are not valid sorting arguments.";
        throw new \Anax\Database\Exception\Exception($message);
    }
}




/**
 * Check that a given $hits number is within range, else throw an exeception.
 *
 * @param integer $hits The number to validate.
 * @throws Exception if the number is out of range.
 *
 */
function validateHitsRange($hits)
{
    if (!($hits > 0 && $hits <= 8)) {
        $hits = esc($hits);
        $message = "Error: '$hits' is not a valid hits argument.";
        throw new \Anax\Database\Exception\Exception($message);
    }
}



/**
 * Check that a given $page number is within range, else throw an exeception.
 *
 * @param integer $page The number to validate.
 * @param integer $max The max/highest value that $number can have.
 * @throws Exception if the number is out of range.
 *
 */
function validatePageRange($page, $max)
{
    if (!($page > 0 && $page <= $max)) {
        $page = esc($page);
        $message = "Error: '$page' is not a valid page argument.";
        throw new \Anax\Database\Exception\Exception($message);
    }
}



/**
 * Get a substring located between two characters/sets of characters in a string.
 *
 * @param string $str The string from which the substring will be extracted.
 * @param string $from Start position - the character/set of characters after which the desired substring starts.
 * @param string $toHere End position - the character/set of characters before which the desired substring ends.
 * @return string The extracted substring.
 *
 */
function getStringBetween($str, $from, $toHere)
{
    $sub = substr($str, strpos($str, $from) + strlen($from), strlen($str));
    return substr($sub, 0, strpos($sub, $toHere));
}
