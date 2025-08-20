<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalReceita = $user->transactions()->where('type', 'receita')->sum('amount');
        $totalDespesa = $user->transactions()->where('type', 'despesa')->sum('amount');
        $totalSaldo = $totalReceita - $totalDespesa;

        return view('dashboard', compact('totalReceita', 'totalDespesa', 'totalSaldo'));
    }
}
