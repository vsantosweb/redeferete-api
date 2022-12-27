<?php

namespace App\Http\Controllers\Api\Private\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DriverContractResource;
use App\Models\Driver\DriverContract;
use Illuminate\Http\Request;

class DriverContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'count' => DriverContract::filter()->count(),
            'data'  => DriverContractResource::collection(DriverContract::orderBy('created_at', 'DESC')
            ->skip($request->skip ?? 0)
            ->take($request->limit ?? 50)
            ->filter()->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        return $this->outputJSON(new DriverContractResource(DriverContract::with('hubs')->find($id)));
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
        //
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
