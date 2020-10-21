<?php

namespace App\Http\Controllers;

use App\Ldcservice;
use Illuminate\Http\Request;

class LDCServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return 'i am here';
        return Ldcservice::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'costcenter'=> '',
            'servicetype'=> '',
            'serialno'=> '',
            'providername'=> '',
            'contactperson'=> '',
            'email'=> '',
            'phone'=> '',
            'lastrenew'=> '',
            'nextrenew'=> '',
            'amount'=> '',
            'currency'=> '',
            'remarks'=> ''
        ]);
        return Ldcservice::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        $request->validate([
            'costcenter'=> '',
            'servicetype'=> '',
            'serialno'=> '',
            'providername'=> '',
            'contactperson'=> '',
            'email'=> '',
            'phone'=> '',
            'lastrenew'=> '',
            'nextrenew'=> '',
            'amount'=> '',
            'currency'=> '',
            'remarks'=> ''
        ]);
        $data = [
            'costcenter'=> $request->costcenter,
            'servicetype'=> $request->servicetype,
            'serialno'=> $request->serialno,
            'providername'=> $request->providername,
            'contactperson'=> $request->contactperson,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'lastrenew'=> $request->lastrenew,
            'nextrenew'=> $request->nextrenew,
            'amount'=> $request->amount,
            'currency'=> $request->currency,
            'remarks'=> $request->remarks
        ];
        return Ldcservice::where('id',$request->id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
