<?php

namespace App\Traits;

trait HasTicketReference
{
    public static function bootHasTicketReference(): void
    {
        static::creating(function ($model): void {
            if (empty($model->reference)) {
                $model->reference = 'TCK-'.now()->format('Ymd').'-'.strtoupper(str()->random(6));
            }
        });
    }
}
