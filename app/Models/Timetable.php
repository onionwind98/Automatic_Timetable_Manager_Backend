<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $table = 'timetable';
    public $timestamps = false;
    protected $fillable = [
        'timeslotID',
        'userID',
        'date',
        'taskID'
    ];

}
