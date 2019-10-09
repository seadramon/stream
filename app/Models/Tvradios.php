<?php

namespace Streamcms\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Tvradios extends Model
{
    protected $guarded	= ['id'];
	
	protected $table = 'tvradios';

	protected $fillable = ['key', 'name', 'stream', 'image', 'bgcolor', 'position', 'channel', 'status'];

	protected $keyType = 'int';
}
