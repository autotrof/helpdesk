<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
	public function laporan(Request $request)
	{
		$data['TAG'] = 'laporan';
		return view('pages.laporan',$data);
	}

	public function pengumuman(Request $request)
	{
		$data['TAG'] = 'pengumuman';
		return view('pages.pengumuman',$data);	
	}

    public function internLaporan(Request $request)
    {
    	$data['TAG'] = 'laporan';
    	return view('pages.intern_laporan',$data);
    }

    public function internSummary(Request $request)
    {
    	$data['TAG'] = 'summary';
		return view('pages.summary',$data);
    }

    public function internPengumuman(Request $request)
    {
    	$data['TAG'] = 'pengumuman';
		return view('pages.pengumuman',$data);
    }
}
