<?php

namespace App\Http\Controllers\Api\Client\Driver\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DriverResource;
use App\Jobs\PreRegistrationJob;
use App\Models\Driver\Driver;
use App\Models\PreRegistration;
use App\Repository\Interfaces\Driver\IDriverBankRepository;
use App\Repository\Interfaces\Driver\IDriverDocumentRepository;
use App\Repository\Interfaces\Driver\IDriverRepository;
use App\Repository\Interfaces\Driver\IDriverVehicleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class DriverAuthController extends Controller
{
    protected $driver;

    /**
     * Constructor.
     *
     * @param IDriverRepository $repository,
     * @param IDriverDocumentRepository $driverDocumentRepository,
     * @param IDriverBankRepository $bank,
     * @param IDriverVehicleRepository $vehicle
     */
    public function __construct(
        IDriverRepository $repository,
        IDriverDocumentRepository $driverDocumentRepository,
        IDriverBankRepository $bank,
        IDriverVehicleRepository $vehicle
    ) {
        $this->driver   = $repository;
        $this->document = $driverDocumentRepository;
        $this->bank     = $bank;
        $this->vehicle  = $vehicle;
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');

        if (!$token = auth()->guard('driver')->attempt($input)) {
            return $this->outputJSON('', 'Usuário ou senha inválidos', false, 401);
        }

        $driver = Driver::where('email', $request->email)->firstOrFail();

        if (
            $driver->status->slug == 'pendente-de-aprovacao' ||
            $driver->status->slug == 'capturado' ||
            $driver->status->slug == 'desativado'
        ) {
            return $this->outputJSON('', 'Usuário em análise ou não ativo, entre em contato com nossa equipe para mais informações.', false, 401);
        }

        return $this->outputJSON($token, '', true, 200);
    }

    public function logout(Request $request)
    {
        try {
            auth()->guard('driver')->logout();

            return $this->outputJSON([], 'Driver logged out successfully', false, 200);
        } catch (JWTException $exception) {
            return $this->outputJSON([], $exception->getMessage(), true, 500);
        }
    }

    public function session()
    {
        /** @var Driver $driver */
        $driver = auth()->user();

        $driver->update(['last_activity' => now()]);

        $driver = $driver->with('banks')->find($driver->id);

        return $this->outputJSON(new DriverResource($driver), '', true, 200);
    }

    public function preRegister(Request $request)
    {
        if ($this->driver->checkExists('email', $request->email)) :
            return $this->outputJSON([], 'Endereço de email já em uso, utilize outro!', false, 400);
        endif;

        PreRegistrationJob::dispatch($request->all());

        return $this->outputJSON(null, 'success', true);
    }

    /**
     *  Complete register user.
     *
     * @param Request $request
     */
    public function completeRegister(Request $request)
    {
        $driver = $this->driver->model->findOrFail($request->driver_id);

        $this->document->makeLicence($request->licence, $driver->id);

        $this->document->makeAddress($request->address, $driver->id);

        $driverBank = $this->bank->create($this->bank->prepare($request->driver_bank, $driver->id));

        // $vehicleData = array_merge($request->vehicle, ['driver_bank_id' => $driverBank->id]);

        // $this->vehicle->create($this->vehicle->prepare($vehicleData, $driver->id));

        $driver->update([
            'name'              => $request->name,
            'driver_status_id'  => 2,
            'email'             => $request->email,
            'document_1'        => $request->document_1,
            'birthday'          => $request->birthday,
            'mother_name'       => $request->licence['mother_name'],
            'phone'             => $request->phone,
            'gender'            => $request->gender,
            'rg'                => $request->rg,
            'rg_uf'             => $request->rg_uf,
            'rg_issue'          => $request->rg_issue,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
            'register_complete' => true,
            'ip'                => $request->ip(),
            'user_agent'        => $request->userAgent(),
        ]);

        return $this->outputJSON(null, 'success', true);
    }

    /**
     * Verify register email.
     *
     * @return JsonResponse
     */
    public function verify()
    {
        /** @var Driver $driver */
        $driver = $this->driver->model->where('uuid', request()->trackid)->firstOrfail();

        $lead = PreRegistration::where('email', $driver->email)->first();

        if (is_null($driver->email_verified_at)) {
            return $this->outputJSON([

                'id'                => $driver->id,
                'name'              => $driver->name,
                'email'             => $driver->email,
                'phone'             => $driver->phone,
                'zipcode'           => $lead->zipcode,
                'licence_plate'     => $lead->licence_plate,
                'register_complete' => $driver->register_complete,

            ], 'Conta não verificada.', false, 200);
        }

        return $this->outputJSON([], 'Conta já verificada no sistema.', true, 400);
    }
}
