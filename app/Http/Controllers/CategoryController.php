<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:receita,despesa',
        ]);

        auth()->user()->categories()->create([
            'name' => $request->name,
            'type' => $request->type,
            'is_default' => false,
        ]);

        return redirect()->back()->with('success', 'Categoria criada com sucesso!');
    }
}
