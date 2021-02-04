<?php

namespace App\Notifications;

use App\Prediction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PointsAwarded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param  Prediction  $prediction
     * @param  int     $pointsAwarded
     * @return void
     */
    public function __construct(Prediction $prediction, $pointsAwarded)
    {
        $this->prediction = $prediction;
        $this->result = $prediction->result;
        $this->pointsAwarded = $pointsAwarded;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'prediction_id' => $this->prediction->id,
            'result_id' => $this->result->id,
            'points_awarded' => $this->pointsAwarded,
        ];
    }
}
