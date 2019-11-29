<?php

namespace App\Http\Controllers\Admin;

use App\Models\renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Renting::paginate($this->pagesize);
        return view('admin.renting.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\renting  $renting
     * @return \Illuminate\Http\Response
     */
    public function show(renting $renting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\renting  $renting
     * @return \Illuminate\Http\Response
     */
    public function edit(renting $renting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\renting  $renting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, renting $renting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\renting  $renting
     * @return \Illuminate\Http\Response
     */
    public function destroy(renting $renting)
    {
        //
    }
}
