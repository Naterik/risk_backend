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
 * Class MProvisionType
 * 
 * @property int $provision_type_id
 * @property string $company_cd
 * @property int $risk_provision_type_seq
 * @property string|null $name
 * @property bool $is_required_provision
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property Collection|MRiskLevel[] $m_risk_levels
 *
 * @package App\Models
 */
class MProvisionType extends Model
{
	use SoftDeletes;
	protected $table = 'm_provision_type';
	protected $primaryKey = 'provision_type_id';
	public $incrementing = false;

	protected $casts = [
		'provision_type_id' => 'int',
		'risk_provision_type_seq' => 'int',
		'is_required_provision' => 'bool',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'risk_provision_type_seq',
		'name',
		'is_required_provision',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_risk_levels()
	{
		return $this->hasMany(MRiskLevel::class, 'provision_type_id');
	}
}
