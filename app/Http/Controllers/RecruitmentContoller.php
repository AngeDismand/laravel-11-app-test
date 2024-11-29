<?php

namespace App\Http\Controllers;

use App\Models\Cvs;
use Illuminate\Http\Request;

class RecruitmentContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $cvs;
    public function __construct(){
        $this ->cvs = new Cvs();
    }
    public function index()
    {
        $response['cvs'] = $this->cvs->all();
        return view('pages.index')->with($response);
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->cvs->create($request->all());
        return redirect('recruitment');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response['recruitment'] = $this->cvs->find($id);
        return view('pages.edit')->with($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $recruitment = $this->cvs->find($id);
        $recruitment->update(array_merge($recruitment->toArray(), $request->toArray()));
        return redirect('recruitment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recruitment = $this->cvs->find($id);
        $recruitment->delete();
        return redirect('recruitment');
    }
}
