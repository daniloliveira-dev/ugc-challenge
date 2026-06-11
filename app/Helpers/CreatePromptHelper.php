<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class CreatePromptHelper
{

    public static function generateMarketingPlanCustomPrompt(Request $request): string
    {
        $prompt = "
        Você é um especialista em crescimento empresarial e marketing digital.

Analise os dados do cliente e gere um plano de ação curto, direto e personalizado.

REGRAS IMPORTANTES:

* Seja extremamente objetivo.
* Limite a resposta a no máximo 300 palavras.
* Utilize frases curtas.
* Evite textos longos e explicações extensas.
* Evite excesso de Markdown.
* Não utilize títulos grandes.
* Não utilize linhas separadoras.
* Não utilize introduções ou conclusões genéricas.
* Não invente informações.
* Baseie todas as recomendações nos dados informados.
* Destaque apenas as ações com maior impacto.

DADOS DO CLIENTE

Tamanho da Empresa: {$request->tamanhoEmpresa}
Investimento em Marketing: {$request->investimento}
Objetivo Principal: {$request->objetivo}
Segmento: {$request->segmento}
Maior Desafio: {$request->problemaAtual}

RETORNE EXATAMENTE NESTE FORMATO:

Diagnóstico:
Texto com no máximo 2 frases.

Prioridades:

* item 1
* item 2
* item 3

Próximos 30 dias:

* ação 1
* ação 2
* ação 3

Próximos 90 dias:

* ação 1
* ação 2
* ação 3

KPIs:

* indicador 1
* indicador 2
* indicador 3

Como a Creahub pode ajudar:
Texto com no máximo 3 frases mostrando como a plataforma pode acelerar os resultados.
e ao final exibir o link https://www.crehub.app";

        return $prompt;
    }
}
