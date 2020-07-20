<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Keygen;
use App\Invoice;
use App\InvoiceItem;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Invoice::latest()->get();
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
        Invoice::create($request->all());
        $message = 'Invoice created successfully';
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
        $invoice = Invoice::findOrFail($id);
        return response(compact('invoice'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $Customer)
    {
        //
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
        
        Invoice::updateOrCreate(['id' => $id], $request->all());
        $message = "Invoice updated successfully";
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
        Invoice::destroy($id);
        $message = 'Invoice deleted Successfully';
        return response(compact('message'), 200);
    }

    // number generator
    protected function generateNumericKey()
    {
        return Keygen::numeric(4)->generate();
    }

    // Auto generate Invoice number
    protected function generateInvoiceNumber()
    {
        $invoiceNumber = $this->generateNumericKey();

        // Ensure an invoice number does not exist
        // Generate new one if invoice number already exists
        while (Invoice::where(['invoice_number' => $invoiceNumber])->count() > 0 ) {
            $invoiceNumber = $this->generateNumericKey();
        }

        return response(compact('invoiceNumber'), 200);
    }

}
