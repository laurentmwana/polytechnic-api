<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidAcademic extends Model
{
    protected $fillable = ['is_paid', 'student_id', 'fees_academic_id', 'paid_at'];
}
