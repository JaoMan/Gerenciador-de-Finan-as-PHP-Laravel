<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Filtra transações do usuário por período
        $transactionsQuery = $user->transactions()->orderBy('date', 'desc');

        if ($request->start_date) {
            $transactionsQuery->where('date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $transactionsQuery->where('date', '<=', $request->end_date);
        }

        $transactions = $transactionsQuery->get();

        // Totais gerais
        $totalReceita = $transactions->where('type', 'receita')->sum('amount');
        $totalDespesa = $transactions->where('type', 'despesa')->sum('amount');
        $totalSaldo = $totalReceita - $totalDespesa;

        // Total por categoria
        $categories = $user->categories()->with('transactions')->get();

        $categories->transform(function ($category) use ($transactions) {
            $categoryTotal = $category->transactions()
                ->where(function($query) {
                    // só pega transações do usuário logado
                })
                ->sum('amount');

            $category->total = $categoryTotal;

            // Ícones para cada categoria (personalizáveis)
            $icons = [
                'Salário' => 'bi-cash-stack',
                'Freelance' => 'bi-laptop',
                'Aluguel' => 'bi-house',
                'Supermercado' => 'bi-basket',
                'Lazer' => 'bi-controller',
            ];
            $category->icon = $icons[$category->name] ?? 'bi-tags';

            return $category;
        });

        // Total geral para barra de progresso
        $totalGeral = $categories->sum('total');

        // Total por categoria filtrado para a tabela
        $transactionsByCategory = $transactions
            ->groupBy(function ($item) {
                return $item->category ? $item->category->name : 'Sem Categoria';
            })
            ->map(function ($group) {
                return $group->sum('amount');
            });

        return view('dashboard', compact(
            'transactions', 
            'totalReceita', 
            'totalDespesa', 
            'totalSaldo', 
            'transactionsByCategory',
            'categories',
            'totalGeral'
        ));
    }
}
