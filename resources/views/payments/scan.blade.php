@extends('layouts.app')

@section('title', 'Scan QR Jimpitan')
@section('subtitle', 'Scan QR code di kotak jimpitan untuk mencatat pembayaran')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card" style="text-align: center;">
        <div id="reader" style="width: 100%; border-radius: 12px; overflow: hidden; background-color: #000; margin-bottom: 1.5rem;"></div>
        
        <div id="result-container" style="display: none; margin-bottom: 1.5rem; padding: 1.5rem; border-radius: 12px;">
            <div id="result-icon" style="font-size: 3rem; margin-bottom: 1rem;"></div>
            <h3 id="result-title" style="margin-bottom: 0.5rem; font-weight: 700;"></h3>
            <p id="result-message" style="color: #636E72;"></p>
            <button onclick="restartScanner()" class="btn btn-primary" style="margin-top: 1.5rem;">Scan Lagi</button>
        </div>

        <div id="scanner-instruction">
            <div style="width: 60px; height: 60px; background-color: var(--primary-very-light); color: var(--primary-dark); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                <i class="fas fa-qrcode"></i>
            </div>
            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Siap Men-scan</h3>
            <p style="color: #636E72;">Arahkan kamera ke QR Code yang ada pada kotak jimpitan.</p>
        </div>
    </div>
</div>

<audio id="success-sound" src="https://assets.mixkit.co/active_storage/sfx/2354/2354-preview.mp3" preload="auto"></audio>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode;
    const scannerId = "reader";
    const resultContainer = document.getElementById('result-container');
    const scannerInstruction = document.getElementById('scanner-instruction');
    const resultIcon = document.getElementById('result-icon');
    const resultTitle = document.getElementById('result-title');
    const resultMessage = document.getElementById('result-message');
    const successSound = document.getElementById('success-sound');

    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner segera setelah berhasil scan satu
        html5QrCode.stop().then(() => {
            processPayment(decodedText);
        });
    }

    function processPayment(token) {
        fetch("{{ route('payments.process') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ qr_token: token })
        })
        .then(response => response.json())
        .then(data => {
            scannerInstruction.style.display = 'none';
            resultContainer.style.display = 'block';

            if (data.prompt_status) {
                // Tampilkan opsi Bayar atau Belum
                resultContainer.style.backgroundColor = '#fdfdfc';
                resultContainer.style.border = '2px solid var(--primary-light)';
                
                let buttonsHtml = `
                    <div style="display: flex; gap: 10px; justify-content: center; margin-top: 1.5rem;">
                        <button onclick="submitStatus('${token}', 'paid')" class="btn btn-primary" style="flex: 1; background-color: var(--primary); border-color: var(--primary);">Sudah Bayar</button>
                        <button onclick="submitStatus('${token}', 'unpaid')" class="btn" style="flex: 1; background-color: #E74C3C; color: white; border-color: #E74C3C;">Belum/Kosong</button>
                    </div>
                    <button onclick="restartScanner()" class="btn" style="margin-top: 1rem; width: 100%; background: #eee; color: #333; justify-content: center;">Batal & Scan Lagi</button>
                `;
                
                let iconHtml = `
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.2rem; box-shadow: 0 10px 25px -5px rgba(16,185,129,0.4); border: 4px solid white;">
                        <i class="fas fa-home"></i>
                    </div>
                `;
                
                resultContainer.innerHTML = `
                    ${iconHtml}
                    <h3 id="result-title" style="margin-bottom: 0.5rem; font-weight: 800; font-size: 1.5rem; color: var(--text-main);">${data.house.owner_name} <span style="color: var(--text-muted); font-size: 1.1rem; font-weight: 600;">(No. ${data.house.house_number})</span></h3>
                    <p id="result-message" style="color: #636E72; font-size: 1.05rem; margin-bottom: 1rem;">Apakah kotak jimpitan rumah ini terisi?</p>
                    ${buttonsHtml}
                `;
            } else if (data.success) {
                successSound.play();
                resultContainer.style.backgroundColor = 'var(--primary-very-light)';
                resultContainer.style.border = '2px solid var(--primary-pastel)';
                resultContainer.innerHTML = `
                    <div id="result-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.2rem; box-shadow: 0 10px 25px -5px rgba(16,185,129,0.4); border: 4px solid white;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3 id="result-title" style="margin-bottom: 0.5rem; font-weight: 700;">Berhasil!</h3>
                    <p id="result-message" style="color: #636E72;">${data.message}</p>
                    <button onclick="restartScanner()" class="btn btn-primary" style="margin-top: 1.5rem;">Scan Lagi</button>
                `;
            } else {
                resultContainer.style.backgroundColor = '#FDEDEC';
                resultContainer.style.border = '2px solid #F5B7B1';
                resultContainer.innerHTML = `
                    <div id="result-icon" style="font-size: 3rem; margin-bottom: 1rem; color: #C0392B;">${data.already_paid ? 'ℹ️' : '❌'}</div>
                    <h3 id="result-title" style="margin-bottom: 0.5rem; font-weight: 700;">${data.already_paid ? 'Sudah Bayar' : 'Gagal'}</h3>
                    <p id="result-message" style="color: #636E72;">${data.message}</p>
                    <button onclick="restartScanner()" class="btn btn-primary" style="margin-top: 1.5rem;">Scan Lagi</button>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem.');
            restartScanner();
        });
    }

    function submitStatus(token, status) {
        // Tampilkan loading state
        resultContainer.innerHTML = `<div style="padding: 2rem;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary);"></i><p style="margin-top: 1rem;">Memproses...</p></div>`;
        
        fetch("{{ route('payments.process') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ qr_token: token, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successSound.play();
                resultContainer.style.backgroundColor = 'var(--primary-very-light)';
                resultContainer.style.border = '2px solid var(--primary-pastel)';
                resultContainer.innerHTML = `
                    <div id="result-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.2rem; box-shadow: 0 10px 25px -5px rgba(16,185,129,0.4); border: 4px solid white;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3 id="result-title" style="margin-bottom: 0.5rem; font-weight: 700;">Berhasil!</h3>
                    <p id="result-message" style="color: #636E72;">${data.message}</p>
                    <button onclick="restartScanner()" class="btn btn-primary" style="margin-top: 1.5rem;">Scan Lagi</button>
                `;
            } else {
                resultContainer.style.backgroundColor = '#FDEDEC';
                resultContainer.style.border = '2px solid #F5B7B1';
                resultContainer.innerHTML = `
                    <div id="result-icon" style="font-size: 3rem; margin-bottom: 1rem; color: #C0392B;">${data.already_paid ? 'ℹ️' : '❌'}</div>
                    <h3 id="result-title" style="margin-bottom: 0.5rem; font-weight: 700;">${data.already_paid ? 'Sudah Bayar' : 'Gagal'}</h3>
                    <p id="result-message" style="color: #636E72;">${data.message}</p>
                    <button onclick="restartScanner()" class="btn btn-primary" style="margin-top: 1.5rem;">Scan Lagi</button>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem.');
            restartScanner();
        });
    }

    function startScanner() {
        html5QrCode = new Html5Qrcode(scannerId);
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch(err => {
            console.error(err);
            alert("Gagal mengakses kamera. Pastikan izin kamera diberikan.");
        });
    }

    function restartScanner() {
        resultContainer.style.display = 'none';
        scannerInstruction.style.display = 'block';
        startScanner();
    }

    document.addEventListener('DOMContentLoaded', startScanner);
</script>
@endpush
