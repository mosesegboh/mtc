<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiConnector;
use Carbon\Carbon;

class GetData extends Command
{
    private $mtcApiUrl;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connects to mtc Api and saves data to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->mtcApiUrl = env('API_URL');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', 600); // 600 = 10 minutes

        $properties = ApiConnector::instance()->getData($this->mtcApiUrl);//instance of custom helper class - see namespace

        ApiConnector::instance()->insertData($this->mtcApiUrl);
    }
}
