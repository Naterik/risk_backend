<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TPending
 * 
 * @property int $pending_id
 * @property int $risk_assessment_id
 * @property int $pending_seq
 * @property int $prev_status_id
 * @property Carbon $restart_plan_date
 * @property int $restart_by
 * @property string|null $pending_reason
 * @property Carbon|null $restarted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property TRiskAssessment $t_risk_assessment
 * @property MUser $m_user
 * @property CRiskStatus $c_risk_status
 *
 * @package App\Models
 */
class TPending extends Model
{
	protected $table = 't_pending';
	protected $primaryKey = 'pending_id';
	public $incrementing = false;

	protected $casts = [
		'pending_id' => 'int',
		'risk_assessment_id' => 'int',
		'pending_seq' => 'int',
		'prev_status_id' => 'int',
		'restart_plan_date' => 'datetime',
		'restart_by' => 'int',
		'restarted_at' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'risk_assessment_id',
		'pending_seq',
		'prev_status_id',
		'restart_plan_date',
		'restart_by',
		'pending_reason',
		'restarted_at',
		'created_by',
		'updated_by'
	];

	public function t_risk_assessment()
	{
		return $this->belongsTo(TRiskAssessment::class, 'risk_assessment_id');
	}

	public function m_user()
	{
		return $this->belongsTo(MUser::class, 'restart_by');
	}

	public function c_risk_status()
	{
		return $this->belongsTo(CRiskStatus::class, 'prev_status_id');
	}
}
