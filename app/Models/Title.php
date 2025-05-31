<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $table = 'titles';  
    
    protected $fillable = [
        'title',
        'user_id',
        'deadline'
    ];
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $guarded = ['id'];

    protected $casts = [
        'deadline' => 'date',
    ];
}
