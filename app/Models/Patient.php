<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Specify the table associated with the model (if different from default plural form)
    protected $table = 'patients';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'Codice_Fiscale',
        'name',
        'email',
        'phone',
        'status',
    ];
}
