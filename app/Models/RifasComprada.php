<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RifasComprada
 *
 * @property $id
 * @property $idComprador
 * @property $idRifa
 * @property $NumeroDaRifa
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Rifa $rifa
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class RifasComprada extends Model
{
    use SoftDeletes;

    static $rules = [
        'quantidadeNumeros' => 'required|integer|min:1',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idComprador','idRifa','NumeroDaRifa'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rifa()
    {
        return $this->hasOne('App\Models\Rifa', 'id', 'idRifa');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'idComprador');
    }
    

    
    

}
