<?php

namespace Cwp\Address\Commands;

use Cwp\Address\Address;
use Cwp\Address\Models\BdAddress;
use Cwp\Address\Models\JpAddress;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cwp:address_install {--country=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $countries = ['bd', 'jp'];
        $country_option = $this->option('country');
        if($country_option != 'all' && !in_array($country_option, $countries))
        {
            dd('Invalid country option.\n');
        }

        $prefix = Address::PREFIX;

        foreach ($countries as $country)
        {
            $table_name = $prefix . $country ."_addresses";
            if(Schema::hasTable($table_name))
            {
                Schema::drop($table_name);
            }

            if($country == 'jp' && ($country_option == $country || $country_option == 'all'))
            {
                DB::unprepared("CREATE TABLE $table_name (id INTEGER NOT NULL AUTO_INCREMENT, code VARCHAR(7) NOT NULL, pref VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, town VARCHAR(255) NOT NULL, PRIMARY KEY(id));");
                $filePath = __DIR__ . '/../database/jp.sql';
                if (File::exists($filePath)) {
                    $file_contents = file_get_contents($filePath);
                    if($file_contents) {
                        $insert_array = explode('INSERT', $file_contents);
                        foreach ($insert_array as $data) {
                            if (!empty($data)) {
                                $data = "INSERT $data";
                                DB::unprepared($data);
                            }
                        }
                    }
                }
            }
            else if($country == 'bd' && ($country_option == $country || $country_option == 'all'))
            {
                DB::unprepared("CREATE TABLE $table_name (id INTEGER NOT NULL AUTO_INCREMENT, division VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, created_at DATETIME NULL, updated_at DATETIME null, PRIMARY KEY(id));");
                $filePath = __DIR__ . '/../database/bd.sql';
                if (File::exists($filePath)) {
                    DB::unprepared(file_get_contents($filePath));
                }
            }

        }

    }
}
