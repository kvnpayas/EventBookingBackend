<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
  use Queueable;

  protected $booking;
  public function __construct($booking)
  {
    $this->booking = $booking;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('Your Booking is Confirmed')
      ->line('Your booking has been successfully confirmed.')
      ->line('Event: ' . $this->booking->ticket->event->title)
      ->line('Ticket: ' . $this->booking->ticket->type)
      ->line('Quantity: ' . $this->booking->quantity)
      ->line('Amount Paid PHP ' . number_format($this->booking->payment->amount, 2))
      ->line('Thank you for booking with us');
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
