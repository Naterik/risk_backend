<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable; // Import trait
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; // Import giao diện

/**
 * Class MUser
 * 
 * @property int $user_id
 * @property string $company_cd
 * @property int $user_seq
 * @property string $user_login_id
 * @property string $login_pw
 * @property string $user_nm
 * @property int $user_type_id
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MUserType $m_user_type
 * @property MCompany $m_company
 * @property Collection|RUserDivision[] $r_user_divisions
 * @property Collection|TPending[] $t_pendings
 * @property Collection|TRiskAssessment[] $t_risk_assessments
 * @property Collection|TRiskSubmit[] $t_risk_submits
 *
 * @package App\Models
 */
class MUser extends Model implements AuthenticatableContract, JWTSubject
{
	use SoftDeletes;
	use Authenticatable; // Sử dụng trait Authenticatable

	protected $table = 'm_user';
	protected $primaryKey = 'user_id';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'user_seq' => 'int',
		'user_type_id' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'user_seq',
		'user_login_id',
		'login_pw',
		'user_nm',
		'user_type_id',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_user_type()
	{
		return $this->belongsTo(MUserType::class, 'user_type_id');
	}

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function r_user_divisions()
	{
		return $this->hasMany(RUserDivision::class, 'user_id');
	}

	public function t_pendings()
	{
		return $this->hasMany(TPending::class, 'restart_by');
	}

	public function t_risk_assessments()
	{
		return $this->hasMany(TRiskAssessment::class, 'pr_plan_person');
	}

	public function t_risk_submits()
	{
		return $this->hasMany(TRiskSubmit::class, 'c_accept_entered_by');
	}

	// Phương thức cho JWTSubject
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
		return [];
	}

	// Ghi đè phương thức getAuthPassword để sử dụng cột login_pw
	public function getAuthPassword()
	{
		return $this->login_pw;
	}
}
