<?php

namespace Streamcms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tips extends Model
{
    use SoftDeletes;

    protected $guarded	= ['id'];
	
	protected $table = 'tips';

	protected $fillable = ['nama', 'description'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $keyType = 'int';
}
