<?php

namespace Cwp\Address\Commands;

use Cwp\Address\Models\JapaneseAddress;
use Illuminate\Console\Command;
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
    protected $signature = 'cwp:address_install';

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

        $table_name = 'cwp_japanese_addresses';
        if(Schema::hasTable($table_name))
        {
            Schema::drop($table_name);
        }

        //Create Tables with data
        $filePath = __DIR__ . '/../database/japanese/table.sql';
        DB::unprepared(file_get_contents($filePath));

        $filePath = __DIR__ . '/../database/japanese/data.sql';
        if (File::exists($filePath)) {
            $file_contents = file_get_contents($filePath);
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
