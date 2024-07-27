<?php

namespace App\Http\Controllers;

use App\Models\NomenclatureItem;
use App\Models\ChildItem;
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

    public function updatePosition(Request $request, $id)
    {
        $item = NomenclatureItem::findOrFail($id);
        $item->position = $request->input('position');
        $item->save();

        return response()->json(['success' => true]);
    }

    public function deleteItem($id)
    {
        $item = NomenclatureItem::findOrFail($id);
        $item->delete();

        return response()->json(['success' => true]);
    }

    public function deleteChildItem($parentId, $childId)
    {
        $parent = NomenclatureItem::findOrFail($parentId);
        $child = $parent->childItems()->findOrFail($childId);
        $child->delete();

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        // Валидация данных
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'source' => 'required|string',
            'laser' => 'nullable|integer',
            'welding' => 'nullable|integer',
            'assembly' => 'nullable|integer',
            'electrical' => 'nullable|integer',
        ]);

        // Создание записи
        $item = NomenclatureItem::create($validatedData);

        return response()->json($item, 201);
    }

    public function storeChild(Request $request, $id)
    {
        // Валидация данных
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'source' => 'required|string',
            'laser' => 'nullable|integer',
            'welding' => 'nullable|integer',
            'assembly' => 'nullable|integer',
            'electrical' => 'nullable|integer',
        ]);

        // Найти родительский элемент по ID
        $parentItem = NomenclatureItem::findOrFail($id);

        // Создать новую запись в дочерней таблице
        $childItem = new ChildItem($validatedData);
        $childItem->nomenclature_item_id = $parentItem->id;
        $childItem->save();

        return response()->json($childItem, 201);
    }
}
