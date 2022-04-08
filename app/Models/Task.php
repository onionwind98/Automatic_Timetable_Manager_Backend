<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';
    public $timestamps = false;
    protected $fillable = [
        'userID',
        'timetableID',
        'title',
        'priorityLevel',
        'description',
        'status',
        'preferredTime',
        'repeatOn'
    ];
}
