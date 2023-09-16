<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id', 'fist_name', 'last_name', 'email', 'phone', 'post', 'photo_path'
    ];

    protected $primaryKey = 'employee_id';
    protected $date = ['deleted_at'];
}
