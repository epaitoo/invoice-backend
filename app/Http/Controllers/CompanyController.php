<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::latest()->get();
        return response(compact('data'), 200);
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
        Company::create($request->all());
        $message = 'Company Profile created successfully';
        return response(compact('message'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Company::find($id);
        return response(compact('data'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $Company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Company::updateOrCreate(['id' => $id], $request->all());
        $message = "Company info updated successfully";
        return response(compact('message'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::delete($id);
        $message = 'Data deletion complete';
        return response(compact('message'), 200);
    }



}
