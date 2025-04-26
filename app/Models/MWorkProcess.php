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
 * Class MWorkProcess
 * 
 * @property int $work_process_id
 * @property string $company_cd
 * @property int $work_process_seq
 * @property string|null $name
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MCompany $m_company
 * @property Collection|TRiskAssessment[] $t_risk_assessments
 *
 * @package App\Models
 */
class MWorkProcess extends Model
{
	use SoftDeletes;
	protected $table = 'm_work_process';
	protected $primaryKey = 'work_process_id';
	public $incrementing = false;

	protected $casts = [
		'work_process_id' => 'int',
		'work_process_seq' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'work_process_seq',
		'name',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function t_risk_assessments()
	{
		return $this->hasMany(TRiskAssessment::class, 'an_work_process_id');
	}
}
