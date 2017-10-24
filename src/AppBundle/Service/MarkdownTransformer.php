<?php

namespace AppBundle\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownTransformer
{
    private $markDownParser;

    public function __construct(MarkdownParserInterface $markDownParser)
    {
        $this->markDownParser = $markDownParser;
    }

    public function parse($str)
    {
       return $this->markDownParser->transformMarkdown($str);
    }

}