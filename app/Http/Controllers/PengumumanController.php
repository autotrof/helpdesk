<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pengumuman;

class PengumumanController extends Controller
{
    public function postPengumuman(Request $request)
    {
        $tanggal = explode(' - ', $request->input('tanggal'));
        if ($request->input('id')!='') {
            Pengumuman::where('id',$request->input('id'))->update([
                'judul'=>$request->input('judul'),
                'isi'=>$request->input('isi'),
                'start_pengumuman'=>$tanggal[0],
                'stop_pengumuman'=>$tanggal[1]    
            ]);
        }else{
            Pengumuman::create([
                'judul'=>$request->input('judul'),
                'isi'=>$request->input('isi'),
                'start_pengumuman'=>$tanggal[0],
                'stop_pengumuman'=>$tanggal[1]
            ]);
        }
    	return response()->json(['result'=>true]);
    }

    public function getData(Request $request)
    {
    	$orderBy = '';
        switch($request->input('order.0.column')){
            case "0":
                $orderBy = 'id';
            break;
            case "1":
                $orderBy = 'judul';
            break;
            default:
                $orderBy = 'id';
            break;
        }

        $data = Pengumuman::where('id','>',0);
        if($request->input('search.value')!=''){
            $data = $data
            	->where('judul','like','%'.$request->input('search.value').'%')
                ->orWhere('isi','like','%'.$request->input('search.value').'%');
        }

        $recordsFiltered = $data->count();

        $data = $data->skip($request->input('start'))->take($request->input('length'))->orderBy($orderBy,$request->input('order.0.dir'))->get();
        return response()->json([
        	'draw'=>$request->input('draw'),
            'recordsTotal'=>count($data)/$request->input('length'),
            'recordsFiltered'=>$recordsFiltered,
            'data'=>$data,
            'request'=>$request->all(),
        ],200);
    }

    public function getSingle(Request $request, $id)
    {
        $pengumuman = Pengumuman::find($id);
        return response()->json($pengumuman);
    }
}
