<?php

namespace App\Notifications;

use App\Models\Inscricao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InscricaoRealizadaNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Inscricao $inscricao
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $linkEdicao = route('inscricao.edit.token', [
            'id' => $this->inscricao->id,
            'token' => $this->inscricao->token_edicao,
        ]);

        return (new MailMessage)
            ->subject('Inscrição realizada com sucesso - ' . config('app.name'))
            ->greeting('Olá, ' . $this->inscricao->sensei_nome . '!')
            ->line('A inscrição do dojo foi realizada com sucesso.')
            ->line('Dojo: ' . $this->inscricao->dojo_nome)
            ->line('Total de atletas: ' . $this->inscricao->total_atletas)
            ->line('Você pode usar o link abaixo para gerenciar a inscrição, adicionar atletas, remover atletas e enviar comprovantes complementares.')
            ->action('Gerenciar inscrição', $linkEdicao)
            ->line('Prazo para edição: ' . optional($this->inscricao->edicao_ate)->format('d/m/Y H:i'))
            ->line('Guarde este link com segurança.')
            ->salutation('Atenciosamente, Organização ' . config('app.name'));
    }
}
