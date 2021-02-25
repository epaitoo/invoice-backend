<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::latest()->get();
        return response(compact('data'), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Customer::create($request->all());
        $message = 'Customer Profile created successfully';
        return response(compact('message'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::find($id);
        return response(compact('data'), 200);
    }

 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Customer::updateOrCreate(['id' => $id], $request->all());
        $message = "Customer info updated successfully";
        return response(compact('message'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);
        $message = 'Customer deleted Successfully';
        return response(compact('message'), 200);
    }

    /**
     * SoftDelete the specified resource from storage.
     *
     * @param  \App\Customer  $CustomerID
     * @return \Illuminate\Http\Response
     */
    public function softDelete($id)
    {
        Customer::destroy($id);
        $message = 'Customer deleted Temporarily';
        return response(compact('message'), 200);
    }

    /**
     * Display a listing of the SoftDeleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SoftDeletedCustomers()
    {
        $data = Customer::onlyTrashed()->get();
        return response(compact('data'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  
     * @return \Illuminate\Http\Response
     */
    public function viewSoftDeletedCustomer($id)
    {
        $data = Customer::onlyTrashed()->find($id);
        return response(compact('data'), 200);
    }

    /**
     * Permanently Remove the softdeleted resource from storage.
     *
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function permanentlyDeleteSoftDelete($id)
    {
        $data = Customer::onlyTrashed()->find($id);

        if (!is_null($data)){
            $data->forceDelete();
            $message = 'Customer deleted permanently';
            return response(compact('message'), 200);
        } else {
            return response('Customer not deleted', 400);
        }

        return response('Customer not found', 404);
    }


}
