<?php

namespace App\Http\Controllers;

use App\Models\SodaqoCategory;
use Illuminate\Http\Request;

class MobileCategoryController extends Controller
{
    public function getAll(){
        return SodaqoCategory::all();
    }
}
