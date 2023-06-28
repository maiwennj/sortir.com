<?php

namespace App\Model;

use App\Entity\Site;

class Filter
{
    /**
     * @var string
     */
    private $keyWord;

    /**
     * @var Site
     */
    private $site;

    /**
     * @return mixed
     */
    public function getKeyWord(): ?String
    {
        return $this->keyWord;
    }

    /**
     * @param mixed $keyWord
     */
    public function setKeyWord($keyWord):void
    {
        $this->keyWord = $keyWord;
    }

    /**
     * @return mixed
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite(Site $site): void
    {
        $this->site = $site;
    }



}