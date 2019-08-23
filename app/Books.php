<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'release_date',
        'author_id',
    ];

    public function author() {
        return $this->belongsTo(Author::class);
    }
}
