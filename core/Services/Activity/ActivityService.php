<?php

namespace Core\Services\Activity;

use Core\Constants\AppConst;
use Core\Entities\Logs\ActivityLogInterface;
use Core\Jobs\ActivityLogJob;
use Core\Jobs\SendMailJob;
use Illuminate\Mail\Mailable;

class ActivityService
{
    /**
     * @param  Mailable  $mail
     *
     * @return $this
     */
    public function send(Mailable $mail)
    {
        SendMailJob::dispatch($mail)->onQueue(AppConst::QUEUE_LEVEL_MAIL);

        return $this;
    }

    /**
     * @param  ActivityLogInterface  $activityLog
     *
     * @return $this
     */
    public function log(ActivityLogInterface $activityLog)
    {
        ActivityLogJob::dispatch($activityLog)->onQueue(AppConst::QUEUE_LEVEL_LOG);

        return $this;
    }
}
