<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rifa extends Model
{
    use HasFactory;

    public function getImagensSorteioAttribute($value)
    {
        return explode(',', $value);
    }

    public function setImagensSorteioAttribute($value)
    {
        $this->attributes['imagens_sorteio'] = implode(',', $value);
    }

    public function rifasAtivas(){

        return $this->where("status_rifa","ativa")->get();

    }
    public function rifasEncerradas(){

        return $this->whereIn("status_rifa",["finalizada","apurando"])->get();

    }


}
