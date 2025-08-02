<?php
// app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;


class PageController extends Controller
{
    public function consultation()
    {   
        $email = Setting::where('key', 'contact_email')->value('value');
        $phoneNumber = Setting::where('key', 'header_phone_number')->value('value');

        return view('pages.consultation',compact('email', 'phoneNumber'));
    }

    public function realEstateService()
    {   
        return view('pages.real_estate_service');
    }

    public function contacts()
    {
        $email = Setting::where('key', 'contact_email')->value('value');
        $phoneNumber = Setting::where('key', 'header_phone_number')->value('value');
        return view('pages.contacts', compact('email', 'phoneNumber'));
    }


    public function privacyPolicy()
    {
        $email = Setting::where('key', 'contact_email')->value('value');
        return view('pages.privacy_policy', compact('email'));
    }
}