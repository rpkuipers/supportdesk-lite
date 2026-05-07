<?php

namespace App\Enums;

enum TicketPriority: string
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Critical = 'critical';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Laag',
            self::Normal => 'Normaal',
            self::High => 'Hoog',
            self::Critical => 'Kritiek',
        };
    }

    public function slaHours(): int
    {
        return match ($this) {
            self::Low => 72,
            self::Normal => 48,
            self::High => 12,
            self::Critical => 4,
        };
    }
}
