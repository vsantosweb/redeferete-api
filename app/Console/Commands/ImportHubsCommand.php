<?php

namespace App\Console\Commands;

use App\Imports\HubsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportHubsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-hubs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Excel::import(new HubsImport(), public_path() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'hubs.xlsx');

        return 0;
    }
}
