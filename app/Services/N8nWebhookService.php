<?php

namespace App\Services;

use App\Models\Inscricao;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nWebhookService
{
    public function enviarInscricaoRealizada(Inscricao $inscricao): void
    {
        $url = config('services.n8n.webhook_inscricao');

        if (!$url) {
            return;
        }

        try {
            Http::timeout(15)->post($url, [
                'inscricao_id' => $inscricao->id,
                'dojo_nome' => $inscricao->dojo_nome,
                'sensei_nome' => $inscricao->sensei_nome,
                'telefone' => $inscricao->telefone,
                'email' => $inscricao->email,
                'total_atletas' => $inscricao->total_atletas,
                'status' => $inscricao->status,
                'link_edicao' => route('inscricao.edit.token', [
                    'id' => $inscricao->id,
                    'token' => $inscricao->token_edicao,
                ]),
                'edicao_ate' => optional($inscricao->edicao_ate)->toDateTimeString(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao enviar webhook n8n da inscrição', [
                'inscricao_id' => $inscricao->id,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
