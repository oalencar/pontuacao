<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PartnerType
 *
 * @package App
 * @property string $description
 * @property string $company
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Award[] $awards
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PartnerType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartnerType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PartnerType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PartnerType withoutTrashed()
 * @mixin \Eloquent
 */
class PartnerType extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'company_id'];
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

//    public function awards() {
//        return $this->hasMany(Award::class, 'partner_type_id');
//    }

    public function awards()
    {
//        return $this->belongsToMany(Company::class, 'company_partner', 'partner_id','company_id' );
        return $this->belongsToMany(Award::class, 'award_partner_type', 'partner_type_id','award_id' );
    }
}
