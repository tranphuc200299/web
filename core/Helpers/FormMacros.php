<?php

namespace Core\Helpers;

use Collective\Html\FormBuilder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class FormMacros extends FormBuilder
{
    public function requestMessage()
    {
        $result = '';
        $errors = Session::get('errors', new MessageBag);

        if ($errors->has('message') || $errors->count() > 0) {
            $result .= '<div class="alert alert-danger time-out-message"><span>';
            if ($errors->has('message')) {
                $result .= $errors->first('message');
            } else {
                if ($errors->has('error') && !$errors->first('error') === false) {
                    $result .= 'Something wrong, please try again.';
                } else {
                    $result .= $errors->first();
                }
            }
            $result .= '</span></div>';
        }

        if (session()->has('message')) {
            $result .= '<div class="alert alert-danger time-out-message">';
            $result .= '<span>'.session()->get('message').'</span>';
            $result .= '</div>';
        }

        if (session()->has('alert') || session()->has('success')) {
            $result .= '<div class="alert alert-success time-out-message">';
            $result .= '<strong>'.session()->get('alert', session()->get('success')).'</strong>';
            $result .= '</div>';
        }

        if (session()->has('status')) {
            $result .= '<div class="alert alert-success time-out-message">';
            $result .= '<strong>'.session()->get('status').'</strong>';
            $result .= '</div>';
        }

        return $this->toHtmlString($result);
    }
}
