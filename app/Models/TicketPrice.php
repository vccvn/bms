<?php

namespace App\Models;

class TicketPrice extends Model
{
    protected $table = 'ticket_prices';

    public $fillable = ["route_id","company_id","price"];

    public $_route = 'ticket.price';

    
    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }

}
