<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
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
        $suppliers = Supplier::all();
        return view('supplier.view', compact('suppliers'));
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:suppliers,email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed'],
            'address' => ['required'],
        ]);
    }

    private function uploadFile(Request $request, $file)
    {
        $image = $request->file($file);
        $destination = 'public/uploads/';

        $filename = Str::lower(
            pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
            . '-'
            . uniqid()
            . '.'
            . $image->getClientOriginalExtension()
        );
        $image->move($destination, $filename);

        $path = 'public/uploads/' . $filename;

        return $path;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->isValidation($request);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        if ($request->hasFile('image')) {
            $path = $this->uploadFile($request, 'image');
        } else {
            $path = '';
        }
        $supplier->image = $path;
        if ($supplier->save()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'Supplier';
            $user->image = $path;
            $user->save();
            Session::flash('successMessage', 'Record Inserted Successfully');
            return redirect("/supplier/create");
        } else {
            Session::flash('errorMessage', 'Record Insert Failed');
            return redirect("/supplier/create");
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
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
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
        $supplier = Supplier::findOrFail($id);
        $user = User::where('email', $supplier->email)->get()->first();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:suppliers,email,' . $supplier->id],
            'address' => ['required'],
        ]);

        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        if ($request->hasFile('image')) {
            $path = $this->uploadFile($request, 'image');
        } else {
            $path = '';
        }
        $supplier->image = $path;
        if ($supplier->save()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->image = $path;
            $user->save();
            Session::flash('successMessage', 'Record Inserted Successfully');
            return redirect("/supplier");
        } else {
            Session::flash('errorMessage', 'Record Insert Failed');
            return redirect("/supplier");
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
        $supplier = Supplier::findOrFail($id);
        $user = User::where('email', $supplier->email)->get()->first();
        if ($supplier->delete()) {
            $user->delete();
            Session::flash('successMessage', 'Record Deleted Successfully');
            return redirect("/supplier");
        } else {
            Session::flash('errorMessage', 'Record Delete Failed');
            return redirect("/supplier");
        }
    }
}
