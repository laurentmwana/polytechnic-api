<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidLaboratory extends Model
{
    protected $fillable = ['is_paid', 'student_id', 'fees_laboratory_id', 'paid_at'];

    public function feesLaboratory()
    {
        return $this->belongsTo(FeesLaboratory::class);
    }
}
