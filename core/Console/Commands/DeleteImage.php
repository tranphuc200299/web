<?php

namespace Core\Console\Commands;

use Core\Entities\Mails\Test;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Log\Services\LogService;

class DeleteImage extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Folder With Storage or File Class';

    public $logService;

    public function __construct(LogService $logService)
    {
        parent::__construct();
        $this->logService = $logService;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->logService->deleteImages();
    }
}
