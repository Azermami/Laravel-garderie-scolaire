<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParentVerification extends Notification
{
    use Queueable;

    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Un nouveau parent a été inscrit.')
                    ->action('Valider le parent', url('/admin/validate-parent/' . $this->parent->id))
                    ->line('Merci d\'utiliser notre application !');
    }
}
