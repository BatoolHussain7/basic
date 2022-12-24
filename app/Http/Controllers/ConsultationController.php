<?php

namespace App\Http\Controllers;

use App\Models\consul_expert;
use App\Models\Consultation;
use App\Models\Expert;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $consultation=Consultation::all(); 
        return response()->json([
            'data' => $consultation,
            'message' => 'success',
        ]);
    }
    public function assignconsultationtoexpert(Request $request)
    {   
        $validator = Validator::make($request->all(), [
        'consultationId' => 'required|array',
        'consultationId.*' => 'required|exists:consultations,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }
        
        dd(Auth::user()->consultations()->sync($request->consultationId));
    }    
     
    public function showexperts($id)
    {
          $expert=Consultation::find($id)->experts;
            return response()->json([
                'data'=>$expert,
                'message'=>'success'
            ]);
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
        $request->validate([
            'name'=>'required'
        ]);
        return Consultation::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Consultation::find($id);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $consultation=Consultation::find($id);
        $consultation->update($request->all());
        return $consultation;
    }

    /**
     * Search
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Consultation::where('name','like','%'.$name.'%')->get('name');
    }
}
