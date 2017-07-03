@extends('master')

@section('style')
	<!-- Datatables -->
	<link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <style type="text/css">
    	table{
    		border-collapse: collapse;
    	}
    	table tr td{
    		border: 1px solid gray;
    		padding: 5px;
    	}
    </style>
@stop

@section('content')
	<div class="row">
		@if(session('role')=='intern')
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Form Pengumuman</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form id="form-pengumuman" method="post" data-parsley-validate action="" enctype="multipart/form-data">
						<label>Judul Pengumuman <small>*</small></label>
						<input id="judul-pengumuman" type="text" required class="form-control" name="judul">
						<br>
						<label>Tanggal Pengumuman <small>*</small></label>
						<input id="tanggal-pengumuman" type="text" required class="form-control" name="tanggal">
						<br>
						<textarea required id="isi-pengumuman" name="isi">Posting Pengumuman di sini</textarea>	
						<div class="row" style="margin-top: 5px;">
							<div class="col-md-12">
								<button class="btn btn-primary btn-flat pull-right" type="submit" id="btn-submit-pengumuman">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>List Pengumuman</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="tabel-data-pengumuman" class="table datatable table-striped table-bordered">
						<thead>
							<tr>
								<th>Judul</th>
								<th>Tanggal Start</th>
								<th>Tanggal Selesai</th>
								<th style="width: 99px;"></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		@else
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Pengumuman</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					@foreach($list_pengumuman as $pengumuman)
					<div class="row">
						<div class="col-md-12">
							<p class="lead">{{$pengumuman->judul}}</p>
							<p>{!!$pengumuman->isi!!}</p>
						</div>
					</div>
					<hr>
					@endforeach
				</div>
			</div>
		</div>
		@endif
	</div>
@stop

@section('scripts')
	<!-- Datatables -->
	<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	<script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script src="/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<script src="/vendors/jszip/dist/jszip.min.js"></script>
	<script src="/vendors/pdfmake/build/pdfmake.min.js"></script>
	<script src="/vendors/pdfmake/build/vfs_fonts.js"></script>
	<script type="text/javascript" src="/vendors/tinymce/tinymce.min.js"></script>
	<script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript">
		tinymce.init({ 
			selector:'textarea',
			height: 300,
			theme: 'modern',
			plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
			],
			toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
			image_advtab: true,
			templates: [
			{ title: 'Test template 1', content: 'Test 1' },
			{ title: 'Test template 2', content: 'Test 2' }
			],
			content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
			]
		});
		@if(session('role')=='intern')
		var table = $("#tabel-data-pengumuman").DataTable({
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('intern.pengumuman_data')}}",
            info:false,
            "language": {
                "lengthMenu": "_MENU_",
                "zeroRecords": "Maaf data tidak ditemukan",
                "info": "_PAGE_ dari _PAGES_",
                "infoEmpty": "Data Tidak Ditemukan",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Cari "
            },
            "columnDefs": [
                {
                  "targets": 0,
                  "render": function(data, type, row, meta){
                      return row.judul;
                  }
                },
                {
                  "orderable":false,
                  "targets": 1,
                  "render": function(data, type, row, meta){
                      return row.start_pengumuman;
                  }
                },
                {
                  "orderable":false,
                  "targets": 2,
                  "render": function(data, type, row, meta){
                    return row.stop_pengumuman;
                  }
                },
                {
                  "orderable":false,
                  "targets": 3,
                  "render": function(data, type, row, meta){
                    return "<div class='btn-group'><button class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></button><button class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></div>";
                  }
                }
            ],
            "aaSorting": [ [0,'asc'] ]
      	});
		@endif
		$("#form-pengumuman").submit(function(e){
			e.preventDefault();
			var c = confirm("Apakah anda yakin pengumuman ini sudah benar ? Silahkan cek ulang jika masih perlu perbaikan");
			if(c===true){
				$("#btn-submit-pengumuman").prop('disabled',true);
				var judul = $("#judul-pengumuman").val().trim();
				var isi = tinyMCE.get('isi-pengumuman').getContent();
				var tanggal = $("#tanggal-pengumuman").val().trim();
				$.ajax({
					url:"{{route('intern.pengumuman')}}",
					method:"POST",
					data:{judul:judul,isi:isi,tanggal:tanggal},
					success:function(res){
						$("input").val('');
						tinyMCE.get('isi-pengumuman').setContent('');
						$("#btn-submit-pengumuman").prop('disabled',false);
						table.ajax.reload();
					}
				});
			}
		});
		$('#tanggal-pengumuman').daterangepicker({
			timePicker: true,
			timePickerIncrement: 10,
			locale: {
				format: 'YYYY-MM-DD HH:mm'
			},
			timePicker24Hour:true
		});
		$('#tanggal-pengumuman').val('');
	</script>
@stop