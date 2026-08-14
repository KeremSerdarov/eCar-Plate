@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4"
        style="background: linear-gradient(145deg, #f6f9fc 0%, #e6f0f5 100%); min-height: 100vh;">
        <div class="row justify-content-center g-4">

            <!-- Registrasiýa karty -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <h1 class="fw-bold fs-3"
                        style="background: linear-gradient(135deg, #2E7D32, #1B5E20); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        🚗 eCar Plate — Ulag Belgi Hasaba Alyş
                    </h1>
                    <p class="text-muted mb-4">
                        <i class="fa-solid fa-circle-check text-success"></i>
                        Türkmenistan — Resmi ulag belgi hasaba alyş ulgamy
                    </p>

                    @include('home.partials.plate')
                    @include('home.partials.otp')
                </div>
            </div>

            <!-- Eýesiniň maglumatlary -->
            <div class="col-lg-5" id="ownerCard" style="display:none;">
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <h3 class="fw-bold mb-1" style="color:#2E7D32;">
                        <i class="fa-solid fa-user-pen"></i> Eýesiniň maglumatlary
                    </h3>
                    <p class="text-muted mb-4">Ähli maglumatlary dogry dolduryň</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">
                            <i class="fa-regular fa-user text-success"></i> F.A.A
                        </label>
                        <input type="text" id="ownerName" class="form-control form-control-lg rounded-3"
                            placeholder="Amanow Aman Serdarowiç">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">
                            <i class="fa-regular fa-calendar text-success"></i> Doglan senesi
                        </label>
                        <input type="text" id="dobInp" class="form-control form-control-lg rounded-3"
                            placeholder="15.05.1990" maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">
                            <i class="fa-regular fa-id-card text-success"></i> Pasport
                        </label>
                        <input type="text" id="passportInp" class="form-control form-control-lg rounded-3"
                            placeholder="I-AS 123456">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">
                            <i class="fa-solid fa-car text-success"></i> Ulagyň Modeli
                        </label>
                        <input type="text" id="carModel" class="form-control form-control-lg rounded-3"
                            placeholder="Toyota Camry">
                    </div>

                    <button id="regBtn" onclick="registerPlate()" class="btn btn-success w-100 py-3 fw-bold rounded-3"
                        disabled>
                        <i class="fa-solid fa-check-circle"></i> HASABA ALMAK
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const ROUTES = {
            sendOtp: "{{ route('otp.send') }}",
            verifyOtp: "{{ route('otp.verify') }}",
            check: "{{ route('plate.check') }}",
            register: "{{ route('plate.register') }}",
        };
        const CSRF = "{{ csrf_token() }}";

        let timerInterval = null;
        let freeUsed = false;
        let currentRegionId = {{ $regions->first()->id ?? 1 }};
        let currentRegionCode = "{{ $regions->first()->code ?? 'AK' }}";

        function updateRegion() {
            const sel = document.getElementById('regionSel');
            const opt = sel.options[sel.selectedIndex];
            currentRegionId = sel.value;
            currentRegionCode = opt.dataset.code;
            document.getElementById('dispRegion').textContent = currentRegionCode;
            checkNumber();
        }

        async function sendOtp() {
            const phone = document.getElementById('phoneInp').value.trim();
            if (!phone) { Swal.fire('Üns!', 'Telefon belgiňizi giriziň!', 'warning'); return; }

            const res = await fetch(ROUTES.sendOtp, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ phone_number: phone })
            });
            const data = await res.json();

            if (data.success) {
                document.getElementById('otpSection').style.display = 'none';
                document.getElementById('codeSection').style.display = 'block';
                document.getElementById('codeDisplay').innerHTML =
                    `<i class="fa-solid fa-sms"></i> Siziň koduňyz: <strong class="fs-4">${data.code}</strong>`;
                startTimer(90);
            }
        }

        function startTimer(seconds) {
            clearInterval(timerInterval);
            let s = seconds;
            const el = document.getElementById('timer');
            timerInterval = setInterval(() => {
                const m = Math.floor(s / 60);
                const sec = s % 60;
                el.textContent = `${m}:${sec.toString().padStart(2, '0')}`;
                if (--s < 0) {
                    clearInterval(timerInterval);
                    el.textContent = '0:00';
                    Swal.fire('Möhlet geçdi!', 'Täzeden synanyşyň.', 'warning');
                    document.getElementById('codeSection').style.display = 'none';
                    document.getElementById('otpSection').style.display = 'block';
                }
            }, 1000);
        }

        async function verifyOtp() {
            const phone = document.getElementById('phoneInp').value.trim();
            const code = document.getElementById('codeInp').value.trim();

            const res = await fetch(ROUTES.verifyOtp, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ phone_number: phone, code: code })
            });
            const data = await res.json();

            if (data.success) {
                clearInterval(timerInterval);
                document.getElementById('codeSection').style.display = 'none';
                document.getElementById('plateSection').style.display = 'block';
                document.getElementById('ownerCard').style.display = 'block';
                Swal.fire({ icon: 'success', title: 'Tassyklandy!', timer: 1500, showConfirmButton: false });
            } else {
                Swal.fire('Ýalňyş!', data.message, 'error');
            }
        }

        async function checkNumber() {
            const val = document.getElementById('numberInp').value.replace(/\D/g, '');
            document.getElementById('numberInp').value = val;
            document.getElementById('dispNumber').textContent = val || '----';
            document.getElementById('priceDisplay').style.display = 'none';
            document.getElementById('errorText').style.display = 'none';
            document.getElementById('regBtn').disabled = true;

            if (val.length !== 4) return;

            const res = await fetch(ROUTES.check, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ number: val, region_id: currentRegionId })
            });
            const data = await res.json();

            if (!data.valid) {
                document.getElementById('errorText').textContent = data.message;
                document.getElementById('errorText').style.display = 'block';
                return;
            }

            const price = data.price === 0 ? 'MUGT' : data.price + ' TMT';
            const pd = document.getElementById('priceDisplay');
            pd.style.display = 'flex';
            pd.className = 'alert rounded-3 d-flex justify-content-between align-items-center';
            pd.innerHTML = `<span>${data.type}</span><strong class="fs-5">${price}</strong>`;
            document.getElementById('regBtn').disabled = false;
        }

        async function generateFree() {
            if (freeUsed) { Swal.fire('Mümkin däl!', 'Eýýäm mugt nomer aldyňyz!', 'warning'); return; }

            for (let i = 0; i < 100; i++) {
                const num = String(Math.floor(1000 + Math.random() * 9000));
                const res = await fetch(ROUTES.check, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                    body: JSON.stringify({ number: num, region_id: currentRegionId })
                });
                const data = await res.json();
                if (data.valid) {
                    document.getElementById('numberInp').value = num;
                    document.getElementById('dispNumber').textContent = num;
                    freeUsed = true;
                    document.getElementById('freeBtn').disabled = true;
                    await checkNumber();
                    Swal.fire({ icon: 'success', title: 'Mugt Nomer!', text: `Siziň nomeriňiz: ${num}`, timer: 2000, showConfirmButton: false });
                    return;
                }
            }
        }

        async function registerPlate() {
            const data = {
                number: document.getElementById('numberInp').value,
                region_id: currentRegionId,
                full_name: document.getElementById('ownerName').value,
                dob: document.getElementById('dobInp').value,
                passport: document.getElementById('passportInp').value,
                car_model: document.getElementById('carModel').value,
            };

            const res = await fetch(ROUTES.register, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify(data)
            });
            const result = await res.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Üstünlikli!',
                    text: result.message,
                    confirmButtonColor: '#2E7D32'
                }).then(() => location.reload());
            } else {
                Swal.fire('Ýalňyş!', result.message, 'error');
            }
        }

        document.getElementById('dobInp').addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 2) v = v.slice(0, 2) + '.' + v.slice(2);
            if (v.length > 5) v = v.slice(0, 5) + '.' + v.slice(5, 9);
            e.target.value = v;
        });
    </script>
@endpush