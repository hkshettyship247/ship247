<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkWithUsForm extends Model
{
    use HasFactory;
	
	public function related_assigned_user()
    {
        return $this->hasOne(User::class, 'id', 'assigned_user')->withTrashed();
    }
	
}
