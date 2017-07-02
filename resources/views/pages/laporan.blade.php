@extends('master')

@section('style')
  <!-- Datatables -->
  <link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
@stop

@section('content')
  @if(session('role')!='intern')
      <div class="x_panel">
          <div class="x_title">
              <h2>Form Keluhan</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <form id="form-keluhan" method="post" data-parsley-validate action="" enctype="multipart/form-data">
                  <input type="hidden" name="_token" class="csrf_token" value="{{csrf_token()}}">
                  <div class="row">
                      <div class="col-md-6">
                          <label>NIP Pelapor :</label>
                          <input type="text" id="input-nip" class="form-control input-lg" style="height: 38px;" name="nip_pelapor" data-parsley-trigger="change" required placeholder="NIP anda"/>
                      </div>
                      <div class="col-md-6">
                          <label for="input-jenis-laporan">Jenis :</label><br/>
                          <select name="jenis_laporan" id="input-jenis-laporan" class="select2 form-control" style="width: 100%;">
                              @foreach($list_jenis_laporan as $jenis_laporan)
                                  <option value="{{$jenis_laporan->id}}">{{$jenis_laporan->kode}} | {{$jenis_laporan->deskripsi}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <label for="input-jenis-laporan">Deskripsi :</label><br/>
                          <textarea name="deskripsi" id="input-deskripsi" cols="30" rows="5" class="form-control" placeholder="Deskripsi keluhan. Contoh : Koneksi lambat" required></textarea>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <label>Gambar(Jika ada) :</label>
                          <input accept="image/*" type="file" id="input-gambar" class="form-control" name="gambar"/>
                      </div>
                      <div class="col-md-6">
                          <label>Lokasi :</label>
                          <input type="text" id="input-lokasi" class="form-control" name="lokasi" placeholder="Tambahkan lokasi jika diperlukan"/>
                      </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-md-12">
                          <button class="btn btn-primary pull-right" id="btn-submit-laporan">Submit</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  @else
    @if(!is_null($list_mayor_keluhan))
      <div class="row tile_count">
        @foreach($list_mayor_keluhan as $mayor_keluhan)
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-question-circle"></i> Keluhan <a>{{$mayor_keluhan->kode}}</a></span>
              <div class="count">{{$mayor_keluhan->listLaporan->count()}}</div>
              <span class="count_bottom"><i class="green">{{$mayor_keluhan->listLaporan->count()/$total_keluhan*100}}% </i> Dari {{$total_keluhan}} keluhan</span>
          </div>
        @endforeach
      </div>
    @endif
    <div id="dugaan-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Dugaan</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="id-laporan-dugaan" class="form-control">
            <div class="row">
              <div class="col-md-12">
                <textarea id="dugaan-input" rows="5" class="form-control"></textarea>
                <button type="button" id="btn-submit-dugaan" style="margin-top: 5px;" class="btn btn-primary pull-right">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="x_panel">
      <div class="x_title">
          <h2>Daftar Keluhan </h2>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
          <div class="row" style="display: none;">
              <div class="col-md-12">
                  <button type="button" class="btn btn-primary pull-right" id="btn-reload">Reload</button>
              </div>
          </div>
          <table id="tabel-keluhan" class="table datatable table-striped table-bordered">
              <thead>
              <tr>
                  <th>NIP</th>
                  <th>Data Laporan</th>
                  <th>Diagnosa</th>
                  <th>Aksi</th>
                  <th>Status</th>
              </tr>
              </thead>
          </table>
      </div>
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
  <script>
      var table = $("#tabel-keluhan").DataTable({
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('data_laporan')}}",
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
                      return row.nip_pelapor;
                  }
                },
                {
                  "orderable":false,
                  "targets": 1,
                  "render": function(data, type, row, meta){
                      var show = "";
                      if (row.gambar!=null) {
                        show += "<img class='img-thumbnail' onclick='previewImage(\""+row.gambar+"\")' src='/laporan/img/"+row.gambar+"' style='width:300px;border:1px solid #b7b6b6;'/><br>";
                      }
                      show+="<strong>Jenis :</strong> "+row.jenis_laporan_info.kode+"<br/>";
                      show+="<strong>Deskripsi :</strong>"+row.deskripsi;
                      if (row.lokasi!="") {
                        show+="<br/><strong>Lokasi : </strong>"+row.lokasi;
                      }
                      show+="<br/><strong>Waktu : </strong>"+row.waktu_melapor;
                      return show;
                  }
                },
                {
                  "orderable":false,
                  "targets": 2,
                  "render": function(data, type, row, meta){
                    @if(session('role')=='intern')
                      if(row.dugaan==null)
                        return "<button onclick='openDugaanModal("+row.id+",\""+row.jenis_laporan_info.kode+"\")' class='btn btn-primary btn-sm'>Isikan Dugaan</button>";
                      else
                        return row.dugaan;
                    @else
                      if(row.dugaan==null)
                        return "<strong style='color:red;'>Belum terdiagnosa</strong>";
                      else
                        return row.dugaan;
                    @endif
                  }
                },
                {
                  "orderable":false,
                  "targets": 3,
                  "render": function(data, type, row, meta){
                    @if(session('role')=='intern')
                      if(row.dugaan!=null && row.aksi==null)
                        return "<button class='btn btn-primary btn-sm'>Isikan Aksi</button>";
                      else if(row.dugaan!=null && row.aksi!=null)
                        return row.aksi;
                      else if(row.dugaan==null)
                        return "<strong style='color:red;'>Belum ada aksi</strong>";
                    @else
                      if(row.aksi==null)
                        return "<strong style='color:red;'>Belum ada aksi</strong>";
                      else
                        return row.aksi;
                    @endif
                  }
                },
                {
                  "orderable":false,
                  "targets": 4,
                  "render": function(data, type, row, meta){
                    return "<strong style='color:red;'>"+row.status+"</strong>";
                  }
                }
            ],
            "aaSorting": [ [0,'asc'] ]
      });
      @if(session('role')!=='intern')
      $("#form-keluhan").submit(function(e){
          e.preventDefault();
          $("#btn-submit-laporan").prop('disabled',true);
          $(this).ajaxSubmit({
              success:function(res){
                  $("#btn-submit-laporan").prop('disabled',false);
                  $("input").val('');
                  $("textarea").val('');
                  $("input[name='_token']").val(res.token);
                  $("#btn-reload").click();
              }
          });
      });
      @endif
      @if(session('role')=='intern')
        function openDugaanModal(id,kode) {
          $("#id-laporan-dugaan").val(id);
          $("#dugaan-input").text("");
          $("#dugaan-input").attr("placeholder","Isikan dugaan untuk laporan "+kode);
          $("#dugaan-modal").modal('show');
        }
        $("#btn-submit-dugaan").click(function(){
          var dugaan = $("#dugaan-input").val().trim();
          var id = $("#id-laporan-dugaan").val();
          var btn = $(this);
          btn.prop("disabled",true);
          if (dugaan!="") {
            $.ajax({
              url:"{{route('dugaan')}}",
              method:"POST",
              data:{dugaan:dugaan,id:id},
              success:function(res){
                btn.prop("disabled",false);
                console.log(res);
              }
            });
          }else{
            alert("Dugaan/diagnosa wajib diisi");
          }
        });
      @endif
      $("#btn-reload").on('click',function(){
        table.ajax.reload();
      });
  </script>
@stop