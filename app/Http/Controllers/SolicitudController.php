<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\ActividadEconomica;
use App\Models\Beneficiario;
use App\Models\Certificado;
use App\Models\File;
use App\Models\Formulario;
use App\Models\Notificacion;
use App\Models\Solicitud;
use App\Models\SolicitudFile;
use Illuminate\Support\Facades\Log;
use App\Services\PinataService;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SolicitudController extends Controller
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
        $solicitudes = Solicitud::paginate(10);
        return view('GestionarCertificados.solicitudes.index', compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('GestionarCertificados.solicitudes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $beneficiario = Beneficiario::create([
                'nombre' => $request->dto_nombres,
                'cedula' => $request->dto_cedula,
                'email' => $request->correo,
                'celular' => $request->celular,
                'direccion' => $request->direccion,
                'tipo_persona' => $request->tipo_persona,
            ]);

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

            $formulario = Formulario::create([
                'beneficiario_id' => $beneficiario->id,
                'actividad_economica_id' => $actividadEconomica->id,
            ]);

            $solicitud = Solicitud::create([
                'formulario_id' => $formulario->id,
                'beneficiario_id' => $beneficiario->id,
                'estado' => 0,
            ]);

            $camposArchivos = [
                'cedula_anverso',
                'cedula_reverso',
                'file_nit',
                'file_luz',
                'declaracion_jurada',
                'carta_compromiso',
                'resolucion_sedes',
                'titulo_provision_nacional'

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

$mensaje = "Su solicitud ha sido registrada exitosamente. Por favor diríjase a la sección de búsqueda con su código {$solicitud->id} para realizar el seguimiento.";
            $notificacion = Notificacion::create([
                'solicitud_id' => $solicitud->id,
                'mensaje' => $mensaje
            ]);
            $this->enviarMensajeWhatsapp($beneficiario->celular, $mensaje);

            return redirect()->route('admin.solicitudes')
                ->with('success', 'Solicitud creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al guardar la solicitud: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitud)
    {
        return view('GestionarCertificados.solicitudes.show', compact('solicitud'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($solicitud_id)
    {
        $solicitud = Solicitud::with(['formulario.actividadEconomica', 'files'])->findOrFail($solicitud_id);
//dd($solicitud);
        // dd($solicitud->beneficiario->tipo_persona);
        return view('GestionarCertificados.solicitudes.edit', compact('solicitud'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $solicitud_id)
    {
        $solicitud = Solicitud::findOrFail($solicitud_id);
        $estado = $request->input('estado');
        $solicitud->estado = $estado;
        $solicitud->save();

        // Lógica según el estado
        if ($estado == 1) {
            Certificado::create([
                'solicitud_id' => $solicitud->id,
                'signed' => 0,
            ]);

            $mensaje = "Su solicitud ha sido aprobada. Por favor diríjase a la sección de búsqueda con su código {$solicitud->id} para descargar su certificado.";
        } elseif ($estado == 2) {
            $mensaje = $request->input('mensaje');
        }

        // Si el estado es 1 o 2, actualiza o crea notificación y envía WhatsApp
        if (in_array($estado, [1, 2])) {
            $notificacion = Notificacion::updateOrCreate(
                ['solicitud_id' => $solicitud->id],
                ['mensaje' => $mensaje]
            );
            $newMensaje = "Codigo de Solicitud: {$solicitud->id}\nEstado: " . ($estado == 1 ? 'Aprobada' : 'Rechazada') . "\nMensaje: {$mensaje}";
            $this->enviarMensajeWhatsapp($solicitud->beneficiario->celular, $newMensaje);
        }

        return redirect()->route('admin.solicitudes')->with('success', 'Solicitud actualizada correctamente.');
    }

    // Función auxiliar para enviar mensajes por WhatsApp
    private function enviarMensajeWhatsapp($numero, $mensaje)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('POST', 'https://waapi.app/api/v1/instances/70360/client/action/send-message', [
                'body' => json_encode([
                    'chatId' => '591' . $numero . '@c.us',
                    'message' => $mensaje
                ]),
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Bearer CevSfvCD6aVpcde6dYSluLcsqCTlb6lNeSVfGFgR999b507f',
                    'content-type' => 'application/json',
                ],
            ]);

            Log::info('Mensaje WhatsApp enviado: ' . $response->getBody());
        } catch (\Exception $e) {
            Log::error('Error al enviar mensaje WhatsApp: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud eliminada correctamente.');
    }

    public function uploadFile(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'file.required' => 'Es necesario seleccionar un archivo.',
            'file.mimes' => 'El archivo debe ser de tipo jpg, jpeg, png o pdf.',
            'file.max' => 'El tamaño del archivo no debe superar los 2MB.'
        ]);

        try {
            $file = $validatedData['file'];

            $ipfsHash = $this->pinataService->uploadToIPFS($file);

            return response()->json(['ipfsHash' => $ipfsHash, 'message' => 'Archivo subido correctamente a IPFS.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al subir el archivo: ' . $e->getMessage()], 500);
        }
    }
}
