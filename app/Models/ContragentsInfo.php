<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContragentsInfo extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'contragents_info';
    public $casts = [
        'is_disconnected' => 'boolean',
    ];
    public $fillable = [
        'avg_water_usage',
        'date',
        'comment_1',
        'coefficient',
        'gdk_exceeding_letter_date',
        'invoice_issuance_date',
        'invoice_due_date',
        'penalty_amount',
        'penalty_comment',
        'application_increasing_coef_date',
        'applied_coefficient',
        'disconnection_notification_date',
        'disconnection_date',
        'is_disconnected',
        'comment_2',
    ];
}
