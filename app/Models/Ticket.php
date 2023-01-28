<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket_no','dev_user_id','qa_user_id','summery','due_date','comment','status','active'];

    /**
     * This function is use to create the new user
     * @param Array
     * @return bool
     */
    public static function saveTicket($dataArr = [])
    {
        if (!Ticket::create($dataArr)) {
           return false;
        }
        return true;
    }
}
