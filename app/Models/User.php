<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));

        $this->notify(new class($url) extends ResetPassword {
            protected string $customUrl;

            public function __construct(string $customUrl)
            {
                $this->customUrl = $customUrl;
            }

            public function toMail($notifiable): MailMessage
            {
                return (new MailMessage)
                    ->subject('Redefinição de senha - Copa Bacabal de Karatê-Dô Tradicional')
                    ->greeting('Olá!')
                    ->line('Recebemos uma solicitação para redefinir a senha de acesso ao sistema da Copa Bacabal de Karatê-Dô Tradicional.')
                    ->line('Clique no botão abaixo para criar uma nova senha.')
                    ->action('Redefinir senha', $this->customUrl)
                    ->line('Se você não solicitou a redefinição de senha, nenhuma ação adicional é necessária.')
                    ->salutation('Atenciosamente, Organização da Copa Bacabal de Karatê-Dô Tradicional');
            }
        });
    }
}
