<?php

namespace Modules\ELearning\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ELearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('elearning::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('elearning::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('elearning::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('elearning::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
