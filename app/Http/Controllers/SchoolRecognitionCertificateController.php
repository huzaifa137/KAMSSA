<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\SchoolRecognitionCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolRecognitionCertificateController extends Controller
{
    // ─────────────────────────────────────────────
    //  ADMIN SIDE
    // ─────────────────────────────────────────────

    /**
     * List all issued recognition certificates (admin view).
     */
    public function index()
    {
        $certificates = SchoolRecognitionCertificate::with('house')
            ->orderByDesc('issued_date')
            ->get();

        $houses = House::orderBy('House')->get();

        return view('Certificates.school-recognition.index', compact('certificates', 'houses'));
    }

    /**
     * Show the form to issue a new certificate for a school.
     */
    public function create()
    {
        $houses = House::orderBy('House')->get();

        return view('Certificates.school-recognition.create', compact('houses'));
    }

    /**
     * Store (issue) a new recognition certificate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_number' => 'required|string|exists:houses,Number',
            'issued_date' => 'required|date',
            'issued_by' => 'nullable|string|max:150',
            'notes' => 'nullable|string',
        ]);

        // Auto-generate certificate number
        $year = date('Y', strtotime($validated['issued_date']));
        $certNumber = 'ITEB-RC-' . strtoupper($validated['house_number']) . '-' . $year;

        // Check for existing certificate
        $existingCertificate = SchoolRecognitionCertificate::where('certificate_number', $certNumber)->first();

        if ($existingCertificate) {
            if ($existingCertificate->status === 'active') {
                return back()->withInput()->with([
                    'alert' => [
                        'type' => 'error',
                        'title' => 'Active Certificate Exists!',
                        'message' => 'School <strong>' . $validated['house_number'] . '</strong> already has an active certificate.<br><br>
                        <strong>Certificate No:</strong> ' . $existingCertificate->certificate_number . '<br>
                        <strong>Issue Date:</strong> ' . date('d-m-Y', strtotime($existingCertificate->issued_date)) . '<br><br>
                        Please revoke the existing certificate first before issuing a new one.',
                        'icon' => 'warning',
                    ]
                ]);
            } elseif ($existingCertificate->status === 'revoked') {
                return back()->withInput()->with([
                    'alert' => [
                        'type' => 'question',
                        'title' => 'Certificate Already Exists',
                        'message' => 'A certificate for school <strong>' . $validated['house_number'] . '</strong> already exists but is currently <strong style="color: #856404;">REVOKED</strong>.<br><br>
                <strong>Certificate Number:</strong> ' . $existingCertificate->certificate_number . '<br>
                <strong>Original Issue Date:</strong> ' . date('d-m-Y', strtotime($existingCertificate->issued_date)) . '<br><br>
                Would you like to <strong>reactivate</strong> this existing certificate instead of creating a new one?',
                        'icon' => 'question',
                        'showCancelButton' => true,
                        'confirmButtonText' => 'Yes, Reactivate',
                        'cancelButtonText' => 'No, Cancel',
                        'certificateId' => $existingCertificate->id, // Pass the ID
                    ]
                ]);
            }
        }

        // Check for existing active certificate
        $existingActive = SchoolRecognitionCertificate::where('house_number', $validated['house_number'])
            ->where('status', 'active')
            ->first();

        if ($existingActive) {
            return back()->withInput()->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Active Certificate Exists!',
                    'message' => 'School <strong>' . $validated['house_number'] . '</strong> already has an active certificate.<br><br>
                    <strong>Certificate No:</strong> ' . $existingActive->certificate_number . '<br>
                    <strong>Issue Date:</strong> ' . date('d-m-Y', strtotime($existingActive->issued_date)) . '<br><br>
                    Please revoke the existing certificate first before issuing a new one.',
                    'icon' => 'warning',
                ]
            ]);
        }

        // Create new certificate
        try {
            SchoolRecognitionCertificate::create([
                'house_number' => $validated['house_number'],
                'certificate_number' => $certNumber,
                'issued_date' => $validated['issued_date'],
                'issued_by' => $validated['issued_by'] ?? 'Executive Secretary (ITEBU)',
                'status' => 'active',
                'notes' => $validated['notes'] ?? null,
            ]);

            return redirect()->route('school.recognition.index')
                ->with('success', 'Recognition certificate issued successfully for school ' . $validated['house_number'] . '. Certificate Number: ' . $certNumber);

        } catch (\Exception $e) {
            return back()->withInput()->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Unable to issue certificate. ' . $e->getMessage(),
                    'icon' => 'error',
                ]
            ]);
        }
    }

    public function reactivate($id)
    {
        $certificate = SchoolRecognitionCertificate::findOrFail($id);

        // Check if school already has an active certificate
        $existingActive = SchoolRecognitionCertificate::where('house_number', $certificate->house_number)
            ->where('status', 'active')
            ->where('id', '!=', $id)
            ->first();

        if ($existingActive) {
            return back()->with([
                'swal_error' => true,
                'swal_title' => 'Cannot Re-activate!',
                'swal_text' => 'This school already has an active certificate (<b>' . $existingActive->certificate_number . '</b>).<br><br>Revoke the active one first before re-activating this certificate.',
                'swal_icon' => 'warning',
            ]);
        }

        $certificate->update(['status' => 'active']);

        return back()->with(
            'success',
            'Certificate <b>' . $certificate->certificate_number . '</b> has been re-activated successfully.'
        );
    }

    /**
     * Preview / view a single certificate (admin).
     */
    public function show($id)
    {
        $cert = SchoolRecognitionCertificate::with('house')->findOrFail($id);
        return $this->renderCertificate($cert);
    }

    /**
     * Revoke a certificate.
     */
    public function revoke($id)
    {
        $cert = SchoolRecognitionCertificate::findOrFail($id);
        $cert->update(['status' => 'revoked']);

        return redirect()->route('school.recognition.index')
            ->with('success', 'Certificate No. ' . $cert->certificate_number . ' has been revoked.');
    }

    /**
     * Delete a certificate record entirely.
     */
    public function destroy($id)
    {
        $cert = SchoolRecognitionCertificate::findOrFail($id);
        $cert->delete();

        return redirect()->route('school.recognition.index')
            ->with('success', 'Certificate record deleted.');
    }

    // ─────────────────────────────────────────────
    //  SCHOOL PORTAL SIDE
    // ─────────────────────────────────────────────

    /**
     * School portal: view & download their own recognition certificate.
     */
    public function schoolView()
    {
        $schoolNumber = session('LoggedSchoolCode');

        if (!$schoolNumber) {
            abort(403, 'Unauthorized');
        }

        $cert = SchoolRecognitionCertificate::with('house')
            ->where('house_number', $schoolNumber)
            ->where('status', 'active')
            ->latest('issued_date')
            ->first();

        if (!$cert) {
            return view('Certificates.school-recognition.school-not-issued', [
                'schoolNumber' => $schoolNumber,
                'schoolName' => session('LoggedSchoolName'),
            ]);
        }

        return $this->renderCertificate($cert);
    }

    // ─────────────────────────────────────────────
    //  SHARED RENDERER
    // ─────────────────────────────────────────────

    /**
     * Build the images needed and return the certificate Blade view.
     */
    private function renderCertificate(SchoolRecognitionCertificate $cert)
    {
        $bismillahPath = public_path('assets/basmallah.png');
        $bismillahBase64 = '';
        if (file_exists($bismillahPath)) {
            $bismillahBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($bismillahPath));
        }

        $house = $cert->house;

        // Arabic school name via Helper
        $schoolNameAr = $house->House_AR ?? $house->House;
        $schoolNameEn = $house->House;
        $schoolNumber = $house->Number;
        $location = $house->Location ?? 'Uganda';

        return view('Certificates.school-recognition.certificate', compact(
            'cert',
            'house',
            'schoolNameAr',
            'schoolNameEn',
            'schoolNumber',
            'location',
            'bismillahBase64',
        ));
    }
}