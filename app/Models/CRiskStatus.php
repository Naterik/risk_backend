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
 * Class CRiskStatus
 * 
 * @property int $status_id
 * @property int $status_seq
 * @property string $status_nm
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property Collection|TPending[] $t_pendings
 * @property Collection|TRiskAssessment[] $t_risk_assessments
 *
 * @package App\Models
 */
class CRiskStatus extends Model
{
	use SoftDeletes;
	protected $table = 'c_risk_status';
	protected $primaryKey = 'status_id';
	public $incrementing = false;

	protected $casts = [
		'status_id' => 'int',
		'status_seq' => 'int',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'status_seq',
		'status_nm',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function t_pendings()
	{
		return $this->hasMany(TPending::class, 'prev_status_id');
	}

	public function t_risk_assessments()
	{
		return $this->hasMany(TRiskAssessment::class, 'status_id');
	}
}
