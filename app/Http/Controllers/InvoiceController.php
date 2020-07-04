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
        
        $this->validate($request, [
            'invoice_number' => 'required',
            'customer_name' => 'required|max:255',
            'customer_phone_number' => 'required|max:255',
            'customer_address' => 'required',
            'date' => 'required',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.total' => 'required',
        ]);
        
        // create a new invoice item
        $items = collect($request->items)->transform(function($item){
            $item['total'] = $item['qty'] * $item['unit_price'];
            return new InvoiceItem($item);
        });

        if($items->isEmpty()) {
            return response()
            ->json([
                'items_empty' => ['One or more Product item is required.']
            ], 422);
        }

        // Get all the input value except the items array
        $data = $request->except('items');
        // Subtotal of the invoice is the sum of the total items (invoice items array)
        $data['sub_total'] = $items->sum('total');
        // Get the grand total of the invoice by deducting the subtotal from the discount
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $invoice = Invoice::create($data);


        $invoice->items()->saveMany($products);

        return response()
            ->json([
                'created' => true,
                'id' => $invoice->id,
                'message' => 'Invoice created successfully'
            ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
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
        $this->validate($request, [
            'invoice_number' => 'required',
            'customer_name' => 'required|max:255',
            'customer_phone_number' => 'required|max:255',
            'customer_address' => 'required',
            'date' => 'required',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.total' => 'required',
        ]);

        $invoice = Invoice::findOrFail($id);

         // create a new invoice item
         $items = collect($request->items)->transform(function($item){
            $item['total'] = $item['qty'] * $item['unit_price'];
            return new InvoiceItem($item);
        });

        if($items->isEmpty()) {
            return response()
            ->json([
                'items_empty' => ['One or more Product item is required.']
            ], 422);
        }

        // Get all the input value except the items array
        $data = $request->except('items');
        // Subtotal of the invoice is the sum of the total items (invoice items array)
        $data['sub_total'] = $items->sum('total');
        // Get the grand total of the invoice by deducting the subtotal from the discount
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $invoice = Invoice::update($data);


        $invoice->items()->saveMany($products);

        return response()
            ->json([
                'updated' => true,
                'id' => $invoice->id,
                'message' => 'Invoice updated successfully'
            ], 200);


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        InvoiceItem::where('invoice_id', $invoice->id)->delete();

        $invoice->delete();

        $message = 'Invoice deleted Successfully';
        return response(compact('message'), 200);
    }

    // number generator
    protected function generateNumericKey()
    {
        return Keygen::numeric(4)->prefix('INV-')->generate();
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
