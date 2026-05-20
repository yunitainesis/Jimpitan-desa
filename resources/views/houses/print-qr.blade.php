<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Jimpitan - {{ $house->house_number }}</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            text-align: center;
            padding: 50px;
        }
        .sticker {
            width: 300px;
            border: 2px dashed var(--primary-pastel);
            padding: 20px;
            display: inline-block;
            border-radius: 20px;
            background-color: #F9FBF9;
        }
        .qr-code { margin: 20px 0; }
        .house-info { font-weight: bold; font-size: 1.5rem; }
        .footer { font-size: 0.8rem; color: #636E72; margin-top: 10px; }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="sticker">
        <div style="font-size: 1.2rem; color: #2E7D32; font-weight: 700;">JIMPITAN ONLINE</div>
        <div class="qr-code">
            {!! QrCode::size(200)->generate($house->qr_token) !!}
        </div>
        <div class="house-info">{{ $house->house_number }}</div>
        <div style="font-size: 1rem;">{{ $house->owner_name }}</div>
        <div class="footer">Scan QR ini untuk setor jimpitan</div>
    </div>
    
    <div style="margin-top: 30px;" class="btn-print">
        <button onclick="window.print()" style="padding: 10px 20px; background: #A8D5BA; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; margin-right: 10px;">Cetak Stiker</button>
        <a href="{{ route('houses.download-qr', $house->id) }}" style="padding: 10px 20px; background: #81C784; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; text-decoration: none; color: black;">Save QR</a>
    </div>
</body>
</html>
