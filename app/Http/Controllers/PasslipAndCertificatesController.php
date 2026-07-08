<?php

namespace App\Http\Controllers;
use App\Models\Mark;
use App\Models\House;
use App\Models\MasterData;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
class PasslipAndCertificatesController extends Controller
{
    public function generatePasslip()
    {
        $houses = House::select('Number', 'House', 'House_AR')->get();
        return view('Certificates.generate-certificate', compact('houses'));
    }

    public function fetchSchoolRecords(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'category' => 'required|in:TH,ID,PLE',
            'school_number' => 'required|string'
        ]);

        $year = $validated['year'];
        $category = $validated['category'];
        $schoolNumber = $validated['school_number'];

        $pattern = $schoolNumber . '-' . $category . '-%';

        $classAllocations = \DB::table('class_allocation')
            ->where('Student_ID', 'LIKE', $pattern)
            ->where('Student_ID', 'LIKE', '%-' . $year)
            ->get();

        $groupedByStudent = $classAllocations->groupBy('Student_ID');

        return view('Certificates.fetched-records', [
            'houses' => House::all(),
            'groupedByStudent' => $groupedByStudent,
            'totalRecords' => $classAllocations->count(),
            'totalStudents' => $groupedByStudent->count(),
            'filters' => [
                'year' => $year,
                'category' => $category,
                'school_number' => $schoolNumber
            ]
        ]);
    }

    public function downloadPasslip($studentId)
    {

        $parts = explode('-', $studentId);
        $schoolId = $parts[0] . '-' . $parts[1];
        $studentCategory = $parts[2] . '-' . $parts[3];
        $year = $parts[4];

        $categoryCode = explode('-', $studentCategory)[0]; // This will show "ID" or "TH" 

        if ($categoryCode == "TH") {
            $categories = [
                ['title_en' => 'ARABIC LANGUAGE', 'title_ar' => 'اللغة العربية', 'codes' => ['AR-004', 'AR-002', 'AR-003', 'AR-001']],
                ['title_en' => 'FAITH & CIVILIZATION', 'title_ar' => 'العقيدة والحضارة', 'codes' => ['FC-006', 'FC-005', 'FC-007']],
                ['title_en' => 'JURISPRUDENCE & ITS SOURCES', 'title_ar' => 'الفقه وأصوله', 'codes' => ['JS-009', 'JS-008', 'JS-010']],
                ['title_en' => 'PROPHETIC TRADITIONS', 'title_ar' => 'السنة', 'codes' => ['PT-013', 'PT-012']],
                ['title_en' => 'QURAN & ITS SCIENCES', 'title_ar' => 'القرآن وعلومه', 'codes' => ['QS-015', 'QS-016', 'QS-014']],
            ];

            $subjects = MasterData::where('md_master_code_id', config('constants.options.ThanawiPapers'))
                ->get()
                ->keyBy('md_code');

            // Render the Blade template as HTML
            $html = view('template', compact(
                'studentId',
                'schoolId',
                'studentCategory',
                'year',
                'categories',
                'subjects',
                'categoryCode',
            ))->render();

            // Generate PDF with html2pdf
            return view('template', compact(
                'studentId',
                'schoolId',
                'studentCategory',
                'year',
                'categories',
                'subjects',
                'categoryCode',
            ));
        } elseif ($categoryCode == "PLE") {

            $subjects = MasterData::where('md_master_code_id', config('constants.options.PLEPapers'))
                ->get()
                ->keyBy('md_code');

            // Build codes array dynamically from actual PLE subjects in master data
            $pleCodes = $subjects->keys()->toArray();

            $categories = [
                [
                    'title_en' => 'PRIMARY SUBJECTS',
                    'title_ar' => 'المواد الابتدائية',
                    'codes' => $pleCodes,
                ],
            ];

            return view('template', compact(
                'studentId',
                'schoolId',
                'studentCategory',
                'year',
                'categories',
                'subjects',
                'categoryCode',
            ));
        } else {
            $categories = [
                ['title_en' => 'ARABIC LANGUAGE', 'title_ar' => 'اللغة العربية', 'codes' => ['AR-002', 'AR-003', 'AR-004']],
                ['title_en' => 'FAITH & CIVILIZATION', 'title_ar' => 'العقيدة والحضارة', 'codes' => ['FC-005', 'FC-007']],
                ['title_en' => 'JURISPRUDENCE & ITS SOURCES', 'title_ar' => 'الفقه وأصوله', 'codes' => ['JS-011']],
                ['title_en' => 'PROPHETIC TRADITIONS', 'title_ar' => 'السنة', 'codes' => ['PT-013']],
                ['title_en' => 'QURAN & ITS SCIENCES', 'title_ar' => 'القرآن وعلومه', 'codes' => ['QS-017', 'QS-015', 'QS-016',]],
            ];

            $subjects = MasterData::where('md_master_code_id', config('constants.options.IdaadPapers'))
                ->get()
                ->keyBy('md_code');

            // Render the Blade template as HTML
            $html = view('template', compact(
                'studentId',
                'schoolId',
                'studentCategory',
                'year',
                'categories',
                'subjects',
                'categoryCode',
            ))->render();

            // Generate PDF with html2pdf
            return view('template', compact(
                'studentId',
                'schoolId',
                'studentCategory',
                'year',
                'categories',
                'subjects',
                'categoryCode',
            ));
        }
    }

    public function downloadertificate($studentId)
    {
        $parts = explode('-', $studentId);
        $schoolId = $parts[0] . '-' . $parts[1];
        $studentCategory = $parts[2] . '-' . $parts[3];
        $year = $parts[4];

        $categoryParts = explode('-', $studentCategory);
        $firstLetters = $categoryParts[0];
        $categoryCode = $categoryParts[0];

        $rank = Helper::getStudentNationalRank($studentId);

        if ($firstLetters === 'TH') {
            $subYear = substr($parts[4], -2);
            $snoRank = '2' . $subYear . $rank;
        } elseif ($firstLetters === 'PLE') {
            $subYear = substr($parts[4], -2);
            $snoRank = '3' . $subYear . $rank;
        } else {
            $subYear = substr($parts[4], -2);
            $snoRank = '1' . $subYear . $rank;
        }

        if ($firstLetters == 'ID') {
            $level = "O'LEVEL";
            $ArLevel = 'الإعدادية';
            $allSubjectCodes = DB::table('master_datas')
                ->where('md_master_code_id', config('constants.options.IdaadPapers'))
                ->pluck('md_code');
        } elseif ($firstLetters == 'PLE') {
            $level = "PRIMARY LEVEL";
            $ArLevel = 'الابتدائية';
            $allSubjectCodes = DB::table('master_datas')
                ->where('md_master_code_id', config('constants.options.PLEPapers'))
                ->pluck('md_code');
        } else {
            $level = "A'LEVEL";
            $ArLevel = 'الثانوية';
            $allSubjectCodes = DB::table('master_datas')
                ->where('md_master_code_id', config('constants.options.ThanawiPapers'))
                ->pluck('md_code');
        }

        $stats = Helper::calculatePasslipStats(
            $studentId,
            $allSubjectCodes,
            $studentCategory,
            $year,
            $schoolId,
        );

        $studentRegisteredname = Helper::getStudentName($studentId);
        $studentRegisteredNumber = $studentId;
        $studentAchievedGrade = $stats['grade'];

        if (strtoupper($stats['grade']) === 'FAIL' || strtoupper($stats['grade']) === 'F') {
            if (request()->has('bulk')) {
                return response('<html><body data-skipped="true"></body></html>', 200)
                    ->header('Content-Type', 'text/html');
            }
            return response()->view('errors.certificate-failed', [
                'studentId' => $studentId,
                'studentName' => Helper::getStudentName($studentId),
            ], 200);
        }

        $bismillahPath = public_path('assets/certificates/bismillah.jpg');
        $bismillahBase64 = '';
        if (file_exists($bismillahPath)) {
            $bismillahBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($bismillahPath));
        }

        // QR INFORMATIRON

        return view('Certificates.certificate', compact(
            'studentId',
            'schoolId',
            'studentCategory',
            'year',
            'level',
            'ArLevel',
            'snoRank',
            'categoryCode',
            'bismillahBase64',
            'studentRegisteredname',
            'studentRegisteredNumber',
            'studentAchievedGrade',
        ));
    }

    public function uploadStudentPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png',
            'studentId' => 'required'
        ]);

        $studentId = $request->studentId;
        $file = $request->file('photo');
        $path = public_path('assets/student_photos');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $studentId . '.jpg');

        return response()->json(['success' => true])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
