<?php

namespace App\Http\Controllers\Api\Private\Driver;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\Driver\IDriverDocumentRepository;
use Illuminate\Http\Request;

class DriverDocumentController extends Controller
{
    protected IDriverDocumentRepository $driverDocumentRepository;

    public function __construct(IDriverDocumentRepository $driverDocumentRepository)
    {
        $this->document = $driverDocumentRepository;
    }

    /**
     * Add a new licence.
     *
     * @return \Illuminate\Http\Response
     */
    public function makeLicence(Request $request, $id)
    {
        return $this->document->makeLicence($request->all(), $id);
    }

    /**
     * Add a new address.
     *
     * @return \Illuminate\Http\Response
     */
    public function makeAddress(Request $request, $id)
    {
        return $this->document->makeAddress($request->all(), $id);
    }
}
