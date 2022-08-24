<?php

namespace Modules\Log\Services;

use Carbon\Carbon;
use Core\Services\BaseService;
use Modules\Log\Repositories\LogRepository;
use Core\Constants\AppConst;

class LogService extends BaseService
{
    public function __construct(LogRepository $repository)
    {
        $this->mainRepository = $repository;
    }

    public function getAll($options = [], $limit = AppConst::PAGE_LIMIT_DEFAULT)
    {

        $options['limit'] = $limit;
        $this->makeBuilder($options);

        $dateStart = null;
        $dateEnd = null;
        if ($this->filter->get('date_start'))
        {
            $date = explode(" - ", $this->filter->get('date_start'));
            $dateStart = Carbon::parse($date[0])->format('Y-m-d');
            $dateEnd = Carbon::parse($date[1])->format('Y-m-d');
        }

        $this->builder->when($this->filter->has('id'), function ($query) {
            $query->where('id', $this->filter->get('id'));
        })->when($dateStart, function ($query) use ($dateStart) {
            $query->whereDate('created_at', '>=' , $dateStart);
        })->when($dateEnd, function ($query) use ($dateEnd) {
            $query->whereDate('created_at', '<=', $dateEnd);
        })->whereHas('customer' , function ($query) {
            $query->when($this->filter->has('age_start'), function ($q) {
                $q->where('age', '>=',  $this->filter->get('age_start'));
            })->when($this->filter->has('age_end'), function ($q) {
                $q->where('age', '<=',  $this->filter->get('age_end'));
            })->when($this->filter->has('gender'), function ($q) {
                $q->where('gender',  $this->filter->get('gender'));
            });
        });

        $this->cleanFilterBuilder(['id', 'age_start', 'age_end', 'gender']);

        return $this->endFilter();
    }
}
