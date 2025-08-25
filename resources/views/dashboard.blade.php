@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- ================================
         Formulário de filtro de datas (Dashboard)
         ================================ -->
    <div class="row mb-3 justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <form action="{{ route('dashboard') }}" method="GET"
                class="row gy-2 gx-3 align-items-center p-3 border rounded shadow-sm bg-white">

                <!-- Título do formulário -->
                <h2 class="text-center">Data de consulta</h2>

                <!-- Campo Data Inicial -->
                <div class="col-sm-6 col-md-auto">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}" aria-label="Data inicial">
                    </div>
                </div>

                <!-- Campo Data Final -->
                <div class="col-sm-6 col-md-auto">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}" aria-label="Data final">
                    </div>
                </div>

                <!-- Botões Filtrar e Limpar -->
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <!-- Botão Limpar só aparece se houver filtro aplicado -->
                    @if(request('start_date') || request('end_date'))
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- ================================
         Cards Resumo (Receita, Despesa, Saldo)
         ================================ -->
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

    <div class="row">
        <!-- ================================
     Categorias em Cards Premium
     ================================ -->
        <div class="row mb-4">
            <div class="col-12">
                <h4>Suas categorias</h4>

                <!-- Campo de pesquisa -->
                <div class="mb-3">
                    <input type="text" id="searchCategory" class="form-control" placeholder="Pesquisar categoria...">
                </div>

                <div class="row" id="categoriesContainer">

                    @foreach($categories as $category)
                    @php
                    $percent = $totalGeral > 0 ? ($category->total / $totalGeral) * 100 : 0;
                    $gradient = $category->type == 'receita'
                    ? 'bg-gradient-success'
                    : 'bg-gradient-danger';
                    @endphp

                    <div class="col-sm-6 col-md-4 mb-3 category-card" data-name="{{ strtolower($category->name) }}">
                        <div class="card h-100 shadow-sm card-hover {{ $gradient }}">
                            <div class="card-body text-white">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi {{ $category->icon }} fs-3 me-2"></i>
                                    <h5 class="card-title mb-0">{{ $category->name }}</h5>
                                </div>
                                <p class="card-text mb-1">
                                    Tipo:
                                    <span
                                        class="badge {{ $category->type == 'receita' ? 'bg-light text-success' : 'bg-light text-danger' }}">
                                        {{ ucfirst($category->type) }}
                                    </span>
                                </p>
                                <p class="card-text mb-2">
                                    Total: <strong>R$ {{ number_format($category->total, 2, ',', '.') }}</strong>
                                </p>

                                <div class="progress" style="height: 8px; background-color: rgba(255,255,255,0.3);">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $percent }}%; transition: width 1s ease;"
                                        aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>

            </div>
        </div>

    </div>
    <div class="row">

        <!-- ================================
             Tabela de Transações Recentes
             ================================ -->
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


    </div> <!-- Fim da row principal -->

    <!-- ================================
     Script de filtro por nome
     ================================ -->
    <script>
    document.getElementById('searchCategory').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        const cards = document.querySelectorAll('#categoriesContainer .category-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            card.style.display = name.includes(search) ? 'block' : 'none';
        });
    });
    </script>
</div>
@endsection