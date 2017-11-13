<?php

namespace AppBundle\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Doctrine\Common\Cache\Cache;

class MarkdownTransformer
{
    private $markDownParser;

    private $cache;

    public function __construct(MarkdownParserInterface $markDownParser, Cache $cacheDriver)
    {
        $this->markDownParser = $markDownParser;

        $this->cache = $cacheDriver;
    }

    public function parse($str)
    {

        $cache = $this->cache;
        $key = md5($str);

        if ($cache->contains($key)) {
            return $cache->fetch($key);
        }

        sleep(1);
        $str = $this->markDownParser->transformMarkdown($str);
        $cache->save($key, $str);

       return $str;
    }

}