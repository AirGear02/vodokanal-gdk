<?php

namespace App\Http\Controllers;

use App\Models\ContragentTypes;
use Illuminate\Http\Request;

class ContragentTypesController extends Controller
{
    public function index()
    {
        return ContragentTypes::all();
    }
}
