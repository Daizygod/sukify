<?php

namespace App\Console\Commands;

use App\Helper\RS;
use App\Helper\Session;
use App\Helper\TimeZoneConverter;
use App\Models\TimePackage;
use App\Models\TimePackageSellPeriod;
use App\Models\TimePackageUsePeriod;
use App\Models\TimePackageZone;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;


class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test test ..... ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        return 1;
    }
}
