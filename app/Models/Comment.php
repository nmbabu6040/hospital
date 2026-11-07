<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'parent_id',
        'name',
        'email',
        'body',
        'status',
        'ip_address',
        'is_admin_reply',
        'admin_id',
    ];

    protected function casts(): array
    {
        return [
            'is_admin_reply' => 'boolean',
        ];
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('status', 'approved')->oldest();
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
