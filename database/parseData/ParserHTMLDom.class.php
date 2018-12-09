<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 02.12.2018
 * Time: 15:59
 */

namespace Acme\database\parseData;
use Acme\core\Parser;
use Sunra\PhpSimple\HtmlDomParser;

class ParserHTMLDom extends Parser
{
    function run()
    {
        $dom = new \DOMDocument();
        $dom->load($this->resource);
        //$products = $dom->getElementsByClassName
    }

}