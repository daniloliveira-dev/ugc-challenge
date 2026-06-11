<?php

namespace App\DTO;

class GenerateMessageDTO
{
    public function __construct(
        public string $prompt,
        public string $tamanhoEmpresa,
        public string $investimento,
        public string $objetivo,
        public string $segmento,
        public string $problemaAtual,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            prompt: '',
            tamanhoEmpresa: $data['tamanhoEmpresa'] ?? '',
            investimento: $data['investimento'] ?? '',
            objetivo: $data['objetivo'] ?? '',
            segmento: $data['segmento'] ?? '',
            problemaAtual: $data['problemaAtual'] ?? ''
        );
    }
}
