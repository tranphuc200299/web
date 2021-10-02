<?php

namespace Core\Helpers;

use Collective\Html\HtmlBuilder;

class HtmlMacros extends HtmlBuilder
{
    /**
     * @param $columns
     * @param $curSort
     * @param  bool  $url
     * @param  bool  $checkAll
     * @param  bool  $requestField
     *
     * @return string
     */
    public function renderHeader($columns, $curSort, $url = false, $checkAll = true, $requestField = false)
    {
        $result = '';
        if ($checkAll == true) {
            $result .= '<th style="width: 20px;"><label class="m-checkbox m-checkbox--solid m-checkbox--brand align-top">
                <input type="checkbox" class="chk-all"><span></span></label></th>';
        }

        $url = (!$url) ? url()->current() : $url;
        $current_request = request()->query();

        if ($requestField !== false) {
            $current_request = request()->only($requestField);
        }

        $current_sort = $this->parseSorting(request('sort', $curSort));

        $this->renderTr($result, $columns, $url, $current_request, $current_sort);

        return $result;
    }

    public function parseSorting($string)
    {
        $result = [];

        if ($string == '-intended_date') {
            $result['date_ok'] = 'DESC';
            $result['time_ok'] = 'DESC';
        }
        if ($string == 'intended_date') {
            $result['date_ok'] = 'ASC';
            $result['time_ok'] = 'ASC';
        }

        $sort = explode(',', $string);
        $sort = array_map(function ($s) {
            $s = filter_var($s, FILTER_SANITIZE_STRING);
            return trim($s);
        }, $sort);
        foreach ($sort as $expr) {
            if (empty($expr)) {
                continue;
            }
            if ('-' == substr($expr, 0, 1)) {
                $result[substr($expr, 1)] = 'DESC';
            } else {
                $result[$expr] = 'ASC';
            }
        }
        return $result;
    }


    public function renderTr(&$result, $columns, $url, $current_request, $current_sort)
    {
        foreach ($columns as $k => $v) {
            if(!empty($v['hidden'])) {
                continue;
            }
            $gen_url = ['sort' => $k];
            if (isset($current_sort[$k])) {
                if ($current_sort[$k] == 'ASC') {
                    $gen_url['sort'] = '-'.$k;
                }
            }
            $sortUrl = $url.'?'.http_build_query(array_merge($current_request, $gen_url));

            $column_style = '';
            $column_name = $v;
            if (is_array($v)) {
                $column_name = isset($v['name']) ? $v['name'] : '';
                $column_style .= (isset($v['style'])) ? ' style="'.$v['style'].'" ' : '';
            }

            $iconSort = '';
            $sortable = !empty($v['sortable']);

            if (!empty($sortUrl) && $sortable) {
                $col_class = 'class="sorting"';
                if (isset($current_sort[$k])) {
                    $col_class = 'class="sorting desc"';
                    if ($current_sort[$k] == 'ASC') {
                        $col_class = 'class="sorting asc"';
                    }
                }
                $column_style .= $col_class;

                $result .= '<th '.$column_style.'><a href="'.$sortUrl.'">'.$column_name.'</a></th>';
            } else {
                $result .= '<th '.$column_style.'>'.$column_name.$iconSort.'</th>';
            }

        }
    }
}
