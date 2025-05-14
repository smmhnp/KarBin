<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';  

    protected $fillable = [
        'user_id', 'title', 'project_name', 'content',
        'undertaking', 'preference', 'deadline', 'status',
        'attachment_path'
    ];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'title'         => 'encrypted',
            'project_name'  => 'encrypted',
            'content'       => 'encrypted',
            'undertaking'   => 'encrypted',
            'preference'    => 'encrypted',

            'deadline'      => 'datetime',
        ];
    }
}
