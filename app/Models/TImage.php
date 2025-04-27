<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TImage
 * 
 * @property int $picture_id
 * @property int|null $risk_id
 * @property int|null $risk_assessment_id
 * @property int $picture_seq
 * @property string|null $file_path
 * @property string|null $file_nm
 * @property string|null $thumbnail_path
 * @property string|null $thumbnail_nm
 * @property string|null $took_at
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property TRiskSubmit|null $t_risk_submit
 * @property TRiskAssessment|null $t_risk_assessment
 *
 * @package App\Models
 */
class TImage extends Model
{
	protected $table = 't_images';
	protected $primaryKey = 'picture_id';
	public $incrementing = true;

	protected $casts = [
		'picture_id' => 'int',
		'risk_id' => 'int',
		'risk_assessment_id' => 'int',
		'picture_seq' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'risk_id',
		'risk_assessment_id',
		'picture_seq',
		'file_path',
		'file_nm',
		'thumbnail_path',
		'thumbnail_nm',
		'took_at',
		'created_by',
		'updated_by'
	];

	public function t_risk_submit()
	{
		return $this->belongsTo(TRiskSubmit::class, 'risk_id');
	}

	public function t_risk_assessment()
	{
		return $this->belongsTo(TRiskAssessment::class, 'risk_assessment_id');
	}

	public function getFileNameAttribute()
	{
		return $this->file_nm;
	}

	// Accessor để ánh xạ file_path thành path và tạo URL đầy đủ
	public function getPathAttribute()
	{
		return $this->file_path ? url('/storage' . $this->file_path) : null;
	}

	// Accessor để ánh xạ thumbnail_path thành thumbnail_path và tạo URL đầy đủ
	public function getThumbnailPathAttribute()
	{
		return $this->thumbnail_path ? url('/storage' . $this->thumbnail_path) : null;
	}
}
