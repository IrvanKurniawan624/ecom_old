<html>
	<head>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<style>
			@page {
				margin: 8px 40px;
			}
	
			* {
				font-family: Arial, Helvetica, sans-serif;
			}
			
			body{
				/* background-image: url("{{ asset('assets/img/project/background.png') }}");
				background-position: center;
				background-repeat: no-repeat;
				background-size: 50%; */
				width:100%;
				height:100%;
				padding: 10px 0px 10px 0px;
				margin:0;
			}
	
			p, label {
				font-size: 12px;
			}
	
			.table{
				font-size: 12px;
				text-align: justify;
			}
	
			.table th{
				padding: 2px 0px 2px 0px;
				line-height: 1.5;
				font-size: 12px;
			}
	
			.table td{
				padding: 1px 4px;
				line-height: 1.5;
				font-size: 12px;
			}
	
			.footer{
				position: absolute;
				bottom: 8px;
			}
	
			.next-page {
				page-break-before: always;
			}
		</style>
		<script type="text/javascript">
			setTimeout(function () {  
				tableToExcel('tb','file-excel');
			}, 1000);

			var tableToExcel = (function() {
				var uri = 'data:application/vnd.ms-excel;base64,'
					, template = `<html
									xmlns:o="urn:schemas-microsoft-com:office:office"
									xmlns:x="urn:schemas-microsoft-com:office:excel"
									xmlns="http://www.w3.org/TR/REC-html40">
									<head>
										<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
									</head>
									<body>
										<table>{table}</table>
									</body>
								</html>`
					, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
					, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
				return function(table, name) {
					if (!table.nodeType) table = document.getElementById(table)
					var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
					// window.location.href = uri + base64(format(template, ctx))
					// var downloadName = prompt("write some explanation", "table");
					downloadName = "export-master-produk";
					var link = document.createElement("a");
					link.download = downloadName + ".xls";
					link.href = uri + base64(format(template, ctx));
					link.click();
				}
			})() 
				
		</script>
	
	</head>

	<body>
		<div id="tb">
            <table class="table" width="100%" border="1" bordercolor="#0a9447" style="border-collapse: collapse;" cellpadding="2">
                <thead>
					<tr>
						<td style="font-weight: 600;" width="10%">KATA KUNCI</td>
                        <td style="font-weight: 600;" width="10%">NAMA PRODUK</td>
						<td style="font-weight: 600;" width="10%">STOCK</td>
                        <td style="font-weight: 600;" width="10%">KATEGORI</td>
                        <td style="font-weight: 600;" width="10%">SUBKATEGORI</td>
                        <td style="font-weight: 600;" width="10%">URL VIDEO</td>
                        <td style="font-weight: 600;" width="10%">SATUAN</td>
                        <td style="font-weight: 600;" width="10%">MINIMAL ORDER</td>
                        <td style="font-weight: 600;" width="10%">DISKON</td>
                        <td style="font-weight: 600;" width="10%">BERAT</td>
                        <td style="font-weight: 600;" width="10%">HARGA BELI</td>
                        <td style="font-weight: 600;" width="10%">HARGA JUAL B2C</td>
                        <td style="font-weight: 600;" width="10%">HARGA JUAL B2B</td>
                        <td style="font-weight: 600;" width="10%">STOCK</td>
                        <td style="font-weight: 600;" width="10%">READY STOCK</td>
                        <td style="font-weight: 600;" width="10%">HARGA GROSIR</td>
                        <td style="font-weight: 600;" width="10%">PROPERTIES</td>
                        <td style="font-weight: 600;" width="10%">STATUS PUBLISH</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
						@php
							$harga_grosir = '';
							$properties = '';
						@endphp

						@if (isset($item->master_produk_harga_grosir))
							@foreach ($item->master_produk_harga_grosir as $item2)
								@php
									$harga_grosir .= $item2->tipe ."_". $item2->minimal_pembelian . "_" . $item2->harga . ";";
								@endphp
							@endforeach	
						@endif
						
						@if (isset($item->master_produk_properties))
							@foreach ($item->master_produk_properties as $item3)
								@php
									$properties .= $item3->master_properties->properties ."_". $item3->value . ";";
								@endphp
							@endforeach
						@endif

                        <tr>
                            <td>{{ $item->kata_kunci }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->master_kategori->kategori ?? '' }}</td>
                            <td>{{ $item->master_subkategori->subkategori ?? '' }}</td>
                            <td>{{ $item->url_video }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->minimal_order }}</td>
                            <td>{{ $item->diskon }}</td>
                            <td>{{ $item->berat }}</td>
                            <td>{{ $item->harga_beli }}</td>
                            <td>{{ $item->harga_jual_b2c }}</td>
                            <td>{{ $item->harga_jual_b2b }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->is_ready_stock }}</td>
                            <td>{{ $harga_grosir }}</td>
                            <td>{{ $properties }}</td>
                            <td>{{ $item->is_publish }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
		</div>
	</body>
</html>
