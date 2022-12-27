<?php

namespace App\Http\Controllers\Api\Private\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DriverResource;
use App\Models\Driver\DriverStatus;
use App\Models\PreRegistration;
use App\Repository\Interfaces\Driver\IDriverRepository;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected IDriverRepository $driver;

    public function __construct(IDriverRepository $driverRepository)
    {
        $this->driver = $driverRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'count' => $this->driver->model()->filter()->count(),
            'data'  => DriverResource::collection(
                $this->driver->model()->orderBy('created_at', 'DESC')
                    ->where('driver_status_id', '!=', 5)
                    ->skip($request->skip ?? 0)
                    ->take($request->limit ?? 50)
                    ->filter()->get()
            ),
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
        if ($this->driver->checkExists('email', $request->email)) :

            return $this->outputJSON([], 'Este endereço de email já em uso, utilize outro!', false, 400);

        endif;

        $data = $request->all();

        $data['driver_status_id'] = 6;

        $newDriver = $this->driver->create($data);

        return $this->outputJSON($newDriver);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->outputJSON(new DriverResource($this->driver->model()->with('status', 'licence', 'address', 'vehicles')->find($id)));
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
        $request->validate([
            'email' => 'unique:drivers,email,' . $id,
        ]);

        return $this->outputJSON($this->driver->update($id, $request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->outputJSON($this->driver->deleteById($id));
    }

    public function createDocument(Request $request, $id)
    {
        $request->validate([
            'document_number' => 'unique:driver_documents,document_number,' . $id,
        ]);
    }

    public function updateDocument(Request $request, $id)
    {
        $request->validate([
            'document_number' => 'unique:driver_documents,document_number,' . $id,
        ]);
    }

    public function status()
    {
        return $this->outputJSON(DriverStatus::all());
    }

    public function changeStatus(Request $request, $id)
    {
        return $this->outputJSON($this->driver->update($id, ['driver_status_id' => $request->driver_status_id]), '', true, 200);
    }

    public function getDriversByDateRange(Request $request)
    {
        // $query =  $this->driver->model()
        //     ->whereBetween('created_at', [$request->date_from, $request->date_to . ' 23:59:59'])
        //     ->orderBy('created_at', 'ASC')
        //     ->get()
        //     ->map(fn ($item) => (object) [
        //         'id' => $item->id,
        //         'name' => $item->name,
        //         'email' => $item->email,
        //         'status' => $item->status->name,
        //         'created_at' => $item->created_at,
        //     ])
        //     ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'));

        $query = $this->driver->model()
            ->whereBetween('created_at', [$request->date_from, $request->date_to . ' 23:59:59'])
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(fn ($item) => (object) [
                'id'         => $item->id,
                'name'       => $item->name,
                'email'      => $item->email,
                'status'     => $item->status->name,
                'created_at' => $item->created_at->format('Y-m-d'),
            ]);

        return $this->outputJSON($query, '', true, 200);
    }

    public function getDriversHubsByDateRange(Request $request)
    {
        $query = PreRegistration::whereBetween('created_at', [$request->date_from, $request->date_to . ' 23:59:59'])
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(fn ($item) => (object) [
                'id'           => $item->id,
                'name'         => $item->name,
                'email'        => $item->email,
                'phone'        => $item->phone,
                'vehicle_type' => $item->vehicle_type,
                'zipcode'      => $item->zipcode,
                'city'      => $item->city,
                'is_avaiable'  => $item->is_avaiable === 0 ? 'Disponível' : 'Indisponível',
                'status'       => $item->is_avaiable,
                'company'      => $item->company,
                'hub'          => $item->hub,
                'code'         => $item->hub,
                'created_at'   => $item->created_at->format('Y-m-d'),
            ]);

        return $this->outputJSON($query, '', true, 200);
    }
}
