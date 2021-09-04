<?php

namespace Core\Console\Commands;

use Core\Entities\Mails\Test;
use Illuminate\Console\Command;

class TestMail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail test: php artisan mail:test test@mail.io';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            activity()->send(new Test($email));
            $this->info('Email has been add to queue');
        } else {
            $this->error('Cannot find email');
        }
    }
}
