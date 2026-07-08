<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\MasterData;
use App\Models\Mark;
use Carbon\Carbon;
use NumberFormatter;
use App\Models\User;
use App\Models\StudentBasic;
use App\Models\Student;
use App\Models\ClassAllocation;
use App\Models\AcademicYear;

class Helper extends Controller
{

    public static function schoolName($school_id)
    {
        $schoolName = DB::table('houses')
            ->where('Number', $school_id)
            ->value('House');

        return $schoolName;
    }

    public static function schoolRegistrationCode($school_id)
    {
        $registrationCode = DB::table('schools')
            ->where('id', $school_id)
            ->value('registration_code');

        return $registrationCode;
    }

    public static function getschoolIDbyNumber($Number)
    {
        $registrationCode = DB::table('houses')
            ->where('Number', $Number)
            ->value('ID');

        return $registrationCode;
    }

    public static function schoolNumber($school_id)
    {
        $schoolNumber = DB::table('houses')
            ->where('ID', $school_id)
            ->value('Number');

        return $schoolNumber;
    }

    public static function schoolNameByID($school_id)
    {
        $schoolName = DB::table('houses')
            ->where('ID', $school_id)
            ->value('House');

        return $schoolName;
    }


    public static function ar_schoolName($school_id)
    {
        $schoolName = DB::table('houses')
            ->where('Number', $school_id)
            ->value('House_AR');

        return $schoolName;
    }

    public static function subjectName($subject_id)
    {
        $schoolName = DB::table('houses')
            ->where('Number', $subject_id)
            ->value('House');

        return $schoolName;
    }

    public static function user_id()
    {
        return $user = Session::get('LoggedAdmin');
    }

    public static function logged_admin_user()
    {
        if (Session::has('LoggedAdmin')) {
            return User::where('id', Session::get('LoggedAdmin'))
                ->value('name');
        }

        if (Session::has('LoggedStudent')) {
            return User::where('id', Session::get('LoggedStudent'))
                ->value('name');
        }

        return 'Guest';
    }

    public static function student_username($user = "")
    {
        $user = (int) $user;
        return DB::table('users')
            ->where('id', $user)
            ->where('user_role', 1)
            ->value('id');
    }

    public static function get_teacher_name($teacher_id)
    {
        $teacher_id = (int) $teacher_id;

        return DB::table('teachers')
            ->where('id', $teacher_id)
            ->value('firstname') ?? 'No Record Found';
    }

    public static function category_name($user = "")
    {
        $user = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function language_name($user = "")
    {
        $user = (int) $user;
        $admin = DB::table('users')->where('id', '=', $user)->where('user_role', '!=', 1)->first();

        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function active_user()
    {

        $admin = DB::table('users')->where('id', '=', Session('LoggedAdmin'))->first();
        return $user = @$admin->firstname . ' ' . @$admin->lastname;
    }

    public static function item_md_name($md_id)
    {
        $md_name = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->value('md_name');

        return $md_name;
    }

    public static function item_md_id($md_name)
    {
        $md_id = DB::table('master_datas')
            ->where('md_name', $md_name)
            ->value('md_id');

        return $md_id;
    }

    public static function studentStream($studentId)
    {
        $studentStream = DB::table('students')
            ->where('id', $studentId)
            ->value('stream');

        return $studentStream;
    }

    public static function course_information($course_id)
    {
        $courseName = DB::table('courses')
            ->where('id', $course_id)
            ->value('title');

        return $courseName;
    }

    public static function DropMasterData($code_id = "", $selected = "", $id = "", $part = 2, $disabled = 0)
    {

        if (!$code_id) {
            $select = DB::table("master_datas")->get();
        } else {
            $select = DB::table("master_datas")->where("md_master_code_id", $code_id)->orderBy("md_name", "asc")->get();
        }

        $disabled = ($disabled) ? "disabled" : "";

        $string = "";
        $string .= '<select name="' . $id . '" id="' . $id . '" class="form-control select2" ' . $disabled . '>';
        $string .= '<option value=""> -- Select -- </option>';
        foreach ($select as $row) {
            if ($part == 1) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . '</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . '</option>';
                }
            } else if ($part == 2) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                }
            }
        }

        $string .= '</select>';

        return $string;
    }

    public static function DropMasterDataAsc($code_id = "", $selected = "", $id = "", $part = 2, $disabled = 0)
    {

        if (!$code_id) {
            $select = DB::table("master_datas")->get();
        } else {
            $select = DB::table("master_datas")->where("md_master_code_id", $code_id)->orderBy("md_id", "asc")->get();
        }

        $disabled = ($disabled) ? "disabled" : "";

        $string = "";
        $string .= '<select name="' . $id . '" id="' . $id . '" class="form-control" ' . $disabled . '>';
        $string .= '<option value=""> -- Select -- </option>';
        foreach ($select as $row) {
            if ($part == 1) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . '</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . '</option>';
                }
            } else if ($part == 2) {
                if ($row->md_id == $selected) {
                    $string .= '<option selected value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                } else {
                    $string .= '<option value="' . $row->md_id . '">' . $row->md_name . ' (' . $row->md_code . ')</option>';
                }
            }
        }

        $string .= '</select>';

        return $string;
    }

    public static function MasterRecord($md_master_code_id, $md_id)
    {

        $md_id = (string) $md_id;

        $masterRecord = DB::table('master_datas')
            ->where('md_master_code_id', $md_master_code_id)
            ->where('md_id', operator: $md_id)
            ->value('md_name');

        return $masterRecord;
    }

    public static function MasterRecordMdId($md_id)
    {
        $md_id = (string) $md_id;
        $masterRecord = DB::table('master_datas')
            ->where('md_id', operator: $md_id)
            ->value('md_name');

        return $masterRecord;
    }

    public static function recordMdname($md_id)
    {
        $recordName = DB::table('master_datas')
            ->where('md_id', operator: $md_id)
            ->value('md_name');

        return $recordName;
    }


    public static function MasterRecordMerge($item1, $item2)
    {
        $items = [$item1, $item2];

        $records = DB::table('master_datas')
            ->whereIn('md_master_code_id', $items)
            ->get();

        return $records;
    }


    public static function fetchAllSubjects()
    {

        $Technical_Subjects = config('constants.options.TECHNICAL_SUBJECTS');
        $Mathematics = config('constants.options.MATHEMATICS');
        $Languages = config('constants.options.LANGUAGES');
        $Sciences = config('constants.options.SCIENCES');
        $Humanities = config('constants.options.HUMANITIES');

        $items = [$Technical_Subjects, $Mathematics, $Languages, $Sciences, $Humanities];

        $records = DB::table('master_datas')
            ->whereIn('md_master_code_id', $items)
            ->get();

        return $records;
    }


    public static function MasterRecords($md_master_code_id)
    {
        $records = DB::table('master_datas')
            ->where('md_master_code_id', $md_master_code_id)
            ->get();

        return $records;
    }

    public static function schoolStudentsCount($school_id)
    {
        return Student::where('school_id', $school_id)->count();
    }

    public static function db_item_from_column($db_table, $item_id, $item_column)
    {
        $specificItem = DB::table($db_table)
            ->where('id', $item_id)
            ->value($item_column);

        return $specificItem;
    }

    public static function school_student_fullName($user = "")
    {
        $user = (int) $user;

        return DB::table('students')
            ->where('id', $user)
            ->select(DB::raw("CONCAT(firstname, ' ', lastname) as full_name"))
            ->value('full_name');
    }

    public static function current_logged_school($school_id)
    {
        if (is_object($school_id) && isset($school_id->school_id)) {
            $school_id = $school_id->school_id;
        }

        if (is_array($school_id) && isset($school_id['school_id'])) {
            $school_id = $school_id['school_id'];
        }

        return DB::table('schools')
            ->where('id', $school_id)
            ->value('name') ?? 'Unknown School';
    }

    public static function uploadedSchoolExam($school_id, $exam_type)
    {
        return DB::table('exams')
            ->where('school_id', $school_id)
            ->where('academic_year', Helper::active_year())
            ->where('exam_type', $exam_type)
            ->exists();
    }

    public static function active_year()
    {
        $activeYear = AcademicYear::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->value('name');

        return $activeYear ?? 'No Active year Set';
    }

    public static function activeUploadingIdaadYear()
    {
        $activeUploadingYear = DB::table('annual_examinations')
            ->where('examination_name', 'Idaad')
            ->where('is_active', true)
            ->value('year');

        return $activeUploadingYear ?? 'Upload Year Not Set';
    }

    public static function activeUploadingPleYear()
    {
        $activeUploadingYear = DB::table('annual_examinations')
            ->where('examination_name', 'Primary')
            ->where('is_active', true)
            ->value('year');

        return $activeUploadingYear ?? 'Upload Year Not Set';
    }

    public static function activeUploadingThanawiYear()
    {
        $activeUploadingYear = DB::table('annual_examinations')
            ->where('examination_name', 'Thanawi')
            ->where('is_active', true)
            ->value('year');

        return $activeUploadingYear ?? 'Upload Year Not Set';
    }

    public static function parseStudentId($studentId, $type = null)
    {
        $parts = explode('-', $studentId);

        if (count($parts) !== 5) {
            return null;
        }

        $schoolId = "{$parts[0]}-{$parts[1]}";
        $studentIdOnly = "{$parts[2]}-{$parts[3]}";
        $year = $parts[4];

        $Student_Name = StudentBasic::where('Student_ID', $studentId)->value('Student_Name');
        $Student_School = StudentBasic::where('Student_ID', $studentId)->value('House');

        return match ($type) {
            'school' => $Student_School,
            'student' => $Student_Name,
            'year' => $year,
            default => [
                'school' => $Student_School,
                'student' => $Student_Name,
                'year' => $year
            ]
        };
    }

    // Student Information being Fetched From Student Basics

    public static function getStudentName($studentId)
    {

        $Student_Name = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('Student_Name');

        return $Student_Name;
    }

    public static function getStudentYearofBirth($studentId)
    {
        $dateOfBirth = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('Date_of_Birth');

        $year = Carbon::parse($dateOfBirth)->year;
        return $year;
    }

    public static function getStudentAdmissionYear($studentId)
    {
        $AdmissionYear = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('admnyr');

        return $AdmissionYear;
    }

    public static function getStudentARNationality($studentId)
    {

        $StudentNationality = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('StudentsCitizenship');

        return $StudentNationality;
    }

    public static function getStudentNationality($studentId)
    {

        $StudentNationality = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('StudentsNationality');

        return $StudentNationality;
    }

    public static function getStudentARName($studentId)
    {

        $Student_Name = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('Student_Name_AR');

        return $Student_Name;
    }

    public static function getStudentARLevel($studentId)
    {

        $Student_Name = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('Class_AR');

        return $Student_Name;
    }

    public static function getARYear($enYear)
    {
        $enYear = DB::table('translation')
            ->where('NUMBERS', $enYear)
            ->value('TRANSLATION');

        return $enYear;
    }

    public static function getStudentSex($studentId)
    {

        $StudentSex = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('StudentSex');

        return $StudentSex;
    }

    public static function getStudentSchool($studentId)
    {

        $StudentSchool = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('House');

        return $StudentSchool;
    }

    public static function getStudentARSchool($studentId)
    {

        $StudentSchoolEN = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('House');

        $StudentSchoolAR = DB::table('houses')
            ->where('House', $StudentSchoolEN)
            ->value('House_AR');

        return $StudentSchoolAR;
    }

    public static function getStudentID_AR($studentId)
    {

        $StudentID_AR = DB::table('students_basic')
            ->where('Student_ID', $studentId)
            ->value('ID_AR');

        // if ($StudentID_AR == null) {
        //     $StudentID_AR = $studentId;
        // }
        // dd($StudentID_AR);
        return $StudentID_AR;
    }

    public static function getStudentMarksBySubject($studentId, $subjectCode, $category, $year, $schoolNumber)
    {

        $categoryCode = explode('-', $category)[0];

        $masterCodeId = $categoryCode === 'ID' ? 21 : ($categoryCode === 'PLE' ? config('constants.options.PLEPapers') : 20);

        $subjectId = DB::table('master_datas')
            ->where('md_code', $subjectCode)
            ->where('md_master_code_id', $masterCodeId)
            ->value('md_id');

        if (!$subjectId) {
            return null;
        }
        // dd($subjectId);
        // Fetch mark from marks table
        $subjectMark = DB::table('marks')
            ->where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('category', $category)
            ->where('school_number', $schoolNumber)
            ->where('year', $year)
            ->value('mark');

        return $subjectMark;
    }

    public static function numberToArabicDB($enNumber)
    {
        $arNumber = DB::table('translation')
            ->where('NUMBERS', $enNumber)
            ->value('TRANSLATION');

        return $arNumber;
    }

    public static function getPasslipSubjectEnName($subjectsCategory, $subjectCode)
    {
        // subjectsCategory (Either Thanawi Subjects or Idaad Subjects)

        $subjectEnName = DB::table('master_datas')
            ->where('md_master_code_id', $subjectsCategory)
            ->where('md_code', $subjectCode)
            ->value('md_name');

        return $subjectEnName;
    }

    public static function getPasslipSubjectARName($subjectsCategory, $subjectCode)
    {
        // subjectsCategory (Either Thanawi Subjects or Idaad Subjects)

        $subjectARName = DB::table('master_datas')
            ->where('md_master_code_id', $subjectsCategory)
            ->where('md_code', $subjectCode)
            ->value('md_description');

        return $subjectARName;
    }

    public static function calculatePasslipStats($studentId, $subjectCodes, $studentCategory, $year, $schoolId)
    {
        $total = 0;
        $subjectCount = count($subjectCodes);

        // Sum marks for all subjects
        foreach ($subjectCodes as $code) {
            $marks = self::getStudentMarksBySubject($studentId, $code, $studentCategory, $year, $schoolId);
            $total += $marks ?? 0;
        }

        // Calculate average (percentage)
        $average = $subjectCount > 0 ? $total / $subjectCount : 0;

        // Fetch grade from DB based on average (Points type)
        $grade = DB::table('grading')
            ->where('Level', 'A') // or 'O' depending on your context
            ->where('Type', 'Points')
            ->where('From', '<=', $average)
            ->where('To', '>=', $average)
            ->value('Grade');

        return [
            'total' => $total,
            'average' => round($average, 2),
            'grade' => $grade
        ];
    }

    public static function getArabicGradeComment($grade)
    {
        return DB::table('grading')
            ->where('Grade', $grade)
            ->where('Type', 'Points')
            ->value('Comment');
    }

    public static function toArabicDate($date, $format = 'Y-m-d')
    {
        if (empty($date)) {
            return null;
        }

        // Parse the date
        $formatted = Carbon::parse($date)->format($format);

        // Convert English digits to Arabic digits
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $arabic, $formatted);
    }

    public static function toArabicNumberPackge($number)
    {
        $formatter = new NumberFormatter('ar', NumberFormatter::DECIMAL);
        return $formatter->format($number);
    }

    public static function toArabicNumberDate($value)
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $arabic, $value);
    }

    public static function toArabicNumberDateReversed($date)
    {
        // Split the date assuming format d/m/Y
        $parts = explode('/', $date);
        if (count($parts) !== 3)
            return $date; // fallback

        // Reverse to Y/m/d
        $reversed = $parts[2] . '/' . $parts[1] . '/' . $parts[0] . 'م';

        // Map Western digits to Arabic-Indic digits
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $arabic, $reversed);
    }

    public static function toArabicLettersCountriesAndWordsPackage($text)
    {
        $dictionary = [

            // Countries
            'UGANDA' => 'أوغندا',
            'KENYA' => 'كينيا',
            'TANZANIA' => 'تنزانيا',
            'RWANDA' => 'رواندا',
            'BURUNDI' => 'بوروندي',
            'SOUTH SUDAN' => 'جنوب السودان',

            // Cities
            'KAMPALA' => 'كمبالا',
            'JINJA' => 'جينجا',
            'MASAKA' => 'مساكا',
            'MBALE' => 'مبالي',

            // Nationalities
            'UGANDAN' => 'أوغندي',
            'KENYAN' => 'كيني',

            // Gender
            'MALE' => 'ذكر',
            'FEMALE' => 'أنثى',
        ];

        $upper = strtoupper(trim($text));

        // Exact dictionary match
        if (isset($dictionary[$upper])) {
            return $dictionary[$upper];
        }

        // Fallback transliteration
        $special = [
            'TH' => 'ث',
            'PLE' => 'PLE',
            'SH' => 'ش',
            'CH' => 'تش',
            'PH' => 'ف',
            'KH' => 'خ',
            'GH' => 'غ'
        ];

        $text = str_ireplace(
            array_keys($special),
            array_values($special),
            strtoupper($text)
        );

        $map = [
            'A' => 'ا',
            'B' => 'ب',
            'C' => 'ك',
            'D' => 'د',
            'E' => 'ي',
            'F' => 'ف',
            'G' => 'ج',
            'H' => 'ه',
            'I' => 'ي',
            'J' => 'ج',
            'K' => 'ك',
            'L' => 'ل',
            'M' => 'م',
            'N' => 'ن',
            'O' => 'و',
            'P' => 'ب',
            'Q' => 'ق',
            'R' => 'ر',
            'S' => 'س',
            'T' => 'ت',
            'U' => 'و',
            'V' => 'ف',
            'W' => 'و',
            'X' => 'كس',
            'Y' => 'ي',
            'Z' => 'ز',

            '0' => '٠',
            '1' => '١',
            '2' => '٢',
            '3' => '٣',
            '4' => '٤',
            '5' => '٥',
            '6' => '٦',
            '7' => '٧',
            '8' => '٨',
            '9' => '٩',
        ];

        return strtr($text, $map);
    }

    public static function toArabicLettersPackage($text)
    {
        // Handle special letter combinations first
        $special = [
            'TH' => 'ث'
        ];

        // Replace combinations first
        $text = str_ireplace(array_keys($special), array_values($special), strtoupper($text));

        // Single letter + number mapping
        $map = [
            'A' => 'ا',
            'B' => 'ب',
            'C' => 'ك',
            'D' => 'د',
            'E' => 'ي',
            'F' => 'ف',
            'G' => 'ج',
            'H' => 'ه',
            'I' => 'ا',
            'J' => 'ج',
            'K' => 'ك',
            'L' => 'ل',
            'M' => 'م',
            'N' => 'ن',
            'O' => 'و',
            'P' => 'ب',
            'Q' => 'ق',
            'R' => 'ر',
            'S' => 'س',
            'T' => 'ت',
            'U' => 'و',
            'V' => 'ف',
            'W' => 'و',
            'X' => 'كس',
            'Y' => 'ي',
            'Z' => 'ز',

            // Numbers
            '0' => '٠',
            '1' => '١',
            '2' => '٢',
            '3' => '٣',
            '4' => '٤',
            '5' => '٥',
            '6' => '٦',
            '7' => '٧',
            '8' => '٨',
            '9' => '٩'
        ];

        return strtr($text, $map + ['-' => '-']);
    }

    public static function getSubjectIdsForCategory($category)
    {
        if ($category == 'TH') {
            $masterCodeId = config('constants.options.ThanawiPapers');
        } elseif ($category == 'PLE') {
            $masterCodeId = config('constants.options.PLEPapers');
        } else {
            $masterCodeId = config('constants.options.IdaadPapers');
        }

        return MasterData::where('md_master_code_id', $masterCodeId)
            ->pluck('md_id')
            ->toArray();
    }

    public static function getStudentNationalRank($studentId)
    {
        $parts = explode('-', $studentId);
        $year = $parts[4];
        $category = $parts[2];

        // Get all students in the same category and year
        $allStudentIds = ClassAllocation::where('Student_ID', 'LIKE', "%-$category-%")
            ->where('Student_ID', 'LIKE', "%-$year")
            ->distinct('Student_ID')
            ->pluck('Student_ID')
            ->toArray();

        // Get subjects for this category
        $subjectIds = self::getSubjectIdsForCategory($category);

        $totalPossibleMarks = count($subjectIds) * 100;

        // Array to store each student's total marks and percentage
        $studentsWithPercentage = [];

        foreach ($allStudentIds as $sid) {
            // Sum marks for this student only for the relevant subjects and year
            $totalMarks = Mark::where('student_id', $sid)
                ->whereIn('subject_id', $subjectIds)
                ->where('year', $year)
                ->sum('mark');

            if ($totalMarks === 0) {
                continue; // Skip students with no marks
            }

            $percentage = $totalPossibleMarks > 0
                ? ($totalMarks / $totalPossibleMarks) * 100
                : 0;

            $studentsWithPercentage[] = [
                'id' => $sid,
                'percentage' => $percentage
            ];
        }

        // Sort students by percentage descending
        usort($studentsWithPercentage, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        // Find and return the student's national rank
        foreach ($studentsWithPercentage as $index => $student) {
            if ($student['id'] === $studentId) {
                return $index + 1; // Rank is index + 1
            }
        }

        return null; // Student not found
    }

    public static function arabicWordSpacing(?string $text, int $spaces = 1): string
    {
        if (is_null($text) || $text === '')
            return '';
        $words = explode(' ', $text);
        $spacer = str_repeat('&nbsp;', $spaces);
        return implode($spacer, $words);
    }

    public static function academicYears()
    {
        return AcademicYear::orderBy('year_en', 'desc')->get();
    }
}