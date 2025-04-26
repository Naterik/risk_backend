<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MRiskScore
 * 
 * @property int $risk_score_id
 * @property string $company_cd
 * @property int $score_type
 * @property string|null $score_nm
 * @property int $score
 * @property string|null $score_detail
 * @property string|null $color
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MCompany $m_company
 *
 * @package App\Models
 */
class MRiskScore extends Model
{
	use SoftDeletes;
	protected $table = 'm_risk_score';
	protected $primaryKey = 'risk_score_id';
	public $incrementing = false;

	protected $casts = [
		'risk_score_id' => 'int',
		'score_type' => 'int',
		'score' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'score_type',
		'score_nm',
		'score',
		'score_detail',
		'color',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}
}
