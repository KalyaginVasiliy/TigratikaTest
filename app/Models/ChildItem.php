<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildItem extends Model
{
    protected $fillable = ['nomenclature_item_id', 'name', 'quantity', 'source', 'laser', 'welding', 'assembly', 'electrical'];

    public function nomenclatureItem()
    {
        return $this->belongsTo(NomenclatureItem::class);
    }
}
