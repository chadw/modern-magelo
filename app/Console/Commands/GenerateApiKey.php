<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateApiKey extends Command
{
    protected $signature = 'api:generate-key {name : Human-friendly name for the API key}';
    protected $description = 'Generate a new API key and store it in the api_keys table';

    public function handle()
    {
        $name = $this->argument('name');

        do {
            $plain = bin2hex(random_bytes(20));
            $exists = DB::table('api_keys')->where('key', $plain)->exists();
        } while ($exists);

        $now = now();
        DB::table('api_keys')->insert([
            'key' => $plain,
            'name' => $name,
            'requests' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->info('API key created:');
        $this->line($plain);
        $this->info('Store this value securely; it will not be shown again.');

        return 0;
    }
}
