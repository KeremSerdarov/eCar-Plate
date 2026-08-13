@extends('layouts.app')

@section('content')
    <div class="min-vh-100" style="background: linear-gradient(145deg, #f6f9fc 0%, #e6f0f5 100%);">

        @include('admin.partials.navbar')

        <div class="container-fluid p-4">
            @include('admin.partials.stats')
            @include('admin.partials.table')
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function deletePlate(id) {
            Swal.fire({
                title: 'Pozmalymy?',
                text: 'Bu ýazgy hemişelik pozular!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hawa, poz!',
                cancelButtonText: 'Ýatyr'
            }).then(async result => {
                if (result.isConfirmed) {
                    const res = await fetch(`/admin/plate/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        Swal.fire('Pozuldy!', '', 'success').then(() => location.reload());
                    }
                }
            });
        }
    </script>
@endpush