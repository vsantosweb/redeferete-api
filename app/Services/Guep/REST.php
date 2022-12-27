<?php

namespace App\Services\Guep;

use App\Models\GuepSession;
use Illuminate\Support\Facades\Http;

/**
 * This class implements the RESTful transport of apiServiceRequest()'s.
 */
class REST
{
    protected $session;

    public function __construct()
    {
        $this->url      = env('GUEP_API_URL');
        $this->user     = env('GUEP_USER');
        $this->password = env('GUEP_PASSWORD');
        $this->api_key  = env('GUEP_API_KEY');

        $this->session = $this->session();
    }

    public function session()
    {
        if (is_null(GuepSession::all()->last()) || now() > GuepSession::all()->last()->expire_at) {
            try {
                $formData = [
                    'usuario'        => $this->user,
                    'senha'          => $this->password,
                    'api_access_key' => $this->api_key,
                ];

                $response = json_decode($this->call('POST', 'auth', $formData)->body());

                $newSession = GuepSession::updateOrCreate([
                    'token'     => $response->token,
                    'expire_at' => now()->parse($response->dt_vencimento),
                    'type'      => $response->nome,
                ]);

                return $newSession;
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        return GuepSession::all()->last();
    }

    public function call(string $method, string $action, array|null $data = null)
    {
        $headers = [];

        if (isset($this->session)) {
            $headers['Authorization'] = $this->session->token;
        }

        return Http::withHeaders($headers)->$method($this->url . '?action=' . $action, $data);
    }
}
