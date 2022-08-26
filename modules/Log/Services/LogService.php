<?php

namespace Modules\Log\Services;

use Carbon\Carbon;
use Core\Services\BaseService;
use League\Csv\Writer;
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

        $this->builder
            ->when($this->filter->has('start_date'), function ($query) {
                $query->whereDate('created_at', '>=', $this->filter->get('start_date'));
            })->when($this->filter->has('end_date'), function ($query) {
                $query->whereDate('created_at', '<=' , $this->filter->get('end_date'));
            })->when($this->filter->has('start_time'), function ($query) {
                $query->whereTime('created_at', '>=' , $this->filter->get('start_time'));
            })->when($this->filter->has('end_time'), function ($query) {
                $query->whereTime('created_at', '<=', $this->filter->get('end_time'));
            })->whereHas('customer', function ($query) {
                $query->when($this->filter->has('age_start'), function ($q) {
                    $q->where('age', '>=', $this->filter->get('age_start'));
                })->when($this->filter->has('age_end'), function ($q) {
                    $q->where('age', '<=', $this->filter->get('age_end'));
                })->when($this->filter->has('gender'), function ($q) {
                    $q->where('gender', $this->filter->get('gender'));
                })->when($this->filter->has('id'), function ($q) {
                    $q->where('id', $this->filter->get('id'));
                });
            });

        $this->cleanFilterBuilder(['id', 'age_start', 'age_end', 'gender']);

        return $this->endFilter();
    }

    public function deleteMultiRecord($listId)
    {
        return $this->mainRepository->deleteMultiRecord($listId);
    }

    public function export()
    {
        $logs = $this->getAll(['with_load' => 'customer'], false);

        $csv = Writer::createFromFileObject(new \SplTempFileObject);

        $csv->insertOne([
            'STT',
            'ID',
            'Image',
            'Gender',
            'Age',
            'Check In Date',
            'Check In Time'
        ]);

        foreach ($logs as $k => $log) {
            $csv->insertOne([
                $k,
                $log->customer->id,
                $log->face_image_url,
                $log->customer->gender,
                $log->customer->age,
                Carbon::parse($log->created_at)->format('Y-m-d'),
                Carbon::parse($log->created_at)->format('H:i:s')
            ]);
        }

        $fileName = Carbon::now()->timestamp . '_logs.csv';

        $csv->output($fileName);
    }

}
