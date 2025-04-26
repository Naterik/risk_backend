<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MAccidentType
 * 
 * @property int $accident_type_id
 * @property string $company_cd
 * @property int $accident_type_seq
 * @property string|null $accident_type_cd
 * @property string $accident_type_nm
 * @property string|null $detail
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property Collection|MRiskExample[] $m_risk_examples
 * @property Collection|TRiskAssessment[] $t_risk_assessments
 * @property Collection|TRiskSubmit[] $t_risk_submits
 *
 * @package App\Models
 */
class MAccidentType extends Model
{
	use SoftDeletes;
	protected $table = 'm_accident_type';
	protected $primaryKey = 'accident_type_id';
	public $incrementing = false;

	protected $casts = [
		'accident_type_id' => 'int',
		'accident_type_seq' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'accident_type_seq',
		'accident_type_cd',
		'accident_type_nm',
		'detail',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_risk_examples()
	{
		return $this->hasMany(MRiskExample::class, 'accident_type_id');
	}

	public function t_risk_assessments()
	{
		return $this->hasMany(TRiskAssessment::class, 'an_accident_id');
	}

	public function t_risk_submits()
	{
		return $this->hasMany(TRiskSubmit::class, 'c_accident_id');
	}
}
