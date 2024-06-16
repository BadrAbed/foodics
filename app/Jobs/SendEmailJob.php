<?php

namespace App\Jobs;

use App\Mail\LowIngredientStock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $email;
    private $ingredient;

    /**
     * Create a new job instance.
     * @param $ingredient
     */
    public function __construct($ingredient)
    {
       $this->email=$ingredient->merchant->email;
       $this->ingredient=$ingredient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new LowIngredientStock($this->ingredient));

        $this->ingredient->updateQuietly(['is_merchant_notified' => true]);
    }
}
