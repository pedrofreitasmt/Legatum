<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = "active";
    case SENT = "sent";

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Ativo',
            self::SENT => 'Enviado',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'name' => $case->name,
            'value' => $case->value,
            'label' => $case->getLabel(),
        ], self::cases());
    }
}
