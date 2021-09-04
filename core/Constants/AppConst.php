<?php

namespace Core\Constants;

class AppConst
{
    const DATETIME_FORMAT = 'Y-m-d H:i:s';
    const DATE_FORMAT = 'Y-m-d';
    const TIME_FORMAT = 'H:i:s';

    const COPY_RIGHT = 'Copyright © 2021';
    const LIMIT_PER_PAGE = 10;
    const PAGE_LIMIT_DEFAULT = 20;

    const QUEUE_LEVEL_IMMEDIATE = 'immediate';
    const QUEUE_LEVEL_HIGH = 'high';
    const QUEUE_LEVEL_MEDIUM = 'medium';
    const QUEUE_LEVEL_LOW = 'low';

    const QUEUE_LEVEL_MAIL = 'mail';
    const QUEUE_LEVEL_LOG = 'log';

    const QUEUE_LEVEL_REMIND = 'remind';
    const QUEUE_LEVEL_IMPORT = 'import';
}
