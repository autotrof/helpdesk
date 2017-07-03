@extends('master')

@section('style')
    
@stop

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Grafik Data Keluhan/Laporan</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div id="mainb" style="height:450px;"></div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<!-- ECharts -->
    <script src="/vendors/echarts/dist/echarts.min.js"></script>
	<script type="text/javascript">
		if ($('#mainb').length ){
			var theme = {
			  color: [
				  '#26B99A', '#3949AB', '#e53935', '#546E7A',
				  '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
			  ],
			  title: {
				  itemGap: 8,
				  textStyle: {
					  fontWeight: 'normal',
					  color: '#408829'
				  }
			  },

			  dataRange: {
				  color: ['#1f610a', '#97b58d']
			  },

			  toolbox: {
				  color: ['#408829', '#408829', '#408829', '#408829']
			  },

			  tooltip: {
				  backgroundColor: 'rgba(0,0,0,0.5)',
				  axisPointer: {
					  type: 'line',
					  lineStyle: {
						  color: '#408829',
						  type: 'dashed'
					  },
					  crossStyle: {
						  color: '#408829'
					  },
					  shadowStyle: {
						  color: 'rgba(200,200,200,0.3)'
					  }
				  }
			  },

			  dataZoom: {
				  dataBackgroundColor: '#eee',
				  fillerColor: 'rgba(64,136,41,0.2)',
				  handleColor: '#408829'
			  },
			  grid: {
				  borderWidth: 0
			  },

			  categoryAxis: {
				  axisLine: {
					  lineStyle: {
						  color: '#408829'
					  }
				  },
				  splitLine: {
					  lineStyle: {
						  color: ['#eee']
					  }
				  }
			  },

			  valueAxis: {
				  axisLine: {
					  lineStyle: {
						  color: '#408829'
					  }
				  },
				  splitArea: {
					  show: true,
					  areaStyle: {
						  color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
					  }
				  },
				  splitLine: {
					  lineStyle: {
						  color: ['#eee']
					  }
				  }
			  },
			  timeline: {
				  lineStyle: {
					  color: '#408829'
				  },
				  controlStyle: {
					  normal: {color: '#408829'},
					  emphasis: {color: '#408829'}
				  }
			  },

			  k: {
				  itemStyle: {
					  normal: {
						  color: '#68a54a',
						  color0: '#a9cba2',
						  lineStyle: {
							  width: 1,
							  color: '#408829',
							  color0: '#86b379'
						  }
					  }
				  }
			  },
			  textStyle: {
				  fontFamily: 'Arial, Verdana, sans-serif'
			  }
		  	};
		  var echartBar = echarts.init(document.getElementById('mainb'), theme);
		  echartBar.setOption({
			title: {
			  text: 'Data Perbandingan',
			  subtext: 'Jumlah keluhan terbanyak & paling banyak terselesaikan'
			},
			tooltip: {
			  trigger: 'axis'
			},
			legend: {
			  data: ['Semua Laporan', 'Terselesaikan', 'Tidak Terselesaikan','Lainnya']
			},
			toolbox: {
			  show: true,
			  feature: {
			  	magicType:{
			  		show:true,
			  		title:{
			  			line:'Garis',
			  			bar:'Batang'
			  		},
			  		type:['line','bar']
			  	},
			  	restore:{
			  		show:true,
			  		title:'Restore'
			  	},
				saveAsImage: {
				  show: true,
				  title: "Simpan",
				  type:'png',
				  name:'Data Laporan'
				}
			  }
			},
			calculable: true,
			xAxis: [{
			  type: 'category',
			  data:[
			  @foreach($list_mayor_keluhan as $mayor_keluhan)
			  	"{{$mayor_keluhan->kode}}",
			  @endforeach
			  ]
			}],
			yAxis: [{
			  type: 'value'
			}],
			series: [
			{
			  name: 'Semua Laporan',
			  type: 'bar',
			  data: [
			  @foreach($list_mayor_keluhan as $mayor_keluhan)
			  	{{$mayor_keluhan->listLaporan->count()}},
			  @endforeach
			  ],
			  markPoint: {
				data: [{
				  type: 'max',
				  name: 'Semua Laporan'
				}, {
				  type: 'min',
				  name: 'Semua Laporan'
				}]
			  }
			}, 
			{
			  name: 'Terselesaikan',
			  type: 'bar',
			  data:[
			  @foreach($list_mayor_keluhan as $mayor_keluhan)
			  	{{$mayor_keluhan->listSolvedLaporan->count()}},
			  @endforeach
			  ],
			  markPoint: {
				data: [{
				  type: 'max',
				  name: 'Terselesaikan'
				}, {
				  type: 'min',
				  name: 'Terselesaikan'
				}]
			  }
			},
			{
			  name: 'Tidak Terselesaikan',
			  type: 'bar',
			  data:[
			  @foreach($list_mayor_keluhan as $mayor_keluhan)
			  	{{$mayor_keluhan->listUnSolvedLaporan->count()}},
			  @endforeach
			  ],
			  markPoint: {
				data: [{
				  type: 'max',
				  name: 'Tidak Terselesaikan'
				}, {
				  type: 'min',
				  name: 'Tidak Terselesaikan'
				}]
			  }
			},
			{
			  name: 'Lainnya',
			  type: 'bar',
			  data:[
			  @foreach($list_mayor_keluhan as $mayor_keluhan)
			  	{{$mayor_keluhan->listOtherLaporan->count()}},
			  @endforeach
			  ],
			  markPoint: {
				data: [{
				  type: 'max',
				  name: 'Tidak Terselesaikan'
				}, {
				  type: 'min',
				  name: 'Tidak Terselesaikan'
				}]
			  }
			}
			]
		  });

	}
	</script>
@stop