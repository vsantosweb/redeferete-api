<?php

namespace App\Http\Controllers\Api\Private\Driver;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\Driver\IDriverBankRepository;
use Illuminate\Http\Request;

class DriverBankController extends Controller
{
    protected IDriverBankRepository $bank;

    public function __construct(IDriverBankRepository $bank)
    {
        $this->bank = $bank;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->outputJSON($this->bank->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $driverId)
    {
        $bank = $this->bank->create($this->bank->prepare($request->all()));

        return $this->outputJSON($bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $driverId, $bankId)
    {
        $request->validate([
            'bank_number' => 'unique:driver_banks,bank_number,' . $bankId,
        ]);

        return $this->outputJSON($this->bank->update($bankId, $this->bank->prepare($request->all())));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($driverId, $bankId)
    {
        return $this->outputJSON($this->bank->deleteById($bankId));
    }
}
