<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Print - {{ $model->nomor }}</title>
</head>
<body style="font-size:12px;">
    @php 
        $bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    @endphp
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
			<td align="center" rowspan="2" width="30%">
				<img src="../public/assets/images/logo-baru.jpg"height="40"><br>
				<img src="../public/assets/images/logo-baru-tulisan.jpg" height="20">
			</td>
			<td align="center" rowspan="2" width="40%">
				<u>FORMULIR</u><br><br>
				<strong>PERMINTAAN TINDAKAN KOREKSI / PENCEGAHAN</strong>
			</td>
			<td width="40%">
				Nomor Dokumen:
			</td>
		</tr>
		<tr>
			<td align="center"><strong>F-SRU-QSE-010.R1</strong></td>
		</tr>		
	</table>

	<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr>
			<td width="10%">Kepada</td>
			<td width="40%">
				{{ $kepada->nama_departemen }}
			</td>
			<td width="20%">No Form PTKP</td>
			<td width="30%">{{ $model->nomor }}</td>
		</tr>
		<tr>
			<td>Dari</td>
			<td>
				{{ $dari->nama_departemen }}
			</td>
			<td>Tanggal</td>
			<td>{{ date('d', strtotime($model->created_at)) }} {{ $bulan[date('n',strtotime($model->created_at))] }} {{ date('Y', strtotime($model->created_at)) }}</td>
		</tr>

		<tr>
			<td colspan="3" bgcolor="cyan"><strong>Potensi/Jenis Ketidaksesuaian/Permasalahan :</strong></td>
			<td rowspan="2">
				<div>
					@if($model->kategori_1 == 2)
						<img src="../public/assets/images/kotak-centang.jpg" height="15">
					@elseif($model->kategori_1 == 1)
						<img src="../public/assets/images/kotak.jpg" height="15">
					@endif
					Management Review
				</div>
				<br>
				<div>
					@if($model->kategori_2 == 2)
						<img src="../public/assets/images/kotak-centang.jpg" height="15">
					@elseif($model->kategori_2 == 1)
						<img src="../public/assets/images/kotak.jpg" height="15">
					@endif
					Tindakan Koreksi
				</div>
				<br>
				<div>
					@if($model->kategori_3 == 2)
						<img src="../public/assets/images/kotak-centang.jpg" height="15">
					@elseif($model->kategori_3 == 1)
						<img src="../public/assets/images/kotak.jpg" height="15">
					@endif
					Tindakan Pencegahan
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				@php echo nl2br(htmlspecialchars($model->inti_masalah)); @endphp
			</td>
		</tr>
		<tr>
			<td colspan="4" bgcolor="cyan">
				<strong>Rincian Permasalahan : </strong>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				@php echo nl2br(htmlspecialchars($model->rincian_masalah)); @endphp
			</td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="cyan">
				<strong>Penyebab Permasalahan : </strong>
			</td>
			<td bgcolor="cyan">
				<strong>Signed PIC</strong>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				@php echo nl2br(htmlspecialchars($model->penyebab_masalah)); @endphp
				<br>&nbsp;
			</td>
			<td>
				
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" bgcolor="cyan">
				<strong>Tindakan Koreksi </strong>
			</td>
			<td colspan="2" align="center" bgcolor="cyan">
				<strong>Tindakan Pencegahan</strong>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				@php echo nl2br(htmlspecialchars($model->koreksi)); @endphp
			</td>
			<td colspan="2">
				@php echo nl2br(htmlspecialchars($model->pencegahan)); @endphp
			</td>
		</tr>
		<tr>
			<td colspan="2">
				Target Waktu Penyelesaian
			</td>
			<td colspan="2">
				{{ date('d', strtotime($model->tgl_target)) }} {{ $bulan[date('n',strtotime($model->tgl_target))] }} {{ date('Y', strtotime($model->tgl_target)) }}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				PIC Penyelesaian
			</td>
			<td colspan="2">
				{{ $pic->name }}
			</td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="cyan">
				<strong>Pembuktian/Verifikasi :</strong>
			</td>
			<td bgcolor="cyan">
				<strong>Tembusan kepada :</strong>
			</td>
		</tr>
		<tr>
			<td rowspan="2" colspan="3">
				@if($model->hasil_tindakan != null)
					{{ $model->hasil_tindakan }}
				@else 
					&nbsp;
				@endif
			</td>
			<td><br>&nbsp;<br>&nbsp;<br>&nbsp;</td>
		</tr>
		<tr>
			<td align="center"><strong>{{ $model->tembusan_1 }}</strong></td>
		</tr>
		<tr>
			<td colspan="2">
				Diverifikasi oleh &nbsp;&nbsp;&nbsp;:&nbsp; {{ $verifikator->name }}
			</td>
			<td rowspan="2">Paraf :</td>
			<td><br>&nbsp;<br>&nbsp;<br>&nbsp;</td>
		</tr>
		<tr>
			<td valign="center" colspan="2" >
				Tanggal Verifikasi:
				@if($model->tgl_verifikasi != null)
					{{ date('d', strtotime($model->tgl_verifikasi)) }} {{ $bulan[date('n',strtotime($model->tgl_verifikasi))] }} {{ date('Y', strtotime($model->tgl_verifikasi)) }}
				@else 
					&nbsp;
				@endif
			</td>
			<td align="center"><strong>{{ $model->tembusan_2 }}</strong></td>
		</tr>
		<tr>
			<td colspan="4">
				<strong>Catatan:</strong><br>
				@if($model->catatan != null)
					{{ $model->catatan }}
					<br>&nbsp;
				@else 
					<br>&nbsp;<br>&nbsp;<br>&nbsp;
				@endif
			</td>
		</tr>
	</table>
</body>
</html>
