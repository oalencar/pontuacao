<?php
namespace App\Models;

use App\Classes\WhatsappMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cliente
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $email_alternative
 * @property string $phone
 * @property string $company
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente newQuery()
 * @method static \Illuminate\Database\Query\Builder|\\App\Models\Cliente onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereEmailAlternative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\\App\Models\Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\\App\Models\Cliente withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\\App\Models\Cliente withoutTrashed()
 * @mixin \Eloquent
 */
class Cliente extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'email_alternative', 'phone', 'company_id'];
    protected $hidden = [];



    /**
     * Set to null if empty
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withTrashed();
    }

    public function getPhoneAttribute($value){
        return preg_replace("/[^0-9]/", "", $value );
    }

    public function setPhoneAttribute($value){
        return preg_replace("/[^0-9]/", "", $value );
    }

}
