<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Push extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushy:push {pageId : The ID of the page, or all.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes notifications to browsers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pageId = $this->argument("pageId");

        $this->info("Sending notification to browsers");
        $this->info("channel: ".env("APP_NAME")."-pushy-".$pageId);

        $client = new \Predis\Client([
            "scheme"    => "tcp",
            "host"      => config("database.redis.default.host"),
            "port"      => config("database.redis.default.port"),
        ]);

        $quotes = "";
        if ($pageId == "all") {
            $quotes = '"';
        }

        $client->publish(
            channel: env("APP_NAME")."-pushy-".$pageId, 
            message:'{"pageId":'.$quotes.$pageId.$quotes.', "type": "general", "message": "Hello there. I am a notification sent at '. Carbon::now().'" }'
        );

        $this->info("Notification sent!");
    }
}
