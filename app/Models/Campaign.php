<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $table ='campaign';
    protected $fillable =[
        'name',
        'start_campaign',
        'end_campaign',
        'link'
    ];
}
