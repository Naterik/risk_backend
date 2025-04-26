<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MRiskLevel
 * 
 * @property int $risk_level_id
 * @property string $company_cd
 * @property int $risk_level
 * @property int $score_min
 * @property int $score_max
 * @property string|null $detail
 * @property int|null $provision_type_id
 * @property string|null $handling_text
 * @property string|null $color
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MCompany $m_company
 * @property MProvisionType|null $m_provision_type
 *
 * @package App\Models
 */
class MRiskLevel extends Model
{
	use SoftDeletes;
	protected $table = 'm_risk_level';
	protected $primaryKey = 'risk_level_id';
	public $incrementing = false;

	protected $casts = [
		'risk_level_id' => 'int',
		'risk_level' => 'int',
		'score_min' => 'int',
		'score_max' => 'int',
		'provision_type_id' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'risk_level',
		'score_min',
		'score_max',
		'detail',
		'provision_type_id',
		'handling_text',
		'color',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function m_provision_type()
	{
		return $this->belongsTo(MProvisionType::class, 'provision_type_id');
	}
}
