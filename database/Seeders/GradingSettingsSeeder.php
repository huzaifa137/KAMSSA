<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradingSettingsSeeder extends Seeder
{
    // php artisan db:seed --class=GradingSettingsSeeder      (running this seeder)
    public function run(): void
    {
        $data = [

            // PLE MARKS
            ['category'=>'PLE','grade'=>'D1','from_mark'=>80,'to_mark'=>100,'comment'=>'Distinction 1','type'=>'Marks','weight'=>1,'sort_order'=>1],
            ['category'=>'PLE','grade'=>'D2','from_mark'=>65,'to_mark'=>79.99,'comment'=>'Distinction 2','type'=>'Marks','weight'=>2,'sort_order'=>2],
            ['category'=>'PLE','grade'=>'C3','from_mark'=>55,'to_mark'=>64.99,'comment'=>'Credit 3','type'=>'Marks','weight'=>3,'sort_order'=>3],
            ['category'=>'PLE','grade'=>'C4','from_mark'=>45,'to_mark'=>54.99,'comment'=>'Credit 4','type'=>'Marks','weight'=>4,'sort_order'=>4],
            ['category'=>'PLE','grade'=>'P5','from_mark'=>35,'to_mark'=>44.99,'comment'=>'Pass 5','type'=>'Marks','weight'=>5,'sort_order'=>5],
            ['category'=>'PLE','grade'=>'P6','from_mark'=>25,'to_mark'=>34.99,'comment'=>'Pass 6','type'=>'Marks','weight'=>6,'sort_order'=>6],
            ['category'=>'PLE','grade'=>'F7','from_mark'=>0,'to_mark'=>24.99,'comment'=>'Fail','type'=>'Marks','weight'=>7,'sort_order'=>7],

            // PLE POINTS
            ['category'=>'PLE','grade'=>'FIRST CLASS','from_mark'=>80,'to_mark'=>100,'comment'=>'First Class','type'=>'Points','weight'=>1,'sort_order'=>1],
            ['category'=>'PLE','grade'=>'SECOND CLASS','from_mark'=>60,'to_mark'=>79.99,'comment'=>'Second Class','type'=>'Points','weight'=>2,'sort_order'=>2],
            ['category'=>'PLE','grade'=>'THIRD CLASS','from_mark'=>40,'to_mark'=>59.99,'comment'=>'Third Class','type'=>'Points','weight'=>3,'sort_order'=>3],
            ['category'=>'PLE','grade'=>'PASS','from_mark'=>25,'to_mark'=>39.99,'comment'=>'Pass','type'=>'Points','weight'=>4,'sort_order'=>4],
            ['category'=>'PLE','grade'=>'FAIL','from_mark'=>0,'to_mark'=>24.99,'comment'=>'Fail','type'=>'Points','weight'=>5,'sort_order'=>5],

            // UCE (O-LEVEL) MARKS
            ['category'=>'UCE','grade'=>'D1','from_mark'=>90,'to_mark'=>100,'comment'=>'Distinction 1','type'=>'Marks','weight'=>1,'sort_order'=>1],
            ['category'=>'UCE','grade'=>'D2','from_mark'=>80,'to_mark'=>89.99,'comment'=>'Distinction 2','type'=>'Marks','weight'=>2,'sort_order'=>2],
            ['category'=>'UCE','grade'=>'C3','from_mark'=>70,'to_mark'=>79.99,'comment'=>'Credit 3','type'=>'Marks','weight'=>3,'sort_order'=>3],
            ['category'=>'UCE','grade'=>'C4','from_mark'=>60,'to_mark'=>69.99,'comment'=>'Credit 4','type'=>'Marks','weight'=>4,'sort_order'=>4],
            ['category'=>'UCE','grade'=>'C5','from_mark'=>50,'to_mark'=>59.99,'comment'=>'Credit 5','type'=>'Marks','weight'=>5,'sort_order'=>5],
            ['category'=>'UCE','grade'=>'C6','from_mark'=>40,'to_mark'=>49.99,'comment'=>'Credit 6','type'=>'Marks','weight'=>6,'sort_order'=>6],
            ['category'=>'UCE','grade'=>'P7','from_mark'=>30,'to_mark'=>39.99,'comment'=>'Pass 7','type'=>'Marks','weight'=>7,'sort_order'=>7],
            ['category'=>'UCE','grade'=>'P8','from_mark'=>20,'to_mark'=>29.99,'comment'=>'Pass 8','type'=>'Marks','weight'=>8,'sort_order'=>8],
            ['category'=>'UCE','grade'=>'F9','from_mark'=>0,'to_mark'=>19.99,'comment'=>'Fail 9','type'=>'Marks','weight'=>9,'sort_order'=>9],

            // UCE (O-LEVEL) DIVISIONS
            ['category'=>'UCE','grade'=>'DIVISION I','from_mark'=>80,'to_mark'=>100,'comment'=>'Division One','type'=>'Points','weight'=>1,'sort_order'=>1],
            ['category'=>'UCE','grade'=>'DIVISION II','from_mark'=>60,'to_mark'=>79.99,'comment'=>'Division Two','type'=>'Points','weight'=>2,'sort_order'=>2],
            ['category'=>'UCE','grade'=>'DIVISION III','from_mark'=>45,'to_mark'=>59.99,'comment'=>'Division Three','type'=>'Points','weight'=>3,'sort_order'=>3],
            ['category'=>'UCE','grade'=>'DIVISION IV','from_mark'=>30,'to_mark'=>44.99,'comment'=>'Division Four','type'=>'Points','weight'=>4,'sort_order'=>4],
            ['category'=>'UCE','grade'=>'UNGRADED','from_mark'=>0,'to_mark'=>29.99,'comment'=>'Ungraded (U)','type'=>'Points','weight'=>5,'sort_order'=>5],

            // UACE (A-LEVEL) MARKS
            ['category'=>'UACE','grade'=>'A','from_mark'=>80,'to_mark'=>100,'comment'=>'Distinction (6 pts)','type'=>'Marks','weight'=>1,'sort_order'=>1],
            ['category'=>'UACE','grade'=>'B','from_mark'=>70,'to_mark'=>79.99,'comment'=>'Very Good (5 pts)','type'=>'Marks','weight'=>2,'sort_order'=>2],
            ['category'=>'UACE','grade'=>'C','from_mark'=>60,'to_mark'=>69.99,'comment'=>'Good (4 pts)','type'=>'Marks','weight'=>3,'sort_order'=>3],
            ['category'=>'UACE','grade'=>'D','from_mark'=>50,'to_mark'=>59.99,'comment'=>'Fairly Good (3 pts)','type'=>'Marks','weight'=>4,'sort_order'=>4],
            ['category'=>'UACE','grade'=>'E','from_mark'=>40,'to_mark'=>49.99,'comment'=>'Satisfactory (2 pts)','type'=>'Marks','weight'=>5,'sort_order'=>5],
            ['category'=>'UACE','grade'=>'O','from_mark'=>30,'to_mark'=>39.99,'comment'=>'Subsidiary Pass (1 pt)','type'=>'Marks','weight'=>6,'sort_order'=>6],
            ['category'=>'UACE','grade'=>'F','from_mark'=>0,'to_mark'=>29.99,'comment'=>'Fail (0 pts)','type'=>'Marks','weight'=>7,'sort_order'=>7],

            // UACE (A-LEVEL) CLASSIFICATION
            ['category'=>'UACE','grade'=>'FIRST CLASS','from_mark'=>80,'to_mark'=>100,'comment'=>'First Class','type'=>'Points','weight'=>1,'sort_order'=>1],
            ['category'=>'UACE','grade'=>'SECOND CLASS UPPER','from_mark'=>65,'to_mark'=>79.99,'comment'=>'Second Class (Upper)','type'=>'Points','weight'=>2,'sort_order'=>2],
            ['category'=>'UACE','grade'=>'SECOND CLASS LOWER','from_mark'=>50,'to_mark'=>64.99,'comment'=>'Second Class (Lower)','type'=>'Points','weight'=>3,'sort_order'=>3],
            ['category'=>'UACE','grade'=>'PASS','from_mark'=>35,'to_mark'=>49.99,'comment'=>'Pass','type'=>'Points','weight'=>4,'sort_order'=>4],
            ['category'=>'UACE','grade'=>'FAIL','from_mark'=>0,'to_mark'=>34.99,'comment'=>'Fail','type'=>'Points','weight'=>5,'sort_order'=>5],
        ];

        $now = now();

        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }

        // Upsert so re-running this seeder (e.g. after adding a new category
        // such as UCE/UACE) does not fail on already-seeded rows.
        DB::table('grading_settings')->upsert(
            $data,
            ['category', 'grade', 'type'],
            ['from_mark', 'to_mark', 'comment', 'weight', 'sort_order', 'updated_at']
        );
    }
}