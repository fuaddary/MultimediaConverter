<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function Index()
    {
    	return view('pages.image');
    }
}
