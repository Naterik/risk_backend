<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MUrlAuthentication
 * 
 * @property int $auth_id
 * @property string $company_cd
 * @property int $organization_id
 * @property string $auth_cd
 * @property Carbon|null $valid_dt_start
 * @property Carbon|null $valid_dt_end
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MCompany $m_company
 * @property MOrganization $m_organization
 *
 * @package App\Models
 */
class MUrlAuthentication extends Model
{
	protected $table = 'm_url_authentications';
	protected $primaryKey = 'auth_id';
	public $incrementing = false;

	protected $casts = [
		'auth_id' => 'int',
		'organization_id' => 'int',
		'valid_dt_start' => 'datetime',
		'valid_dt_end' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'organization_id',
		'auth_cd',
		'valid_dt_start',
		'valid_dt_end',
		'created_by',
		'updated_by'
	];

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function m_organization()
	{
		return $this->belongsTo(MOrganization::class, 'organization_id');
	}
}
