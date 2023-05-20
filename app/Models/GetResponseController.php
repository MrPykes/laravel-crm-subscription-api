<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetResponseController extends Model
{
    use HasFactory;
    protected $fillable = ['subscriber_list', 'unsubscriber_list', 'aweber_unsubscribe_list', 'getresponse_list'];
}
