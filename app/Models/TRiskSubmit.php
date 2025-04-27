<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TRiskSubmit
 * 
 * @property int $risk_id
 * @property string $company_cd
 * @property int $risk_seq
 * @property int $s_organization_id
 * @property string|null $s_submitted_by
 * @property Carbon $s_huppened_on
 * @property string $s_location
 * @property string|null $s_detail
 * @property string|null $s_ip_address
 * @property string|null $s_device
 * @property int $s_submit_type
 * @property Carbon $s_submitted_at
 * @property bool|null $is_allowed
 * @property Carbon|null $filtered_at
 * @property int|null $c_target_type
 * @property int|null $c_score_1
 * @property int|null $c_score_2
 * @property int|null $c_score_3
 * @property string|null $c_scoring_comment
 * @property int|null $c_score_entered_by
 * @property Carbon|null $c_score_entered_at
 * @property bool|null $c_is_sent_to_hinkan
 * @property Carbon|null $c_sent_to_hinkan_at
 * @property int|null $c_risk_type
 * @property int|null $c_accident_id
 * @property int|null $c_accept_type
 * @property string|null $c_accepting_comment
 * @property int|null $c_accept_entered_by
 * @property Carbon|null $c_accept_entered_at
 * @property bool|null $is_good_practice
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property MUser|null $m_user
 * @property MAccidentType|null $m_accident_type
 * @property MCompany $m_company
 * @property MOrganization $m_organization
 * @property Collection|TImage[] $t_images
 * @property Collection|TRiskAssessment[] $t_risk_assessments
 *
 * @package App\Models
 */
class TRiskSubmit extends Model
{
	protected $table = 't_risk_submit';
	protected $primaryKey = 'risk_id';
	public $incrementing = true;

	protected $casts = [
		'risk_id' => 'int',
		'risk_seq' => 'int',
		's_organization_id' => 'int',
		's_huppened_on' => 'datetime',
		's_submit_type' => 'int',
		's_submitted_at' => 'datetime',
		'is_allowed' => 'bool',
		'filtered_at' => 'datetime',
		'c_target_type' => 'int',
		'c_score_1' => 'int',
		'c_score_2' => 'int',
		'c_score_3' => 'int',
		'c_score_entered_by' => 'int',
		'c_score_entered_at' => 'datetime',
		'c_is_sent_to_hinkan' => 'bool',
		'c_sent_to_hinkan_at' => 'datetime',
		'c_risk_type' => 'int',
		'c_accident_id' => 'int',
		'c_accept_type' => 'int',
		'c_accept_entered_by' => 'int',
		'c_accept_entered_at' => 'datetime',
		'is_good_practice' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'risk_seq',
		's_organization_id',
		's_submitted_by',
		's_huppened_on',
		's_location',
		's_detail',
		's_ip_address',
		's_device',
		's_submit_type',
		's_submitted_at',
		'is_allowed',
		'filtered_at',
		'c_target_type',
		'c_score_1',
		'c_score_2',
		'c_score_3',
		'c_scoring_comment',
		'c_score_entered_by',
		'c_score_entered_at',
		'c_is_sent_to_hinkan',
		'c_sent_to_hinkan_at',
		'c_risk_type',
		'c_accident_id',
		'c_accept_type',
		'c_accepting_comment',
		'c_accept_entered_by',
		'c_accept_entered_at',
		'is_good_practice',
		'created_by',
		'updated_by'
	];

	public function m_user()
	{
		return $this->belongsTo(MUser::class, 'c_accept_entered_by');
	}

	public function m_accident_type()
	{
		return $this->belongsTo(MAccidentType::class, 'c_accident_id');
	}

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function m_organization()
	{
		return $this->belongsTo(MOrganization::class, 's_organization_id');
	}

	public function t_images()
	{
		return $this->hasMany(TImage::class, 'risk_id');
	}

	public function t_risk_assessments()
	{
		return $this->hasMany(TRiskAssessment::class, 'risk_id');
	}
}
