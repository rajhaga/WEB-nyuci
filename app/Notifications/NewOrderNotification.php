<?php
namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    // Remove 'database' channel if you don't want to store in DB
    public function via($notifiable)
    {
        return ['mail']; // Use only mail for now
    }

    // Mail notification
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Pesanan ' . $this->pesanan->kode_referral . ' telah diperbarui statusnya.')
                    ->action('Lihat Pesanan', url('/pesanan/'.$this->pesanan->id))
                    ->line('Terima kasih telah menggunakan layanan kami.');
    }
}
