<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Catalogo;
class DashboardController extends Controller
{

	public function __construct(){

		$this->middleware('auth');
	}
    public function index(){
		$user = User::count();
		$catalogos = Catalogo::all();
    	return view('auth.index', compact('user', 'catalogos'));
    }
}
