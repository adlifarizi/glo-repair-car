<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Bulanan</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="width: 60%; vertical-align: middle; padding: 10px 0;">
                <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Laporan Keuangan Bulanan</div>
                <div style="font-size: 18px; margin-bottom: 5px;">Laporan bulan {{ $bulan_tahun }}</div>
                <div style="font-size: 14px; margin-bottom: 5px;">Diunduh pada {{ $tanggal_unduh }}</div>
            </td>
            <td style="width: 40%; vertical-align: middle; text-align: right; padding: 10px 0;">
                <table style="border-collapse: collapse; display: inline-table;">
                    <tr>
                        <td style="vertical-align: middle; padding-right: 10px;">
                            <img src="{{ public_path('icons/ipaws.svg') }}"
                                style="width: 35px; height: 35px; filter: grayscale(100%); opacity: 0.7;" alt="iPaws">
                        </td>
                        <td style="vertical-align: middle; text-align: left;">
                            <div style="color: #c00000; font-weight: bold; font-size: 16px;">SIMBA</div>
                            <div style="font-size: 11px; line-height: 1.2; color: #666;">
                                Sistem Informasi Manajemen<br>Bengkel dan Administrasi
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <hr>

    <table style="width: 100%; margin-top: 40px; margin-bottom: 50px; border-collapse: collapse; font-family: Arial, sans-serif;">
        <thead>
            <tr>
                <th style="width: 30%; font-weight: bold; font-size: 20px; text-align: left; color: #B06222;">Tanggal</th>
                <th style="width: 35%; font-weight: bold; font-size: 20px; text-align: left; color: #B06222;">Pemasukan</th>
                <th style="width: 35%; font-weight: bold; font-size: 20px; text-align: left; color: #B06222;">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @php $currentDate = null; @endphp
            @foreach($transaksi as $index => $item)
                @if($currentDate != $item['tanggal'])
                    @if($currentDate != null && $index > 0)
                        <tr style="height: 20px;">
                            <td colspan="3"></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" style="color: #DE9254; font-weight: bold; padding-top: 20px;">{{ $item['tanggal'] }}</td>
                    </tr>
                    @php $currentDate = $item['tanggal']; @endphp
                @endif
                <tr>
                    <td style="padding-left: 20px; color: #666666;">{{ $item['keterangan'] }}</td>
                    <td style="color: #0F5700;">
                        @if(isset($item['jenis']) && $item['jenis'] == 'pemasukan')
                            Rp{{ number_format($item['nominal'], 0, ',', '.') }}
                        @endif
                    </td>
                    <td style="color: #8E1616;">
                        @if(isset($item['jenis']) && $item['jenis'] == 'pengeluaran')
                            Rp{{ number_format($item['nominal'], 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <div>
        <p style="margin-bottom: 15px; font-weight: bold;">Ringkasan Pemasukan-Pengeluaran</p>

        <table style="width: 100%; margin-left: 30px; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px 0; color: #666666; width: 40%;">Total Pemasukan</td>
                <td style="padding: 5px 0; color: #0F5700; font-weight: bold; text-align: left;">
                    Rp{{ number_format($total_pemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666666;">Total Pengeluaran</td>
                <td style="padding: 5px 0; color: #8E1616; font-weight: bold; text-align: left;">
                    Rp{{ number_format($total_pengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #666666;">Total Laba/Rugi bulan ini</td>
                <td style="padding: 5px 0; color: #0A40A4; font-weight: bold; text-align: left;">
                    +Rp{{ number_format($laba_rugi, 0, ',', '.') }}</td>
            </tr>
        </table>

        <p style="font-size: 12px; font-style: italic; color: #666666; margin-top: 10px;">*data dapat berubah seiring
            berjalannya waktu dan waktu unduh yang berbeda</p>
    </div>
</body>

</html>