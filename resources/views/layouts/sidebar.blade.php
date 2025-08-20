<div id="sidebar" class="sidebar bg-dark text-white position-fixed top-0 start-0 vh-100"
    style="width:0; overflow:hidden; transition: width 0.3s;">
    <h4 class="text-center py-3">Meu Dashboard</h4>
    <a href="{{ route('dashboard') }}" class="d-block px-3 py-2">Inicio</a>
    <a href="{{ route('profile.edit') }}" class="d-block px-3 py-2">Perfil</a>
    <a href="#" class="d-block px-3 py-2">Configurações</a>
    <form action="{{ route('logout') }}" method="POST" class="d-block px-3 py-2">
        @csrf
        <button type="submit" class="btn btn-link text-white p-0 m-0" style="text-decoration:none;">
            Sair
        </button>
    </form>

</div>