<?php
/**
 * This file contains code to implement the class MyTextFilter.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */
 namespace Anri16\MyTextFilter;

 use \Michelf\Markdown;

/**
 * A class with various methods to format text.
 *
 * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class MyTextFilter
{
    /**************************************************************************************
                                        Private variables
    ***************************************************************************************/

    /**
     * @var Array $methods    List of available filter methods, with the method names of their respective handlers.
     */
    private $methods = null;

    /**
     * @var Array $exampleText    An example text to use when testing the various methods.
     */
    private $exampleText = null;

    /**************************************************************************************
                                        Public methods
    ***************************************************************************************/


    /**
     * Constructor to initiate a Textfilter object.
     */
    public function __construct()
    {
        $this->methods = [
            "bbcode" => "bbcode2html",
            "link" => "makeClickable",
            "markdown" => "markdown",
            "nl2br" => "nl2br",
            "strip" => "strip",
            "esc" => "esc"
        ];

        $this->exampleText = "Detta är en exempeltext som kan användas för att utforska filtren i klassen MyTextFilter. Texten kan hämtas via klassens metod 'exampleText'.";
        $this->exampleText .= "\n\nDen här meningen innehåller &quot;specialtecken&quot; som görs om till HTML entities när filtret <a href='https://www.php.net/manual/en/function.htmlentities.php'>esc</a> används.";
        $this->exampleText .= "\n\nOm man använder filtret <a href='https://www.php.net/manual/en/function.strip-tags.php'>strip</a> så försvinner alla HTML-taggar, inkl. &lt;a&gt;-taggar, från texten.";
        $this->exampleText .= "\n\nHär kommer lite bbcode med [b]bold[/b] och [i]italic[/i] samt en [url=https://dbwebb.se] länk till dbwebb[/url].";
        $this->exampleText .= "\n\nSen testar vi en länk till https://dbwebb.se som skall bli klickbar.";
        $this->exampleText .= "\n\nDärefter blir det en [länk skriven i markdown](https://dbwebb.se) och länken leder till dbwebb.";
        $this->exampleText .= "\n\n> Sedan infogar vi ett trevligt citat som görs om till en *blockquote* i markdown.";
        $this->exampleText .= "\n\nVi avslutar med en lista som formatteras till ul/li med markdown:";
        $this->exampleText .= "\n\n* Item 1";
        $this->exampleText .= "\n\n* Item 2";
    }

    /**
     * Format a $text based on the supplied $filters.
     * @param String $text The text to be formatted.
     * @param String $filter Comma-separated list of names of the filters to be used in formatting the text.
     * @return String The formatted text.
     */
    public function parse($text, $filter = "")
    {
        //$text = strip_tags($text);
        $filter = explode(",", $filter);
        foreach ($filter as $name) {
            if (array_key_exists($name, $this->methods)) {
                $handler = $this->methods[$name];
                $text = $this->$handler($text);
            }
        }
        return $text;
    }

    /**
     * Get an example/sample text to use when trying out the various filter methods.
     * @return String The example text.
     */
    public function exampleText()
    {
        return $this->exampleText;
    }


    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/

    /**
     * Convert BBCode-formatted text to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return String the formatted text.
     */
    private function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }

    /**
     * Make clickable links from URLs in a text.
     *
     * @param String $text the text that should be formatted.
     *
     * @return String the formatted text.
     */
    private function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\"{$matches[0]}\">{$matches[0]}</a>";
            },
            $text
        );
    }

    /**
     * Convert Markdown-formatted text to HTML.
     *
     * @param String $text The text to be converted.
     *
     * @return String The formatted text.
     */
    private function markdown($text)
    {
        $html = Markdown::defaultTransform($text);
        return $html;
    }

    /**
     * Replace newlines (\n, \r\n) with HTML linebreak (<br>) elements.
     *
     * @param String $text The text that should be formatted.
     *
     * @return String The formatted text.
     */
    private function nl2br($text)
    {
        return nl2br($text);
    }

    /**
     * Remove all HTML, XML and PHP tags from a text.
     *
     * @param String $text The text that should be formatted.
     *
     * @return String The formatted text.
     */
    private function strip($text)
    {
        return strip_tags($text);
    }

    /**
     * Convert all applicable characters to HTML entities.
     *
     * @param String $text The text that should be formatted.
     *
     * @return String The formatted text.
     */
    private function esc($text)
    {
        return htmlentities($text);
    }
}
