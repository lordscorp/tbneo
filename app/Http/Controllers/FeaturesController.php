<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        return Feature::where('projeto_id', '=', $id)->paginate(10);
    }
}
