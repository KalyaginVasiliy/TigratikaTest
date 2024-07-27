<?php

namespace App\Http\Controllers;

use App\Models\NomenclatureItem;
use Illuminate\Http\Request;

class NomenclaturePageController extends Controller
{
    public function index()
    {
        return view('nomenclature-page');
    }

    public function getData()
    {
        $nomenclatureItems = NomenclatureItem::with('childItems')->orderBy('position')->get();
        return response()->json($nomenclatureItems);
    }

    public function deleteItem($id)
    {
        NomenclatureItem::destroy($id);
        return response()->json(['status' => 'Item deleted']);
    }

    public function deleteChildItem($id)
    {
        ChildItem::destroy($id);
        return response()->json(['status' => 'Child item deleted']);
    }

    public function updatePositions(Request $request)
    {
        $items = $request->items;

        foreach ($items as $item) {
            $nomenclatureItem = NomenclatureItem::find($item['id']);
            if ($nomenclatureItem) {
                $nomenclatureItem->position = $item['position'];
                $nomenclatureItem->save();
            }
        }

        return response()->json(['status' => 'Positions updated']);
    }
}
