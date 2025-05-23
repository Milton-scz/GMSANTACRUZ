<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Certificado;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use TCPDF;
 use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $certificados = Certificado::paginate(10);
    return view('GestionarCertificados.certificados.index', compact('certificados'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('GestionarCerticados.certificados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_emision' => 'required|date',
        ]);

        Certificado::create($request->all());

        return redirect()->route('certificados.index')
                         ->with('success', 'Certificado creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
  public function showPdf($certificado_id)
{
    $certificado = Certificado::findOrFail($certificado_id);

    $ruta = storage_path('app/public/certificados/' . basename($certificado->urlPdfSigned));

    if (!file_exists($ruta)) {
        abort(404, 'El archivo PDF no existe.');
    }

    return response()->file($ruta, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($ruta) . '"'
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificado $certificado)
    {
        return view('GestionarCerticados.certificados.edit', compact('certificado'));
    }

    public function verificacion()
    {
        return view('GestionarCertificados.certificados.verificacion');
    }

 public function verificar(Request $request)
{
    $request->validate([
        'certificado' => 'required|file|mimes:pdf,jpg,jpeg,png', // puedes agregar más MIME si necesitas
    ]);

    $file = $request->file('certificado');

    // ✅ Leer el contenido del archivo
    $contenido = file_get_contents($file->getRealPath());

    // ✅ Si necesitas en base64 (por ejemplo, para enviar a un API)
    $base64Contenido = base64_encode($contenido);

    // ✅ Opcional: Guardar archivo temporalmente
    // $file->storeAs('certificados_temp', $file->getClientOriginalName());

    // ✅ Solo para debug o prueba
    return response()->json([
        'nombre_archivo' => $file->getClientOriginalName(),
        'mime' => $file->getMimeType(),
        'contenido_base64' => $contenido, // evitar mostrar todo si es muy largo
    ]);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificado $certificado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_emision' => 'required|date',
        ]);

        $certificado->update($request->all());

        return redirect()->route('certificados.index')
                         ->with('success', 'Certificado actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificado $certificado)
    {
        $certificado->delete();

        return redirect()->route('certificados.index')
                         ->with('success', 'Certificado eliminado correctamente.');
    }




public function generarCertificado(Request $request)
{
    $certificado = Certificado::findOrFail($request->certificado_id);

    $data = [
        'nombre' => $certificado->solicitud->beneficiario->nombre,
        'cedula' => $certificado->solicitud->beneficiario->cedula,
        'nit' => $certificado->solicitud->formulario->actividadEconomica->nit,
        'firma' => $certificado->firma,
        'id' => $certificado->id
    ];

    return view('GestionarCertificados.certificados.certificado', compact('data'));
}

   public function firmar($certificado_id){
       $certificado = Solicitud::with('formulario.actividadEconomica')->findOrFail($certificado_id);
        return view('GestionarCertificados.certificados.firmar', compact('certificado'));
    }


public function firmarPdf($certificado_id)
{
    $certificado = Certificado::findOrFail($certificado_id);

    $certificatePath = storage_path('app/certs/certificado.pem');
    $privateKeyPath  = storage_path('app/certs/clave_privada-sin-pass.pem');

    $privateKey = file_get_contents($privateKeyPath);
    $certificate = 'file://' . $certificatePath;
    $privateKeyFile = 'file://' . $privateKeyPath;

    // === DATOS A FIRMAR ===
    $data = [
        'certificado_id' => $certificado->id,
        'razon_social' => $certificado->solicitud->beneficiario->nombre,
        'nit' => $certificado->solicitud->formulario->actividadEconomica->nit,
        'actividad' => $certificado->solicitud->formulario->actividadEconomica->actividad_economica,
        'fecha' => now()->toDateTimeString(),
    ];

    if (!openssl_sign(json_encode($data), $firmaBinaria, $privateKey, OPENSSL_ALGO_SHA256)) {
        return response()->json(['error' => 'No se pudo firmar los datos.'], 500);
    }

    $firmaBase64 = base64_encode($firmaBinaria);

    // === LEE INFO DEL CERTIFICADO ===
    $certData = openssl_x509_parse(file_get_contents($certificatePath));
    $nombre = $certData['subject']['CN'] ?? 'Desconocido';
    $org = $certData['subject']['O'] ?? 'Sin organización';
    $localidad = $certData['subject']['L'] ?? 'Sin ciudad';

    // === GENERAR PDF ===
    $pdf = new \TCPDF();
    $pdf->AddPage();

    // Diseño básico
     $pdf->SetDrawColor(0, 102, 0);
    $pdf->SetLineWidth(1);
    $pdf->Rect(5, 5, 200, 287);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetTextColor(0, 102, 0);
    $pdf->Cell(0, 10, ('GOBIERNO AUTÓNOMO MUNICIPAL DE SANTA CRUZ DE LA SIERRA'), 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 7, ('SECRETARÍA MUNICIPAL DE ADMINISTRACIÓN TRIBUTARIA'), 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(0, 10, ('LICENCIA DE FUNCIONAMIENTO DE ACTIVIDAD ECONÓMICA'), 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Cell(40, 7, 'Razón Social:', 0);
    $pdf->Cell(80, 7, utf8_decode($data['razon_social']), 0, 1);

    $pdf->Cell(40, 7, 'NIT / CI:', 0);
    $pdf->Cell(80, 7, $data['nit'], 0, 1);

    $pdf->Cell(40, 7, 'Actividad:', 0);
    $pdf->MultiCell(80, 7, utf8_decode($data['actividad']), 0);

    $pdf->Cell(40, 7, 'Superficie:', 0);
    $pdf->Cell(80, 7, $certificado->superficie . ' mts. cuadrados', 0, 1);

    $pdf->Cell(40, 7, 'Fecha de Inicio:', 0);
    $pdf->Cell(80, 7, \Carbon\Carbon::parse($certificado->fecha_inicio)->format('d/m/Y'), 0, 1);

    $pdf->Cell(40, 7, 'Licencia N°:', 0);
    $pdf->Cell(80, 7, $certificado->id, 0, 1);

    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, "El monto fijado a la patente municipal será actualizado de acuerdo al mantenimiento de valor.\nCualquier contravención a lo establecido en el código de urbanismo y obras, deja sin efecto esta licencia.");
    $pdf->Ln(10);

    // === Firma Digital de los DATOS ===
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(0, 6, ('Firmado Digitalmente por:'), 0, 1);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 5, "$nombre\nFecha de firma: " . now()->format('d/m/Y H:i:s') . "\nFirma de datos:\n" . $firmaBase64);
    $pdf->Ln(5);

    // === Firma del PDF ===
    $pdf->setSignature(
        $certificate,
        $privateKeyFile,
        'tcpdfdemo',
        '',
        2,
        [
            'Name' => $nombre,
            'Location' => $localidad,
            'Reason' => 'Firma Digital del Documento'
        ]
    );
    $pdf->setSignatureAppearance(170, 260, 25, 25);
    $pdf->SetXY(170, 255);
    $pdf->SetFont('helvetica', '', 7);
    $pdf->MultiCell(30, 5, "Firmado por:\n$nombre", 0);

    // === GUARDAR PDF ===
    $nombreArchivo = 'certificado_' . $certificado->id . '_' . now()->format('Ymd_His') . '.pdf';
    $path = storage_path('app/public/certificados/' . $nombreArchivo);

    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }

    $pdf->Output($path, 'F');
    $url = asset('storage/certificados/' . $nombreArchivo);

    // === GUARDAR EN BASE DE DATOS ===
    $certificado->urlPdfSigned = $url;
    $certificado->signed = 1;
    $certificado->firma = $firmaBase64;
    $certificado->save();


  $response = Http::post('http://localhost:3000/api/save-data', [
                'codigoSolicitud' =>  (string) $certificado->id,
                'datosFirmados' => $firmaBase64,
            ])->throw();
    // Maneja la respuesta
    if ($response->successful()) {
        // La petición fue exitosa
        Log::info('Petición exitosa al endpoint externo.', ['respuesta' => $response->body()]);

    } else {
        // La petición falló
        Log::error('Fallo al conectar con el endpoint externo.', ['status' => $response->status(), 'error' => $response->body()]);
    }

    return response()->json([
        'success' => true,
        'message' => 'PDF firmado y guardado correctamente.',
        'ruta_pdf' => $certificado->urlPdfSigned
    ]);
}





}
