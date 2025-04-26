<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RUserDivision
 * 
 * @property int $r_user_division_id
 * @property int $user_id
 * @property int $organization_id
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MOrganization $m_organization
 * @property MUser $m_user
 *
 * @package App\Models
 */
class RUserDivision extends Model
{
	protected $table = 'r_user_division';
	protected $primaryKey = 'r_user_division_id';
	public $incrementing = false;

	protected $casts = [
		'r_user_division_id' => 'int',
		'user_id' => 'int',
		'organization_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'user_id',
		'organization_id',
		'created_by',
		'updated_by'
	];

	public function m_organization()
	{
		return $this->belongsTo(MOrganization::class, 'organization_id');
	}

	public function m_user()
	{
		return $this->belongsTo(MUser::class, 'user_id');
	}
}
