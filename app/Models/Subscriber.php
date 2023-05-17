<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable = ['subscriber_list', 'unsubscriber_list', 'aweber_unsubscribe_list', 'getresponse_list'];
}
