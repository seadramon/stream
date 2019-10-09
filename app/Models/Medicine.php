<?php

namespace Streamcms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
	use SoftDeletes;

    protected $guarded	= ['id'];
	
	protected $table = 'medicine';

	protected $fillable = ['nama'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $keyType = 'int';

	public function keyword()
	{
		return $this->belongsToMany('\Streamcms\Models\Keyword', 'keyword_medicine', 'medicine_id', 'keyword_id');
	}

	public function assignKeyword($keyword)
	{
		if (is_string($keyword)) {
            $keyword = \Streamcms\Models\Keyword::where('id', $keyword)->orWhere('nama', $keyword)->first();
        }

        return $this->keyword()->attach($keyword);
	}

	public function revokeKeyword($keyword = null)
	{
		if (is_string($keyword)) {
            $keyword = \Streamcms\Models\Keyword::where('id', $keyword)->orWhere('nama', $keyword)->first();
        }

        return $this->keyword()->detach($keyword);
	}
}
