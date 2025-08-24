<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $query = $user->transactions()->orderBy('date', 'desc');

    if ($request->start_date) {
        $query->where('date', '>=', $request->start_date);
    }
    if ($request->end_date) {
        $query->where('date', '<=', $request->end_date);
    }

    $transactions = $query->get();

    $totalReceita = $transactions->where('type', 'receita')->sum('amount');
    $totalDespesa = $transactions->where('type', 'despesa')->sum('amount');
    $totalSaldo = $totalReceita - $totalDespesa;

  
    $transactionsByCategory = $transactions
    ->groupBy(function($item) {
        return $item->category ? $item->category->name : 'Sem Categoria';
    })
    ->map(function($group) {
        return $group->sum('amount');
    });
 
    // Pass the transactionsByCategory to the view
    return view('dashboard', compact('transactions', 'totalReceita', 'totalDespesa', 'totalSaldo', 'transactionsByCategory'));
}



}
