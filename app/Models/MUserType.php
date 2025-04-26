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
 * Class MUserType
 * 
 * @property int $user_type_id
 * @property string $company_cd
 * @property int $user_type_seq
 * @property string $user_type_nm
 * @property bool|null $can_submit_hiyari
 * @property bool|null $can_input_hiyari_from_pc
 * @property bool|null $can_categorize_to_target
 * @property bool|null $can_send_to_hinkan
 * @property bool|null $can_categorize_to_risk
 * @property bool|null $can_accept
 * @property bool|null $can_analyze
 * @property bool|null $can_take_maesure
 * @property bool|null $can_improve
 * @property bool|null $can_reevaluate
 * @property bool|null $can_submit
 * @property bool|null $can_edit_master
 * @property bool|null $can_check_another_division
 * @property bool|null $can_filtering
 * @property bool|null $can_set_gp
 * @property bool|null $can_delete_risk
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon $created_at
 * @property int $created_by
 * @property Carbon $updated_at
 * @property int $updated_by
 * 
 * @property MCompany $m_company
 * @property Collection|MUser[] $m_users
 *
 * @package App\Models
 */
class MUserType extends Model
{
	use SoftDeletes;
	protected $table = 'm_user_type';
	protected $primaryKey = 'user_type_id';
	public $incrementing = false;

	protected $casts = [
		'user_type_id' => 'int',
		'user_type_seq' => 'int',
		'can_submit_hiyari' => 'bool',
		'can_input_hiyari_from_pc' => 'bool',
		'can_categorize_to_target' => 'bool',
		'can_send_to_hinkan' => 'bool',
		'can_categorize_to_risk' => 'bool',
		'can_accept' => 'bool',
		'can_analyze' => 'bool',
		'can_take_maesure' => 'bool',
		'can_improve' => 'bool',
		'can_reevaluate' => 'bool',
		'can_submit' => 'bool',
		'can_edit_master' => 'bool',
		'can_check_another_division' => 'bool',
		'can_filtering' => 'bool',
		'can_set_gp' => 'bool',
		'can_delete_risk' => 'bool',
		'is_deleted' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_cd',
		'user_type_seq',
		'user_type_nm',
		'can_submit_hiyari',
		'can_input_hiyari_from_pc',
		'can_categorize_to_target',
		'can_send_to_hinkan',
		'can_categorize_to_risk',
		'can_accept',
		'can_analyze',
		'can_take_maesure',
		'can_improve',
		'can_reevaluate',
		'can_submit',
		'can_edit_master',
		'can_check_another_division',
		'can_filtering',
		'can_set_gp',
		'can_delete_risk',
		'is_deleted',
		'created_by',
		'updated_by'
	];

	public function m_company()
	{
		return $this->belongsTo(MCompany::class, 'company_cd');
	}

	public function m_users()
	{
		return $this->hasMany(MUser::class, 'user_type_id');
	}
}
