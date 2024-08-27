<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Contact_me extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
'your_name',
'your_email',
'your_message'];
}
