<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h4 class="fw-bold mb-0" style="color:#1B5E20;">
            <i class="fa-solid fa-list"></i> Hasaba alnan ulaglar
        </h4>
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <select name="filter" class="form-select rounded-3" onchange="this.form.submit()">
                <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Ähli nomerler</option>
                <option value="VIP Nomer" {{ $filter === 'VIP Nomer' ? 'selected' : '' }}>VIP Nomerler</option>
                <option value="Yzygiderli Nomer" {{ $filter === 'Yzygiderli Nomer' ? 'selected' : '' }}>Yzygiderli
                </option>
                <option value="Premium Nomer" {{ $filter === 'Premium Nomer' ? 'selected' : '' }}>Premium</option>
                <option value="Mugt Nomer" {{ $filter === 'Mugt Nomer' ? 'selected' : '' }}>Mugt</option>
            </select>
        </form>
    </div>

    @if($plates->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-car fa-3x mb-3 opacity-25"></i>
            <p class="fs-5">Hiç zat ýok</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th>Belgi</th>
                        <th>Görnüş</th>
                        <th>Welaýat</th>
                        <th>Eýesi</th>
                        <th>Pasport</th>
                        <th>Ulag</th>
                        <th>Baha</th>
                        <th>Wagt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plates as $plate)
                        <tr>
                            <td>
                                <span class="badge fs-6 px-3 py-2"
                                    style="background:#1e293b; font-family:'Oswald',sans-serif; letter-spacing:2px;">
                                    {{ $plate->prefix }} {{ $plate->number }} {{ $plate->region->code }}
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill
                                        @if($plate->plateType->name === 'VIP Nomer') bg-danger
                                        @elseif($plate->plateType->name === 'Yzygiderli Nomer') bg-warning text-dark
                                        @elseif($plate->plateType->name === 'Premium Nomer') bg-success
                                        @else bg-info
                                        @endif">
                                    {{ $plate->plateType->name }}
                                </span>
                            </td>
                            <td>{{ $plate->region->name }}</td>
                            <td>{{ $plate->user->full_name }}</td>
                            <td>{{ $plate->user->passport_number }}</td>
                            <td>{{ $plate->car_model }}</td>
                            <td class="fw-bold" style="color:#2E7D32;">
                                {{ $plate->price_paid > 0 ? number_format($plate->price_paid, 2) . ' TMT' : 'MUGT' }}
                            </td>
                            <td class="text-muted small">{{ $plate->registered_at }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger rounded-3" onclick="deletePlate({{ $plate->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>