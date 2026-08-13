@extends('layouts.app')

@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center"
        style="background: linear-gradient(145deg, #f6f9fc 0%, #e6f0f5 100%);">

        <div class="card border-0 shadow-lg rounded-4 p-4" style="width:100%; max-width:420px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color:#2E7D32;">
                    <i class="fa-solid fa-lock"></i> Admin Paneli
                </h2>
                <p class="text-muted">Giriş maglumatlaryny ýazyň</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    {{ $errors->first('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase">
                        <i class="fa-solid fa-user text-success"></i> Ulanyjy ady
                    </label>
                    <input type="text" name="username" class="form-control form-control-lg rounded-3" placeholder="admin"
                        required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted small text-uppercase">
                        <i class="fa-solid fa-key text-success"></i> Parol
                    </label>
                    <input type="password" name="password" class="form-control form-control-lg rounded-3"
                        placeholder="••••••" required>
                </div>
                <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-3">
                    <i class="fa-solid fa-right-to-bracket"></i> GIR
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-muted small">
                    <i class="fa-solid fa-arrow-left"></i> Baş sahypa
                </a>
            </div>
        </div>

    </div>
@endsection