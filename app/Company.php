<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 *
 * @package App
 * @property string $nome
 * @property text $endereco
 * @property string $telefone
*/
class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'endereco', 'telefone'];
    protected $hidden = [];
    
    
    
    public function premiacaos() {
        return $this->hasMany(Premiacao::class, 'company_id');
    }
}
