<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakeController extends Controller
{
    public function index(Make $make)
    {
        return $make->get();
    }
}
