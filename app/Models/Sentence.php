<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'row',
        'column',
    ];

    /**
     * Get the user that owns the sentence.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
