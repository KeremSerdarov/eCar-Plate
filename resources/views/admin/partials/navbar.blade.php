<nav class="navbar navbar-dark px-4 py-3" style="background: linear-gradient(135deg, #2E7D32, #1B5E20);">
    <span class="navbar-brand fw-bold fs-4">
        <i class="fa-solid fa-database"></i> eCar Plate — Admin
    </span>
    <div class="d-flex align-items-center gap-3">
        <span class="text-white">
            <i class="fa-solid fa-user"></i> {{ session('admin_username') }}
        </span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm rounded-3">
                <i class="fa-solid fa-right-from-bracket"></i> Çykyş
            </button>
        </form>
    </div>
</nav>