<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'branch_id', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isBranchAdmin(): bool
    {
        return $this->role === 'branch_admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'branch_admin' => 'Branch Admin',
            'editor' => 'Editor',
            default => 'Unknown',
        };
    }

    /**
     * এই admin কি delete/destructive action করতে পারবে?
     */
    public function canDelete(): bool
    {
        return in_array($this->role, ['super_admin', 'branch_admin']);
    }

    /**
     * এই admin কি Settings/Backups/User Management access করতে পারবে?
     */
    public function canManageSystem(): bool
    {
        return $this->role === 'super_admin';
    }
}
