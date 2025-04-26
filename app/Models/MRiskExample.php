<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MRiskExample
 * 
 * @property int $risk_example_id
 * @property string $company_cd
 * @property int $accident_type_id
 * @property int $risk_example_seq
 * @property string|null $detail
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MAccidentType $m_accident_type
 * @property MCompany $m_company
 *
 * @package App\Models
 */
class MRiskExample extends Model
{
	use SoftDeletes;
	protected $table = 'm_risk_examples';
	protected $primaryKey = 'risk_example_id';
	public $incrementing = false;

	protected $casts = [
		'risk_example_id' => 'int',
		'accident_type_id' => 'int',
		'risk_example_seq' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'accident_type_id',
		'risk_example_seq',
		'detail',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_accident_type()
	{
		return $this->belongsTo(MAccidentType::class, 'accident_type_id');
	}

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}
}
