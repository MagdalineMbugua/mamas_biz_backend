<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Sales;
use App\Notifications\PaymentReminderNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class FetchTodayPaymentDay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Sales $sales;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Sales $sales)
    {
        $this->sales = $sales;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Payment::where('sales_id', '=', $this->sales->id)->get()
            ->each(function ($payment) {
                if (Carbon::parse($payment->next_pay_at)->toDate() === Carbon::today()) {
                    $user = $this->sales->created_by;
                    Notification::send($user, new PaymentReminderNotification($this->sales));
                }
            });
    }
}
