<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
            <div class="fs-1">💰</div>
            <div class="fw-bold fs-3" style="color:#2E7D32;">{{ number_format($totalRevenue, 2) }} TMT</div>
            <div class="text-muted small text-uppercase fw-semibold">Jemi girdeji</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
            <div class="fs-1">👑</div>
            <div class="fw-bold fs-3" style="color:#2E7D32;">{{ $vipCount }}</div>
            <div class="text-muted small text-uppercase fw-semibold">VIP nomerler</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
            <div class="fs-1">📈</div>
            <div class="fw-bold fs-3" style="color:#2E7D32;">{{ $seqCount }}</div>
            <div class="text-muted small text-uppercase fw-semibold">Yzygiderli</div>
        </div>
    </div>
</div>