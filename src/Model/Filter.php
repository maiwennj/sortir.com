<?php

namespace App\Model;

use App\Entity\Site;
use phpDocumentor\Reflection\Types\Boolean;

class Filter
{

    private $keyWord;


    private $site;

    private $startDate;

    private $endDate;

    private $isTheOrganiser;

    private $isRegistered;

    private $isNotRegistered;

    private $isFinished;

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getIsTheOrganiser()
    {
        return $this->isTheOrganiser;
    }

    /**
     * @param mixed $isTheOrganiser
     */
    public function setIsTheOrganiser($isTheOrganiser): void
    {
        $this->isTheOrganiser = $isTheOrganiser;
    }

    /**
     * @return mixed
     */
    public function getIsRegistered()
    {
        return $this->isRegistered;
    }

    /**
     * @param mixed $isRegistered
     */
    public function setIsRegistered($isRegistered): void
    {
        $this->isRegistered = $isRegistered;
    }

    /**
     * @return mixed
     */
    public function getIsNotRegistered()
    {
        return $this->isNotRegistered;
    }

    /**
     * @param mixed $isNotRegistered
     */
    public function setIsNotRegistered($isNotRegistered): void
    {
        $this->isNotRegistered = $isNotRegistered;
    }

    /**
     * @return mixed
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * @param mixed $isFinished
     */
    public function setIsFinished($isFinished): void
    {
        $this->isFinished = $isFinished;
    }



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