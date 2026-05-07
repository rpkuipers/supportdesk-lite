<?php

namespace App\Exceptions;

use RuntimeException;

class TicketAlreadyResolvedException extends RuntimeException
{
    public static function forTicket(string $reference): self
    {
        return new self("Ticket {$reference} is al opgelost.");
    }
}
