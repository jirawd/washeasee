<?php

namespace App\Http\Controllers;

use App\Models\BasicServices;
use App\Models\Services;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Home';


        return view('home', compact('title'));
    }

    public function about()
    {
        $title = 'About Us';
        return view('about', compact('title'));
    }

    public function services()
    {
        $title = 'Services';

        $services = Services::limit(9)->get();

        return view('services', compact('title', 'services'));
    }

    public function contact()
    {
        $title = 'Contact';
        return view('contact', compact('title'));
    }

    public function login()
    {
        $title = 'Login';

        return view('customers.login', compact('title'));
    }

    public function register()
    {
        $title = 'Register';
        return view('register', compact('title'));
    }

    public function private_map() {
        return view('map');
    }
}
