@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <!-- Card Receita -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Receitas</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ $totalReceita ?? '0,00' }}</h5>
                </div>
            </div>
        </div>

        <!-- Card Despesa -->
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Despesas</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ $totalDespesa ?? '0,00' }}</h5>
                </div>
            </div>
        </div>

        <!-- Card Saldo -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Saldo</div>
                <div class="card-body">
                    <h5 class="card-title">R$ {{ $totalSaldo ?? '0,00' }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulário para criar categoria -->
    <div class="row">
        

        <div class="col-md-6">
            <h4>Suas categorias</h4>
            <ul class="list-group">
                @forelse(auth()->user()->categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $category->name }} ({{ $category->type }})
                    </li>
                @empty
                    <li class="list-group-item">Você ainda não criou categorias.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
