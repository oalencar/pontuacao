<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\FormatData;

/**
 * Class Partner
 *
 * @package App
 * @property string $company
 * @property string $user
 * @property string $partner_type
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $user_id
 * @property int|null $partner_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-write mixed $company_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Partner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner wherePartnerTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Partner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Partner withoutTrashed()
 * @mixin \Eloquent
 */
class Partner extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'partner_type_id', 'company_id', 'whatsapp'];
    protected $hidden = [];
    protected $with = ['partner_type', 'company', 'user'];



    /**
     * Set to null if empty
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPartnerTypeIdAttribute($input)
    {
        $this->attributes['partner_type_id'] = $input ? $input : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partner_type()
    {
        return $this->belongsTo(PartnerType::class, 'partner_type_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'partner_id');
    }

    public function setWhatsappAttribute($value){
        return FormatData::cleanPhoneNumber($value);
    }

    public function getWhatsappAttribute($value){
        return FormatData::cleanPhoneNumber($value);
    }

}
