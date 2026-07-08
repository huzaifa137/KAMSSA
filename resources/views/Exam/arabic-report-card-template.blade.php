<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .report-card {
            box-sizing: border-box;
            width: 19cm;
            height: 27.7cm;
            margin: 0.5cm auto;
            background: white;
            border: 5px solid #FFD700;
            padding: 30px;
            page-break-after: always;
            position: relative;
        }


        .header {
            text-align: center;
            color: #2E7D32;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 22px;
        }

        .motto {
            font-style: italic;
            font-weight: bold;
            margin: 15px 0;
            font-size: 16px;
        }

        .divider {
            border-top: 3px double #000;
            margin-bottom: 10px;
        }

        .title-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .title-box span {
            font-size: 24px;
            font-weight: bold;
            color: #0070C0;
            text-decoration: none;
        }

        /* ===== INFO TABLE (FULL WIDTH & INLINE) ===== */
        /* Update these specific styles in your CSS block */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
            /* Ensures columns stay the size we tell them */
        }

        .info-table td {
            padding: 8px 5px;
            vertical-align: bottom;
            white-space: nowrap;
            /* Prevents text from jumping to the next line */
        }

        .info-label {
            font-weight: bold;
            padding-right: 5px;
        }

        .info-value {
            border-bottom: 1px solid #000;
            display: inline-block;
            flex-grow: 1;
            min-width: 50px;
            /* Ensures there's always a line even if value is empty */
        }

        .info-container {
            display: flex;
            align-items: flex-end;
        }

        /* ===== ACADEMIC TABLE ===== */
        .academic-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }

        .academic-table th,
        .academic-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 13px;
        }

        .subjects-header {
            background-color: #f9f9f9;
            color: #2E7D32;
            font-weight: bold;
        }

        /* ===== COMMENTS ===== */
        .comments {
            margin-top: 20px;
            font-size: 14px;
        }

        .comment-row {
            margin-bottom: 10px;
        }

        .comment-label {
            font-weight: bold;
        }

        .comment-line {
            display: inline-block;
            width: 75%;
            border-bottom: 1px dashed #000;
            margin-left: 8px;
        }

        .footer-motto {
            text-align: center;
            color: #2E7D32;
            font-weight: bold;
            font-style: italic;
            margin-top: 30px;
        }

        .arabic {
            direction: rtl;
            text-align: center;
            font-size: 18px;
        }

        .ltr {
            direction: ltr;
        }

        .info-container.arabic {
            display: flex;
            align-items: flex-end;
            direction: rtl;
            /* forces Arabic right-to-left flow */
            justify-content: flex-start;
        }
    </style>
</head>

<body>
    <?php use App\Http\Controllers\Helper; ?>

    @foreach($students as $studentId => $results)
        @php
            $student = $results->first()->student;
            $totalMarks = $results->sum('marks');
            $average = $results->count() > 0 ? round($totalMarks / $results->count(), 2) : 0;
            $position = $loop->iteration;
        @endphp

        <div class="report-card ltr">

            <div class="header">
                <p class="arabic" style="margin:0;">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                {{-- <h1>{{ $schoolName }}</h1> --}}
                <h1>مدرسة المدينة الإسلامية الثانوية</h1>
                {{-- <p class="motto">"Indeed we can"</p> --}}
                <p class=" arabic">تربية إسلامية شاملة</p>
            </div>

            <div class="divider"></div>

            <div class="title-box">
                <span>كشف الدرجات</span>
            </div>

            <!-- ===== INFO TABLE FULL WIDTH ===== -->

            <div style="direction: rtl; font-family: 'Tahoma', sans-serif; border: 1px solid #000; padding: 15px;">
                <div style="text-align: center; border-bottom: 2px solid #000; margin-bottom: 15px; padding-bottom: 5px;">
                    <h2 style="margin: 0; font-size: 18px;">نتائج امتحان: {{ $examName }}</h2>
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 5px;"><strong>الاسم:</strong> {{ $student->firstname }} {{ $student->lastname }}
                        </td>
                        <td style="padding: 5px; text-align: left;"><strong>التاريخ:</strong> {{ now()->format('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;"><strong>الصف:</strong> {{ $className }}</td>
                        <td style="padding: 5px; text-align: left;"><strong>العدد الكلي:</strong> {{ $students->count() }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="padding: 10px 5px; background: #eee; text-align: center; border-radius: 3px;">
                            <strong>المرتبة الحالية:</strong> <span style="font-size: 18px;">{{ $position }}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ===== ACADEMIC TABLE ===== -->
            <table class="academic-table">
                <thead>
                    <tr class="subjects-header">
                        <th style="width:40%;">المواد</th> <!-- Subjects -->
                        <th>الحد الأقصى</th> <!-- Max -->
                        <th>درجة المادة</th><!-- Subject Score -->
                        <th>الدرجة</th> <!-- Grade -->
                        <th>التعليق</th> <!-- Comment -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    
                        <tr>
                            <td style="text-align:left;">
                                {{ Helper::item_md_name($result->subject_id) }}
                            </td>
                            <td>100</td>
                            <td>{{ $result->marks }}</td>
                            <td>{{ Helper::gradeFromAverage($result->marks) }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr style="font-weight:bold;color:#2E7D32;">
                        <td>المجموع / المتوسط</td>
                        <td colspan="2">{{ $totalMarks }}</td>
                        <td>{{ $average }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- ===== COMMENTS ===== -->
            <div class="comments" style="direction: rtl; margin-top: 30px; font-family: 'Tahoma', sans-serif;">
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 150px; font-weight: bold;">تعليق المعلم:</td>
                        <td style="border-bottom: 2px dotted #000; height: 25px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 150px; font-weight: bold;">تعليق المدير:</td>
                        <td style="border-bottom: 2px dotted #000; height: 25px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 100px; font-weight: bold;">التوقيع:</td>
                        <td style="border-bottom: 2px dotted #000; height: 25px;">&nbsp;</td>
                    </tr>
                </table>
            </div>



            <div class="footer-motto">"Indeed we can"</div>
        </div>
    @endforeach

</body>

</html>