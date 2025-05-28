<?php

namespace App\Http\Controllers;

use App\Models\ActividadEconomica;
use App\Models\Beneficiario;
use App\Models\Certificado;
use App\Models\File;
use App\Models\Formulario;
use App\Models\Landing;
use App\Models\Solicitud;
use App\Models\SolicitudFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\PinataService;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $pinataService;
    public function __construct(PinataService $pinataService)
    {
        $this->pinataService = $pinataService;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $rubro = $request->query('rubro'); // obtén ?rubro=salud
        return view('landing.formulario', compact('rubro'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // Crear beneficiario
        $beneficiario = Beneficiario::create([
            'nombre' => $request->dto_nombres,
            'cedula' => $request->dto_cedula,
            'email' => $request->correo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'tipo_persona' => $request->tipo_persona
        ]);

        // Crear actividad económica
        $actividadEconomica = ActividadEconomica::create([
            'rubro' => $request->rubro,
            'actividad_economica' => $request->actividad,
            'ubicacion' => $request->direccion_negocio,
            'nit' => $request->nit,
            'distrito' => $request->distrito,
            'unidad_vecinal' => $request->unidad_vecinal,
            'manzano' => $request->manzano,
            'lote' => $request->lote,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        // Crear formulario
        $formulario = Formulario::create([
            'beneficiario_id' => $beneficiario->id,
            'actividad_economica_id' => $actividadEconomica->id,
        ]);

        // Crear solicitud
        $solicitud = Solicitud::create([
            'formulario_id' => $formulario->id,
            'beneficiario_id' => $beneficiario->id,
            'estado' => 0,
        ]);

        $camposArchivos = [
            'cedula_anverso',
            'cedula_reverso',
            'file_nit',
            'file_luz'
        ];

        foreach ($camposArchivos as $campo) {
            Log::info("Revisando campo: $campo");

            if ($request->hasFile($campo)) {
                Log::info("Subiendo archivo: $campo");
                $archivo = $request->file($campo);
                try {
                    $ipfsHash = $this->pinataService->uploadToIPFS($archivo);

                    $fileRecord = File::create([
                        'hash' => $ipfsHash
                    ]);
                    SolicitudFile::create([
                        'solicitud_id' => $solicitud->id,
                        'file_id' => $fileRecord->id
                    ]);
                    Log::info("Archivo $campo subido exitosamente con hash: $ipfsHash");

                    $solicitud->files()->attach($fileRecord->id);
                } catch (\Throwable $e) {
                    Log::error("Error subiendo archivo $campo: " . $e->getMessage());
                }
            } else {
                Log::warning("No se encontró archivo para: $campo");
            }
        }
        // Retornar con mensaje de éxito y el código de solicitud
        return redirect('/')
            ->with('success', 'Solicitud creada exitosamente. Código de Seguimiento: ' . $solicitud->id);
    }


    public function consultar(Request $request)
    {

        $codigo = $request->input('codigoSolicitud');

        // Buscar por código
        $solicitud = Solicitud::where('id', $codigo)->first();
        if (!$solicitud) {
            return response()->json([
                'estado' => 'NO FOUND'
            ], 404);
        }
        // dd($solicitud);

        if ($solicitud->estado == 2) {

            $mensaje = $solicitud->notificacion->mensaje;
            return response()->json([
                'estado' => 'RECHAZADA',
                'mensaje' => $mensaje
            ], 200);
        }

        if ($solicitud->estado == 0) {
            return response()->json([
                'estado' => 'PENDIENTE',
            ], 200);
        }
        $certificado = Certificado::where('solicitud_id', $codigo)->first();


        if ($certificado->signed == 1) {
            return response()->json([
                'estado' => 'APROBADA',
                'codigo' => $certificado->id,
            ], 200);
        }
    }

    public function descargarCertificado(Request $request)
    {
        $certificado = Certificado::findOrFail($request->certificado_id);

        $data = [
            'nombre' => $certificado->solicitud->beneficiario->nombre,
            'cedula' => $certificado->solicitud->beneficiario->cedula,
            'nit' => $certificado->solicitud->formulario->actividadEconomica->nit,
            'firma' => $certificado->firma,
            'actividad' => $certificado->solicitud->formulario->actividadEconomica->actividad_economica,
            'id' => $certificado->id
        ];

        return view('landing.certificado', compact('data'));
    }



    public function verificar(Request $request)
    {
        $codigoSolicitud = $request->codigoSolicitud;
        try {
            $response = Http::get('http://localhost:3000/api/get-data-contract/' . $codigoSolicitud);
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            } else {
                return response()->json(['error' => 'Error en la consulta externa.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Código inválido o corrupto.']);
        }
    }
}
