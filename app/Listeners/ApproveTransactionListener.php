<?php

namespace App\Listeners;

use App\Enum\UserType;
use App\Jobs\TriggerPayoutJob;
use App\Jobs\TriggerShipmentJob;
use App\Events\TransactionApproved;
use App\Jobs\TriggerPaymentNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApproveTransactionListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionApproved $event): void
    {
        if($event->payment->order->agent->rank->type == UserType::OFFLINE || $event->payment->order->agent->rank->type == UserType::MISC)
        {
            TriggerPayoutJob::dispatch($event->payment);
        }

        if($event->payment->order->amount_paid >= $event->payment->order->shipping_total_amount
            && $event->payment->order->delivery->shipping_method !== 'pickup')
        {
            TriggerShipmentJob::dispatch($event->payment->order);
        }

        if($event->payment->order->amount_paid >= $event->payment->order->shipping_total_amount)
        {
            TriggerPaymentNotificationJob::dispatch($event->payment);
        }
    }
}
