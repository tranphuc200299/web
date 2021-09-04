<?php

namespace Core\Entities\Mails;

class Test extends Mailable
{
    protected $email;

    /**
     * Test constructor.
     *
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this
            ->to($this->email)
//            ->markdown('core::_email.html.test')//html
            ->text('core::_email.text.test')//text
            ->subject('Test mail');
    }
}
