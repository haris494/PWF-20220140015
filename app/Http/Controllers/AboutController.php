<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'nama' => 'irwan saputra',
            'nim' => '1234567899',
            'prodi' => 'Teknologi Informasi',
            'hobi' => 'Coding, desain UI, dan bermain game'
        ]);
    }
}