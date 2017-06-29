<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class GeneralController extends Controller
{
	public function login(Request $request)
	{
		$username = $request->input('username');
		$password = $request->input('password');
		if (Auth::attempt(['username' => $username, 'password' => $password])) {
            session()->put('username',$username);
            session()->put('role','intern');
            return response()->json(['hasil'=>true]);
        }else{
        	return response()->json(['hasil'=>false]);
        }
	}

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
