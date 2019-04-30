<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
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
        $companies = Company::all();
        return view('company.view', compact('companies'));
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email', 'unique:users,email'],
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
        return view('company.add');
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

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        if ($request->hasFile('image')) {
            $path = $this->uploadFile($request, 'image');
        } else {
            $path = '';
        }
        $company->image = $path;
        if ($company->save()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'Company';
            $user->image = $path;
            $user->save();
            Session::flash('successMessage', 'Record Inserted Successfully');
            return redirect("/company/create");
        } else {
            Session::flash('errorMessage', 'Record Insert Failed');
            return redirect("/company/create");
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
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
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
        $company = Company::findOrFail($id);
        $user = User::where('email', $company->email)->get()->first();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email,' . $company->id],
            'address' => ['required'],
        ]);

        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        if ($request->hasFile('image')) {
            $path = $this->uploadFile($request, 'image');
        } else {
            $path = $request->old_image;
        }
        $company->image = $path;
        if ($company->save()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->image = $path;
            $user->save();
            Session::flash('successMessage', 'Record Inserted Successfully');
            return redirect("/company");
        } else {
            Session::flash('errorMessage', 'Record Insert Failed');
            return redirect("/company");
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
        $company = Company::findOrFail($id);
        $user = User::where('email', $company->email)->get()->first();
        if ($company->delete()) {
            $user->delete();
            Session::flash('successMessage', 'Record Deleted Successfully');
            return redirect("/company");
        } else {
            Session::flash('errorMessage', 'Record Delete Failed');
            return redirect("/company");
        }
    }
}
