<?php
// app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function consultation()
    {
        return view('pages.consultation');
    }

    public function realEstateService()
    {
        return view('pages.real_estate_service');
    }

    public function contacts()
    {
        return view('pages.contacts');
    }
}