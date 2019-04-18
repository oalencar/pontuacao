<?php
namespace App\Models;

use App\Classes\FormatData;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Award
 *
 * @package App
 * @property string $title
 * @property text $description
 * @property integer $goal
 * @property string $start_date
 * @property string $finish_date
 * @property string $image
 * @property string $partner_type
 * @property string $company
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PartnerType[] $partner_types
 * @property-write mixed $company_id
 * @property-write mixed $partner_type_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Award onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereFinishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Award withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Award withoutTrashed()
 * @mixin \Eloquent
 */
class Award extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'goal', 'start_date', 'finish_date', 'image'];
    protected $hidden = [];
    protected $with = ['partner_type'];



    /**
     * Set attribute to money format
     * @param $input
     */
    public function setGoalAttribute($input)
    {
        $this->attributes['goal'] = $input ? FormatData::removeDotsOfString($input) : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setFinishDateAttribute($input)
    {

        if ($input != null && $input != '') {
            $this->attributes['finish_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['finish_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getFinishDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPartnerTypeIdAttribute($input)
    {
        $this->attributes['partner_type_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
    }

    public function partner_type()
    {
        return $this->belongsTo(PartnerType::class, 'partner_type_id')->withTrashed();
    }

    public function getCompanies()
    {
        $companies = $this->partner_types()
                                ->with('company')
                                ->get()
                                ->pluck('company')
                                ->unique('id');
        return $companies;
    }

    public function partner_types()
    {
        return $this->belongsToMany(PartnerType::class, 'award_partner_type', 'award_id','partner_type_id' );
    }

}
