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
 * Class MOrganization
 * 
 * @property int $organization_id
 * @property string $company_cd
 * @property int|null $parent_organization_id
 * @property int $division_1_id
 * @property int $division_2_id
 * @property int $division_3_id
 * @property string $organization_nm
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MCompany $m_company
 * @property MOrganization|null $m_organization
 * @property Collection|MOrganization[] $m_organizations
 * @property Collection|MUrlAuthentication[] $m_url_authentications
 * @property Collection|RUserDivision[] $r_user_divisions
 * @property Collection|TRiskSubmit[] $t_risk_submits
 *
 * @package App\Models
 */
class MOrganization extends Model
{
	use SoftDeletes;
	protected $table = 'm_organization';
	protected $primaryKey = 'organization_id';
	public $incrementing = false;

	protected $casts = [
		'organization_id' => 'int',
		'parent_organization_id' => 'int',
		'division_1_id' => 'int',
		'division_2_id' => 'int',
		'division_3_id' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'parent_organization_id',
		'division_1_id',
		'division_2_id',
		'division_3_id',
		'organization_nm',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function m_organization()
	{
		return $this->belongsTo(MOrganization::class, 'parent_organization_id');
	}

	public function m_organizations()
	{
		return $this->hasMany(MOrganization::class, 'parent_organization_id');
	}

	public function children()
	{
		return $this->m_organizations()->with('children')->where('is_deleted', false);
	}

	public function m_url_authentications()
	{
		return $this->hasMany(MUrlAuthentication::class, 'organization_id');
	}

	public function r_user_divisions()
	{
		return $this->hasMany(RUserDivision::class, 'organization_id');
	}

	public function t_risk_submits()
	{
		return $this->hasMany(TRiskSubmit::class, 's_organization_id');
	}
}
