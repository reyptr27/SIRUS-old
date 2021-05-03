<?php

namespace App\Jobs\Telegram;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $text;
    protected $nomor;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text,$nomor)
    {
        $this->text = $text;
        $this->nomor = $nomor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        echo "Running Telegram Notification...\n";
        echo "Processing message for ".$this->nomor."\n";

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001235870534'),
            'parse_mode' => 'HTML',
            'text' => $this->text
        ]);
    }
}
