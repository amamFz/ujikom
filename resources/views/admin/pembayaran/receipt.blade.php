<!DOCTYPE html>
<html>

<head>
  <title>Struk Pembayaran</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      font-size: 12px;
      line-height: 1.6;
      color: #333;
      margin: 0;
      padding: 20px;
    }

    .receipt {
      max-width: 80mm;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #eee;
      padding-bottom: 20px;
    }

    .header h2 {
      margin: 0;
      color: #2563eb;
      font-size: 16px;
      font-weight: bold;
    }

    .header p {
      margin: 5px 0;
      color: #666;
      font-size: 11px;
    }

    .customer-info,
    .usage-info {
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 11px;
      text-transform: uppercase;
      color: #666;
      margin-bottom: 10px;
      border-bottom: 1px dashed #eee;
      padding-bottom: 5px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 120px 1fr;
      gap: 8px;
      margin-bottom: 5px;
      font-size: 11px;
    }

    .info-label {
      color: #666;
    }

    .info-value {
      font-weight: 500;
      text-align: right;
    }

    .costs {
      margin: 20px 0;
      border-top: 1px dashed #eee;
      border-bottom: 1px dashed #eee;
      padding: 15px 0;
    }

    .total-section {
      margin: 20px 0;
      padding: 15px 0;
      border-top: 2px solid #2563eb;
      border-bottom: 2px solid #2563eb;
    }

    .total-row {
      font-size: 14px;
      font-weight: bold;
      color: #2563eb;
    }

    .footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px dashed #eee;
      color: #666;
      font-size: 10px;
    }

    .payment-status {
      text-align: center;
      margin: 20px 0;
      padding: 8px;
      background-color: #dcfce7;
      color: #166534;
      border-radius: 4px;
      font-weight: bold;
      font-size: 14px;
    }

    .qr-section {
      text-align: center;
      margin: 20px 0;
    }

    .bill-details {
      margin: 15px 0;
      padding: 10px 0;
      border-top: 1px dashed #eee;
    }

    .bill-item {
      padding: 8px 0;
      border-bottom: 1px dashed #eee;
    }

    .bill-item:last-child {
      border-bottom: none;
    }

    .bill-period {
      font-weight: 500;
      color: #1e40af;
      font-size: 11px;
      margin-bottom: 5px;
    }

    .subtotal-row {
      font-size: 12px;
      color: #666;
      margin-top: 5px;
      text-align: right;
    }

    .previous-bills {
      margin: 15px 0;
      padding: 10px;
      background-color: #fef2f2;
      border: 1px dashed #fee2e2;
      border-radius: 4px;
    }

    .previous-bills-title {
      color: #991b1b;
      font-size: 11px;
      font-weight: bold;
      margin-bottom: 10px;
      text-transform: uppercase;
    }

    .grand-total {
      margin: 20px 0;
      padding: 15px 0;
      border-top: 2px solid #2563eb;
      border-bottom: 2px solid #2563eb;
      font-size: 14px;
      font-weight: bold;
      color: #1e40af;
    }
  </style>
</head>

<body>
  <div class="receipt">
    <div class="header">
      <h2>STRUK PEMBAYARAN LISTRIK</h2>
      <p>{{ now()->format('d F Y - H:i') }}</p>
    </div>

    <div class="customer-info">
      <div class="section-title">Informasi Pelanggan</div>
      <div class="info-grid">
        <span class="info-label">No. Kontrol</span>
        <span class="info-value">{{ $no_kontrol }}</span>
      </div>
      <div class="info-grid">
        <span class="info-label">Nama</span>
        <span class="info-value">{{ $nama_pelanggan }}</span>
      </div>
    </div>

    <!-- Current Month Bill -->
    <div class="bill-details">
      <div class="section-title">Tagihan Bulan Ini</div>
      <div class="bill-item">
        <div class="bill-period">{{ $current_payment['bulan'] }} {{ $current_payment['tahun'] }}</div>
        <div class="info-grid">
          <span class="info-label">Meter Awal</span>
          <span class="info-value">{{ $current_payment['meter_awal'] }}</span>
        </div>
        <div class="info-grid">
          <span class="info-label">Meter Akhir</span>
          <span class="info-value">{{ $current_payment['meter_akhir'] }}</span>
        </div>
        <div class="info-grid">
          <span class="info-label">Total Pemakaian</span>
          <span class="info-value">{{ $current_payment['jumlah_pakai'] }} kWh</span>
        </div>
        <div class="info-grid">
          <span class="info-label">Biaya Beban</span>
          <span class="info-value">Rp {{ $current_payment['biaya_beban'] }}</span>
        </div>
        <div class="info-grid">
          <span class="info-label">Biaya Pemakaian</span>
          <span class="info-value">Rp {{ $current_payment['biaya_pemakaian'] }}</span>
        </div>
        <div class="subtotal-row">
          Subtotal: Rp {{ $current_payment['total_bayar'] }}
        </div>
      </div>
    </div>

    <!-- Previous Unpaid Bills -->
    @if (isset($previous_bills) && count($previous_bills) > 0)
      <div class="previous-bills">
        <div class="previous-bills-title">Pembayaran Tunggakan</div>
        @foreach ($previous_bills as $bill)
          <div class="bill-item">
            <div class="bill-period">{{ $bill['periode'] }}</div>
            <div class="info-grid">
              <span class="info-label">Total Pemakaian</span>
              <span class="info-value">{{ $bill['jumlah_pakai'] }} kWh</span>
            </div>
            <div class="subtotal-row">
              Subtotal: Rp {{ $bill['total'] }}
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <!-- Grand Total -->
    <div class="grand-total">
      <div class="info-grid">
        <span class="info-label">Total Pembayaran</span>
        <span class="info-value">Rp {{ $total_pembayaran }}</span>
      </div>
    </div>

    <div class="payment-status">
      LUNAS
    </div>

    <div class="footer">
      <p>Terima kasih atas pembayaran Anda</p>
      <p>Simpan struk ini sebagai bukti pembayaran yang sah</p>
      <p>{{ now()->format('Y-m-d H:i:s') }}</p>
      <p>Petugas: {{ Auth::user()->name }}</p>
    </div>
  </div>
</body>

</html>
