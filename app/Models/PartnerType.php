<?php
namespace App\Models;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Award[] $awards
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PartnerType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PartnerType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PartnerType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PartnerType withoutTrashed()
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

    public function awards()
    {
        return $this->belongsToMany(Award::class, 'award_partner_type', 'partner_type_id','award_id' );
    }

    public function getFullDescription(): string {
        $company = $this->company()->first();
        return $this->description.' '.$company->nome;
    }
}
