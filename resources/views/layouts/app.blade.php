<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Gerenciador')</title>

  {{-- Bootstrap 5 --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    :root{
      --bs-primary:#f97316;   /* laranja */
      --bs-secondary:#64748b; /* cinza azulado */
      --bs-dark:#1e293b;      /* grafite */
      --bs-light:#f8f9fa;     /* fundo claro */
    }

    body{ background:var(--bs-light); }

    /* SIDEBAR */
    #sidebar{
      position:fixed; inset:0 auto 0 0; /* top:0 right:auto bottom:0 left:0 */
      width:0; overflow:hidden;
      background:var(--bs-dark); color:#fff;
      transition:width .3s ease;
      z-index:1045; /* acima do conteúdo */
      padding:1rem 0;
    }
    #sidebar.open{ width:240px; }
    #sidebar a{ color:#fff; text-decoration:none; display:block; padding:.5rem 1rem; }
    #sidebar a:hover{ background:var(--bs-primary); }

    /* BACKDROP (mobile) */
    .sidebar-backdrop{
      position:fixed; inset:0; background:rgba(0,0,0,.35);
      opacity:0; pointer-events:none; transition:opacity .2s ease; z-index:1040;
    }
    #sidebar.open ~ .sidebar-backdrop{ opacity:1; pointer-events:auto; }

    /* CONTEÚDO + NAVBAR deslocam quando sidebar abre (desktop) */
    #main{ transition:margin-left .3s ease; }
    #sidebar.open ~ #main{ margin-left:240px; }

    /* Em telas menores, não empurra: só sobrepõe (estilo drawer) */
    @media (max-width: 991.98px){
      #sidebar.open ~ #main{ margin-left:0; }
    }
  </style>
</head>
<body>

  {{-- SIDEBAR primeiro no DOM para o seletor de irmãos funcionar --}}
  <div id="sidebar">
    <h4 class="text-center mb-3">Meu Dashboard</h4>
    <a href="{{ route('dashboard') }}">Home</a>
    <a href="{{ route('profile.edit') }}">Perfil</a>
    <a href="#">Configurações</a>
    <!-- Botão para abrir o modal de nova categoria -->
    <a href="#" class="d-block px-3 py-2" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        ➕ Categoria
    </a>
    <!-- Botão para abrir o modal de nova categoria -->
    <a href="#" class="d-block px-3 py-2" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
       ➕ Transação
</a>


    <form action="{{ route('logout') }}" method="POST" class="px-3 mt-2">
      @csrf
      <button type="submit" class="btn btn-danger w-100">Sair</button>
    </form>
  </div>

  {{-- BACKDROP para mobile --}}
  <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>

  {{-- WRAPPER que contém NAVBAR + CONTEÚDO (ambos serão empurrados) --}}
  <div id="main">
    <nav class="navbar navbar-dark bg-dark shadow">
      <div class="container-fluid">
        <button class="btn btn-primary" onclick="toggleSidebar()">☰</button>
        <a class="navbar-brand ms-3 fw-bold text-uppercase" href="{{ route('dashboard') }}">Meu Dashboard</a>
      </div>
    </nav>

    <div class="p-3">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('open');
    }
    // Fecha com ESC
    document.addEventListener('keydown', e => {
      if(e.key === 'Escape'){
        const s = document.getElementById('sidebar');
        if(s.classList.contains('open')) s.classList.remove('open');
      }
    });
  </script>
  <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar nova categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome da categoria</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="receita">Receita</option>
                            <option value="despesa">Despesa</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Criar Categoria</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Adicionar Transação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Descrição</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Valor</label>
                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="receita">Receita</option>
                            <option value="despesa">Despesa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoria</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            @foreach(auth()->user()->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Data</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
