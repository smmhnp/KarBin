<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';  

    protected $fillable = [
        'user_id', 'title_id', 'project_name', 'content',
        'undertaking', 'preference', 'deadline', 'status',
        'attachment_path'
    ];

    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // public function titles()
    // {
    //     return $this->belongsTo(Title::class);
    // }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    protected $casts = [
        'deadline' => 'date',
    ];  
}
