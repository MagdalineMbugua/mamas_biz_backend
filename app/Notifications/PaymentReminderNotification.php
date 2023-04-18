<?php

namespace App\Notifications;

use App\Models\Sales;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\WebpushConfig;
use NotificationChannels\Fcm\Resources\WebpushFcmOptions;

class PaymentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Sales $sales)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [FcmChannel::class, 'mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Today potential payments')
            ->line($this->getMessage($notifiable))
            ->line('Thank you for using our application!');
    }


    private function getMessage($notifiable): string
    {
        return Lang::get("Hello {$notifiable->name}, {$this->sales->trader_name} next pay for sales {$this->sales->id} is today.
         \n This is the contact {$this->sales->trader_phone_number} to call.");
    }

    public function toFCM($notifiable)
    {
        FcmMessage::create()
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Today potential payments')
                ->setBody($this->getMessage($notifiable)
                ))->setWebpush(WebpushConfig::create()
                ->setFcmOptions(WebpushFcmOptions::create()))
            ->setAndroid(AndroidConfig::create()
                ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                ->setNotification(AndroidNotification::create()->setColor('#0A0A0A')))
            ->setApns(ApnsConfig::create()
                ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Today potential payments',
            'message' => $this->getMessage($notifiable),
            'resource_type' => strtolower(class_basename($this->sales)),
            'resource_id' => $this->sales->id,
        ];
    }
}
