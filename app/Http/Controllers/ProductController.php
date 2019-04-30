<?php

namespace App\Http\Controllers;

use App\Company;
use App\Product;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 'Company') {
            $company = Company::where('email', Auth::user()->email)->get()->first();
            $products = Product::where('company_id', $company->id)->get();
        } elseif ($role == 'Supplier') {
            $supplier = Supplier::where('email', Auth::user()->email)->get()->first();
            $products = Product::where('supplier_id', $supplier->id)->get();
        } else {
            $products = Product::all();
        }
        return view('product.view', compact('products'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int id
     */
    public function isValidation(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'qty' => ['required'],
            'supplier_id' => ['required'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('product.add', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_id = Company::where('email', Auth::user()->email)->get()->first();
        $this->isValidation($request);

        $product = new Product();
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->supplier_id = $request->supplier_id;
        $product->company_id = $company_id->id;

        if ($product->save()) {
            Session::flash('successMessage', 'Record Inserted Successfully');
            return redirect("/product/create");
        } else {
            Session::flash('errorMessage', 'Record Insert Failed');
            return redirect("/product/create");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        return view('product.edit', compact('product', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->isValidation($request);

        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->supplier_id = $request->supplier_id;

        if ($product->save()) {
            Session::flash('successMessage', 'Record Updated Successfully');
            return redirect("/product");
        } else {
            Session::flash('errorMessage', 'Record Update Failed');
            return redirect("/product");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->delete()) {
            Session::flash('successMessage', 'Record Deleted Successfully');
            return redirect("/product");
        } else {
            Session::flash('errorMessage', 'Record Delete Failed');
            return redirect("/product");
        }
    }
}
