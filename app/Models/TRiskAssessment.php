<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TRiskAssessment
 * 
 * @property int $risk_assessment_id
 * @property int $risk_id
 * @property int $risk_assessment_seq
 * @property int $status_id
 * @property bool $is_pending
 * @property string|null $an_location
 * @property int|null $an_work_process_id
 * @property string|null $an_hazard
 * @property int|null $an_accident_id
 * @property string|null $an_work_detail
 * @property string|null $an_risk_detail
 * @property int|null $an_score_1
 * @property int|null $an_score_2
 * @property int|null $an_score_3
 * @property int|null $an_entered_by
 * @property Carbon|null $an_entered_at
 * @property Carbon|null $pr_plan_date
 * @property int|null $pr_plan_person
 * @property string|null $pr_detail
 * @property int|null $pr_entered_by
 * @property Carbon|null $pr_entered_at
 * @property Carbon|null $im_done_on
 * @property int|null $im_done_by
 * @property string|null $im_detail
 * @property int|null $im_entered_by
 * @property Carbon|null $im_entered_at
 * @property int|null $re_score_1
 * @property int|null $re_score_2
 * @property int|null $re_score_3
 * @property string|null $re_comment
 * @property int|null $re_entered_by
 * @property Carbon|null $re_entered_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MUser|null $m_user
 * @property MWorkProcess|null $m_work_process
 * @property CRiskStatus $c_risk_status
 * @property MAccidentType|null $m_accident_type
 * @property TRiskSubmit $t_risk_submit
 * @property Collection|TImage[] $t_images
 * @property Collection|TPending[] $t_pendings
 *
 * @package App\Models
 */
class TRiskAssessment extends Model
{
	protected $table = 't_risk_assessment';
	protected $primaryKey = 'risk_assessment_id';
	public $incrementing = false;

	protected $casts = [
		'risk_assessment_id' => 'int',
		'risk_id' => 'int',
		'risk_assessment_seq' => 'int',
		'status_id' => 'int',
		'is_pending' => 'bool',
		'an_work_process_id' => 'int',
		'an_accident_id' => 'int',
		'an_score_1' => 'int',
		'an_score_2' => 'int',
		'an_score_3' => 'int',
		'an_entered_by' => 'int',
		'an_entered_at' => 'datetime',
		'pr_plan_date' => 'datetime',
		'pr_plan_person' => 'int',
		'pr_entered_by' => 'int',
		'pr_entered_at' => 'datetime',
		'im_done_on' => 'datetime',
		'im_done_by' => 'int',
		'im_entered_by' => 'int',
		'im_entered_at' => 'datetime',
		're_score_1' => 'int',
		're_score_2' => 'int',
		're_score_3' => 'int',
		're_entered_by' => 'int',
		're_entered_at' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'risk_id',
		'risk_assessment_seq',
		'status_id',
		'is_pending',
		'an_location',
		'an_work_process_id',
		'an_hazard',
		'an_accident_id',
		'an_work_detail',
		'an_risk_detail',
		'an_score_1',
		'an_score_2',
		'an_score_3',
		'an_entered_by',
		'an_entered_at',
		'pr_plan_date',
		'pr_plan_person',
		'pr_detail',
		'pr_entered_by',
		'pr_entered_at',
		'im_done_on',
		'im_done_by',
		'im_detail',
		'im_entered_by',
		'im_entered_at',
		're_score_1',
		're_score_2',
		're_score_3',
		're_comment',
		're_entered_by',
		're_entered_at',
		'created_by',
		'updated_by'
	];

	public function m_user()
	{
		return $this->belongsTo(MUser::class, 'pr_plan_person');
	}

	public function m_work_process()
	{
		return $this->belongsTo(MWorkProcess::class, 'an_work_process_id');
	}

	public function c_risk_status()
	{
		return $this->belongsTo(CRiskStatus::class, 'status_id');
	}

	public function m_accident_type()
	{
		return $this->belongsTo(MAccidentType::class, 'an_accident_id');
	}

	public function t_risk_submit()
	{
		return $this->belongsTo(TRiskSubmit::class, 'risk_id');
	}

	public function t_images()
	{
		return $this->hasMany(TImage::class, 'risk_assessment_id');
	}

	public function t_pendings()
	{
		return $this->hasMany(TPending::class, 'risk_assessment_id');
	}
}
