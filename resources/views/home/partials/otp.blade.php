<!-- Telefon girizmek -->
<div id="otpSection">
    <div class="mb-3">
        <label class="form-label fw-semibold text-muted small text-uppercase">
            <i class="fa-solid fa-phone text-success"></i> Telefon belgisi
        </label>
        <input type="text" id="phoneInp" class="form-control form-control-lg rounded-3" placeholder="+99312345678">
    </div>
    <button onclick="sendOtp()" class="btn btn-success w-100 py-3 fw-bold rounded-3" id="sendOtpBtn">
        <i class="fa-solid fa-paper-plane"></i> KOD IBER
    </button>
</div>

<!-- Kod girizmek -->
<div id="codeSection" style="display:none;">
    <div class="alert alert-info rounded-3" id="codeDisplay"></div>
    <div class="mb-3">
        <label class="form-label fw-semibold text-muted small text-uppercase">
            <i class="fa-solid fa-key text-success"></i> Tassyklama kody
        </label>
        <input type="text" id="codeInp" class="form-control form-control-lg rounded-3" maxlength="6"
            placeholder="000000">
    </div>
    <div class="text-center mb-3">
        <span class="badge bg-danger fs-6" id="timer">1:30</span>
    </div>
    <button onclick="verifyOtp()" class="btn btn-success w-100 py-3 fw-bold rounded-3">
        <i class="fa-solid fa-check"></i> TASSYKLA
    </button>
</div>

<!-- Nomer saýlamak -->
<div id="plateSection" style="display:none;" class="mt-3">
    <div class="mb-3">
        <label class="form-label fw-semibold text-muted small text-uppercase">
            <i class="fa-solid fa-map-marker-alt text-success"></i> Welaýat saýlaň
        </label>
        <select id="regionSel" class="form-select form-select-lg rounded-3" onchange="updateRegion()">
            @foreach($regions as $region)
                <option value="{{ $region->id }}" data-code="{{ $region->code }}">
                    {{ $region->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold text-muted small text-uppercase">
            <i class="fa-solid fa-hashtag text-success"></i> Nomeri saýlaň (4 san)
        </label>
        <input type="text" id="numberInp" class="form-control form-control-lg rounded-3" maxlength="4"
            placeholder="1234" oninput="checkNumber()">
    </div>
    <div id="priceDisplay" class="alert rounded-3" style="display:none;"></div>
    <div id="errorText" class="text-danger small fw-bold" style="display:none;"></div>

    <button onclick="generateFree()" class="btn btn-primary w-100 py-3 fw-bold rounded-3 mb-2" id="freeBtn">
        <i class="fa-solid fa-gift"></i> MUGT NOMER AL
    </button>
</div>