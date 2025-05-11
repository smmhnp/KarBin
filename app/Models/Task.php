<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'title', 'project_name', 'content',
        'undertaking', 'preference', 'deadline', 'status',
        'attachment_path'
    ];

    protected $table = 'tasks';  
    protected $guarded = ['id'];
}
