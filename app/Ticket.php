<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    const STATUS_OPENED = 'opened';

    public static function createTicket($data)
    {
        $ticket = new static();

        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->reporter = $data['reporter'];
        $ticket->status = static::STATUS_OPENED;
        $ticket->rating = 0;

        $ticket->save();

        return $ticket;
    }
}
