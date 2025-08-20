<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <!-- Botão para abrir/fechar sidebar -->
        <button class="btn btn-primary me-2" id="sidebarToggle">☰</button>

        <a class="navbar-brand" href="#">Dashboard</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Notificações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Perfil</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    toggleBtn.addEventListener('click', () => {
        if(sidebar.style.width === '0px' || sidebar.style.width === '') {
            sidebar.style.width = '250px';
            mainContent.style.marginLeft = '250px';
        } else {
            sidebar.style.width = '0';
            mainContent.style.marginLeft = '0';
        }
    });
</script>
