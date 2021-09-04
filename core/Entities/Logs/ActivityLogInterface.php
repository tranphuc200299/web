<?php

namespace Core\Entities\Logs;

interface ActivityLogInterface
{
    public function setCreateTime();

    public function setCreator();

    public function setRelateId();

    public function setType();

    public function setData();

    public function setIp();

    public function save();
}
