<?php

namespace Develops\_R\Supports\Generators;

use Develops\_R\Supports\Utils\FileUtil;

class BaseGenerator
{
    public function rollbackFile($path, $fileName)
    {
        if (file_exists($path . $fileName)) {
            return FileUtil::deleteFile($path, $fileName);
        }

        return false;
    }
}
