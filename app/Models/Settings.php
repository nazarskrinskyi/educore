<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['site_name', 'site_description', 'maintenance_mode', 'certificate_enabled', 'certificate_issuer_name', 'certificate_template', 'telegram_bot_token', 'telegram_reminder_enabled'];
}
