@extends('layouts.app')

@section('content')

<div class="container mt-4">
    
    <div class="row mb-3 justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <form action="{{ route('dashboard') }}" method="GET"
                class="row gy-2 gx-3 align-items-center p-3 border rounded shadow-sm bg-white">

                <!-- Data Inicial -->
                <div class="col-sm-6 col-md-auto">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}" aria-label="Data inicial">
                    </div>
                </div>

                <!-- Data Final -->
                <div class="col-sm-6 col-md-auto">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}" aria-label="Data final">
                    </div>
                </div>

                <!-- Botões -->
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    @if(request('start_date') || request('end_date'))
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Card topo da página -->
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
        <div class="row mb-3">
            <div class="col-12">
                <form action="{{ route('dashboard') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label for="start_date" class="col-form-label">De:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-auto">
                        <label for="end_date" class="col-form-label">Até:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h4>Transações Recentes</h4>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Tipo</th>
                            <th>Categoria</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->title }}</td>
                            <td>R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                            <td>{{ ucfirst($transaction->type) }}</td>
                            <td>
                                @if($transaction->category)
                                <span class="badge 
            {{ $transaction->category->type == 'receita' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $transaction->category->name }}
                                </span>
                                @else
                                <span class="badge bg-secondary">Sem Categoria</span>
                                @endif
                            </td>

                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma transação registrada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h4>Total por Categoria</h4>
                <ul class="list-group">
                    @foreach($transactionsByCategory as $categoryName => $total)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $categoryName }}
                        <span class="badge bg-primary rounded-pill">
                            R$ {{ number_format($total, 2, ',', '.') }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>



    </div>



</div>
@endsection