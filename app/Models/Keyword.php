<?php

namespace Streamcms\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Keyword extends Model
{
    protected $guarded	= ['id'];
	
	protected $table = 'keyword';

	public $timestamps = false;

	protected $fillable = ['nama'];

	protected $keyType = 'int';

	public function medicine()
	{
		return $this->belongsToMany('\Streamcms\Models\Medicine', 'keyword_medicine', 'keyword_id', 'medicine_id');
	}

	public function assignMedicine($medicine)
	{
		if (is_string($medicine)) {
            $medicine = \Streamcms\Models\Medicine::where('id', $medicine)->orWhere('nama', $medicine)->first();
        }

        return $this->medicine()->attach($medicine);
	}

	public function revokeMedicine($medicine = null)
	{
		if (is_string($medicine)) {
            $medicine = \Streamcms\Models\Medicine::where('id', $medicine)->orWhere('nama', $medicine)->first();
        }

        return $this->medicine()->detach($medicine);
	}

	public function info()
	{
		return $this->belongsToMany('\Streamcms\Models\Info', 'keyword_info', 'keyword_id', 'info_id');
	}

	public function assignInfo($info)
	{
		if (is_string($info)) {
            $info = \Streamcms\Models\Info::where('id', $info)->orWhere('nama', $info)->first();
        }

        return $this->info()->attach($info);
	}

	public function revokeInfo($info = null)
	{
		if (is_string($info)) {
            $info = \Streamcms\Models\Info::where('id', $info)->orWhere('nama', $info)->first();
        }

        return $this->info()->detach($info);
	}
}
