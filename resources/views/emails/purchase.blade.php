@extends('beautymail::templates.widgets')

<style>

#biodata {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#biodata td, #biodata th {
	font-size:12px;
    border: 1px solid #ddd;
    padding: 8px;
}

#biodata tr:nth-child(even){background-color: #f2f2f2;}

#biodata tr:hover {background-color: #ddd;}

#biodata th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>

@section('content')
	<div style="display:flex;justify-content:center;margin-top:-25px;margin-bottom: 50px;">
		<!-- <img src="{{url('/images/logo-590.png')}}" alt="Logo"/> -->
		<img src="https://lh4.googleusercontent.com/FMu9SgdQW5VxxbhXYYA38tJ-4j8phaLXLLuJnTBjtaVbd_TTVGwMwVFHfRSY30Tp1Rfnj9quABCPsOQKAwA2=w1366-h647" alt="">
	</div>

    <!-- @include('beautymail::templates.widgets.articleStart', ['color' => '#0000FF']) -->
	@include('beautymail::templates.widgets.articleStart')
		<h2 style="font-family: calibri;" class="secondary"><strong>Data Pembayaran</strong></h2>

		<h4 class="primary"><strong>Hi, Dear Gamer</strong></h4>
		<p style="font-family:arial; font-size:14px">Terimakasih sudah bergabung di <i>Game Pesanbungkus</i>, informasi ini adalah pemberitahuan tentang transaksi pada pembelian Cash & Coin: </p>

		<table id="biodata">
		<!-- <tr>
			<th width='50%'>Company</th>
			<th>Contact</th>
		</tr> -->
		<tr>
			<td width='30%'>Kode</td>
			<td>{{ $user->code_user }}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>{{ $user->email }}</td>
		</tr>
		<tr>
			<td>Sandi</td>
			<td>{{ $user->plain }}</td>
		</tr>
		<tr>
			<td>Telpon</td>
			<td>{{ $user->phone }}</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>{{ $user->address }}</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>{{ $user->status }}</td>
		</tr>
		</table>
		
		<br>
		<p style="font-family:arial; font-size:14px">Selesaikan banyak misi di <i>Game Pesanbungkus</i> untuk mendapatkan PB-Pay dan berbagai Bonus menarik.</p> 
		
		<p>Game ini disponsori oleh <b>Pesanbungkus - Satu Aplikasi Berbagai Kebutuhan</b></p>
		
		<h4 class="primary">Terimakasih</h4>

	@include('beautymail::templates.widgets.articleEnd')




<!-- 
	@include('beautymail::templates.widgets.newfeatureStart')

		<h4 class="secondary"><strong>Hello World again</strong></h4>
		<p>This is another test</p>

	@include('beautymail::templates.widgets.newfeatureEnd') -->

@stop
