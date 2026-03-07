<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'nama' => 'Haris Shihab Dzul Firdausi',
            'nim' => '20220140015',
            'prodi' => 'Teknologi Informasi',
            'hobi' => 'Coding, desain UI, dan bermain game'
        ]);
    }
}