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
 * Class MCompany
 * 
 * @property string $company_cd
 * @property string $company_nm
 * @property bool|null $use_filter
 * @property string|null $color_main
 * @property string|null $color_sub
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property Collection|MOrganization[] $m_organizations
 * @property Collection|MRiskExample[] $m_risk_examples
 * @property Collection|MRiskLevel[] $m_risk_levels
 * @property Collection|MRiskScore[] $m_risk_scores
 * @property Collection|MUrlAuthentication[] $m_url_authentications
 * @property Collection|MUser[] $m_users
 * @property Collection|MUserType[] $m_user_types
 * @property Collection|MWorkProcess[] $m_work_processes
 * @property Collection|TRiskSubmit[] $t_risk_submits
 *
 * @package App\Models
 */
class MCompany extends Model
{
	use SoftDeletes;
	protected $table = 'm_company';
	protected $primaryKey = 'company_cd';
	public $incrementing = false;

	protected $casts = [
		'use_filter' => 'bool',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_nm',
		'use_filter',
		'color_main',
		'color_sub',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_organizations()
	{
		return $this->hasMany(MOrganization::class, 'company_cd');
	}

	public function m_risk_examples()
	{
		return $this->hasMany(MRiskExample::class, 'company_cd');
	}

	public function m_risk_levels()
	{
		return $this->hasMany(MRiskLevel::class, 'company_cd');
	}

	public function m_risk_scores()
	{
		return $this->hasMany(MRiskScore::class, 'company_cd');
	}

	public function m_url_authentications()
	{
		return $this->hasMany(MUrlAuthentication::class, 'company_cd');
	}

	public function m_users()
	{
		return $this->hasMany(MUser::class, 'company_cd');
	}

	public function m_user_types()
	{
		return $this->hasMany(MUserType::class, 'company_cd');
	}

	public function m_work_processes()
	{
		return $this->hasMany(MWorkProcess::class, 'company_cd');
	}

	public function t_risk_submits()
	{
		return $this->hasMany(TRiskSubmit::class, 'company_cd');
	}
}
