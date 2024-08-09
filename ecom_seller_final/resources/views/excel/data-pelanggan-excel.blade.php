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
                        <td style="font-weight: 600;" width="10%">TIPE CUSTOMER</td>
                        <td style="font-weight: 600;" width="10%">NAMA</td>
                        <td style="font-weight: 600;" width="10%">NO TELEPON</td>
                        <td style="font-weight: 600;" width="10%">EMAIL</td>
                        <td style="font-weight: 600;" width="10%">ALAMAT</td>
                        <td style="font-weight: 600;" width="10%">POIN</td>
                        <td style="font-weight: 600;" width="10%">IS ACTIVE</td>
                        <td style="font-weight: 600;" width="10%">TANGGAL LAHIR</td>
                        <td style="font-weight: 600;" width="10%">AGAMA</td>
                        <td style="font-weight: 600;" width="10%">NPWP</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->tipe_customer->customer }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ (string) $item->no_telepon }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->poin }}</td>
                            <td>{{ $item->is_active }}</td>
                            <td>{{ $item->tanggal_lahir }}</td>
                            <td>{{ $item->agama }}</td>
                            <td>{{ $item->npwp }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
		</div>
	</body>
</html>
