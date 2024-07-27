<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomenclatureItem extends Model
{
    protected $fillable = [
        'name', 'quantity', 'source', 'laser', 'welding', 'assembly', 'electrical', 'position'
    ];

    public function childItems()
    {
        return $this->hasMany(ChildItem::class);
    }
}
