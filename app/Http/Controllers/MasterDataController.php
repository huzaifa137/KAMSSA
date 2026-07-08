<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DynamicFormValue;
use App\Models\master_code;
use App\Models\User;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MasterDataController extends Controller
{
    //
    public static $page = "MASTER DATA";

    public static $controls = ['V' => 'View', 'A' => 'ADD', 'E' => 'Edit / Modify', 'D' => 'Delete', 'P' => 'Print', 'I' => 'Import', 'X' => 'Export'];

    public static function links()
    {

        $pending = $pending2 = "";

        return $links = [
            [
                "link_name"    => "Master Data " . $pending2,
                "link_address" => "master-data/master-code-list",
                "link_icon"    => "fa-server",
                "link_page"    => self::$page,
                "link_right"   => "V",
            ],
            [
                "link_name"    => "Master Code" . $pending,
                "link_address" => "master-data/master-code-to-data",
                "link_icon"    => "fa-map-pin",
                "link_page"    => self::$page,
                "link_right"   => "V",
            ],
        ];
    }

    public function supplierPrequalificationEvaluationCriteria()
    {
        $documents = DB::table("master_datas")
            ->select('md_id', 'md_name', 'md_misc1', 'md_misc2')
            ->where('md_code', 'PREQUALIFICATION_CRITERIA')
            ->get();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.supplier-prequalification-criteria', $data)
            ->with('documents', $documents)
        ;
    }

    public function storePrequalificationCriteria(Request $request)
    {

        $select = DB::table('master_datas')->where('md_code', 'PREQUALIFICATION_CRITERIA')->where('md_name', $request->supplier_document)->where('md_misc1', $request->category_of_procurement)->get();

        if (count($select)) {
            Alert::error('Error', 'Document already exists');
            return back();
        }

        DB::table('master_datas')->insert(
            [
                'md_master_code_id' => 30075,
                'md_code'           => "PREQUALIFICATION_CRITERIA",
                'md_name'           => $request->supplier_document,
                'md_misc1'          => $request->category_of_procurement,
                'md_misc2'          => $request->mandatory,
            ]
        );

        Alert::success('Success', 'New Criteria has been added successfully');
        return back();
    }

    public function requisitionDocuments()
    {

        $documents = DB::table("master_datas")
            ->select('md_id', 'md_name', 'md_misc1', 'md_misc2')
            ->where('md_master_code_id', 30075)
            ->get();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.requisition-documents', $data)
            ->with('documents', $documents);
    }
    public function documentsToLoadRequisition(Request $request)
    {

        $category = $request->Category;

        //getting business types
        $Documents = DB::table("master_datas")
            ->select('md_id', 'md_name', 'md_misc1', 'md_misc2')
            ->where('md_master_code_id', 30075)
            ->where('md_misc1', $category)
            ->get();

        $string = "";

        $string .= (! count($Documents)) ? " No Documents required for the selected category" : "";
        $counter = 1;
        foreach ($Documents as $document) {
            $mandatory = ($document->md_misc2) ? " (Mandatory)" : "";
            $required  = ($document->md_misc2) ? 'required="required"' : '';
            $string .= '<div class="col-md-6">';
            $string .= '<label for="" class="boldTitle padMarg"
                    class="padMarg">' . $document->md_name . '<span style="color:red; font-weight:bold; ">' . $mandatory . '</span>:</label>';
            $string .= '<input data-name = "' . $document->md_name . '"
                    type="file"
                    name="attachment' . $counter . '"
                    id="attachment' . $counter . '"
                    class="input-sm form-control " ' . $required . '>
            </div>';

            $counter++;
        }

        $string .= '<div class="clearfix"></div><br/>';

        $string .= '<input type="hidden" value="' . ($counter - 1) . '"
        id="Total_Documents" />';

        return response()->json([
            "status"  => true,
            "message" => $string,
        ]);
    }

    public function master_table()
    {

        $mc_code = DB::table('master_datas')
            ->join('master_codes', 'md_master_code_id', '=', 'master_codes.id')
            ->get();

        $controls = self::$controls;
        $pages    = self::$pages;

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.master-data', $data, compact(['mc_code']));
    }

    public function master_code()
    {
        $all_data = DB::table('master_codes')->orderBy('mc_name', 'ASC')->get();
        $data     = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.master-code', $data, compact(['all_data']));
    }

    public function masterCodeToData()
    {

        $all_data = DB::table('master_codes')
            ->orderBy('mc_name', 'ASC')
            ->get();

        $selected = DB::table('master_codes')->get();

        return view('master-logic.master-code-to-data', compact(['all_data']))
            ->with('selected', $selected)
        ;
    }

    public function travelRequisitionDocuments()
    {

        $documents = DB::table("master_datas")
            ->select('md_id', 'md_name', 'md_misc1', 'md_misc2')
            ->where('md_code', 'TRA_DOC')
            ->get();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.travel-requisition-documents', $data)
            ->with('documents', $documents)
        ;
    }

    public function editRecord($md_id)
    {

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        $tb_record = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->get();

        $md_master_code_id = DB::table('master_datas')->where('md_id', $md_id)->pluck('md_master_code_id');
        $md_master_code_id = $md_master_code_id[0];

        $selected = DB::select('select id, mc_name from master_codes');

        if (is_numeric($md_master_code_id)) {

            $master_code_name = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_name');
            $master_code_id   = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_id');

            if (isset($master_code_name[0])) {

                $master_code_name = $master_code_name[0];
                $master_code_id   = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));
            } else {
                $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
                $master_code_id   = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

                $master_code_name = $master_code_name[0];
                $master_code_id   = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));

            }
        } else {
            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id   = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id   = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = $master_code_name[0];
            $master_code_id   = $master_code_id[0];

            return view('master-logic.master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));

        }
    }

    public function addRecord(Request $request)
    {
        $data     = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];
        $selected = DB::select('select id, mc_name from master_codes');

        return view('master-logic.add-record', $data, compact(['selected']));
    }

    public function addMasterCode()
    {
        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];
        return view('master-logic.add-code', $data);
    }

    public function editMasterCode($id)
    {

        $record_code = DB::table('master_codes')
            ->where('id', $id)
            ->get();

        $selected = DB::select('select id, mc_code from master_codes');

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.edit-code', $data, compact(['record_code', 'selected']));
    }

    public function masterCodeList(Request $request)
    {
        $id = $request->id;

        $code_totals = DB::table('master_datas')
            ->select('md_master_code_id', DB::raw('count(md_master_code_id) AS total'))
            ->groupBy('md_master_code_id')
            ->get()
            ->keyBy('md_master_code_id')
            ->toArray();

        $selected = DB::table('master_codes')->orderBy('mc_name', 'ASC')->get();

        $mc_name = "";
        $mc_code = [];

        if (empty($id)) {
            return view('master-logic.master-code-list-select')
                ->with("selected", $selected)
                ->with('mc_id', $id)
                ->with('mc_name', $mc_name)
                ->with('code_totals', $code_totals);
        }

        $mc_code = DB::table('master_datas')
            ->where("mc_id", $id)
            ->leftJoin('master_codes', 'md_master_code_id', '=', 'master_codes.id')
            ->orderBy('md_name', 'ASC')
            ->get();

        $name = DB::table('master_codes')
            ->where("mc_id", $id)
            ->first();

        $mc_name = @$name->mc_name;

        if ($request->ajax()) {
            return DataTables::of($mc_code)
                ->addColumn('action', function ($item) {
                    $links   = [];
                    $links[] = '<a class="dropdown-item" href="' . url('master-data/edit-record/' . $item->md_id) . '"><i class="fa fa-fw fa-edit"></i> Edit</a>';
                    $links[] = '<a onclick="return confirm(\'Are sure you want to delete ' . $item->md_name . '?\'); " class="dropdown-item" href="' . url('delete-record/' . $item->md_id) . '"><i class="fa fa-fw fa-times"></i> Delete</a>';

                    return $this->dropDown($links);
                })
                ->make(true);
        }

        return view('master-logic.master-code-list', compact(['mc_code']))
            ->with("selected", $selected)
            ->with('mc_id', $id)
            ->with('mc_name', $mc_name)
            ->with('code_totals', $code_totals);
    }

    public function dropDown($links)
    {
        return '<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        ' . implode(' ', $links) . '
                    </div>
                </div>';
    }

    public function editSupplierDocument($id)
    {
        $user_data = DB::table('master_datas')
            ->where('md_id', '=', $id)
            ->first();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('master-logic.edit-supplier-document', $data, compact(['user_data']));
    }

    public function addNewRecord(Request $request)
    {
        try {
            $request->validate([
                'master_code_id' => 'required|integer|exists:master_codes,id',
                'md_code'        => 'required|string|max:255',
                'md_name'        => 'required|string|max:255',
                'md_description' => 'nullable|string',
            ]);

            $date    = time();
            $session = Helper::user_id();

            $masterDataId = DB::table('master_datas')->insertGetId([
                'md_master_code_id' => $request->master_code_id,
                'md_code'           => $request->md_code,
                'md_name'           => $request->md_name,
                'md_description'    => $request->md_description,
                'md_date_added'     => $date,
                'md_added_by'       => $session,
            ]);

            $dynamicFormElementsJson = $request->input('dynamic_form_elements');

            $dynamicFormElements = json_decode($dynamicFormElementsJson, true); 

            if (is_array($dynamicFormElements) && ! empty($dynamicFormElements)) {
                foreach ($dynamicFormElements as $fieldName => $fieldData) {
                    $value   = null;
                    $type    = null;
                    $options = null; 

                    if (is_array($fieldData)) {
                        $value = $fieldData['value'] ?? null;
                        if (isset($fieldData['options'])) {
                            $type = 'select';
                                                              
                            $options = $fieldData['options']; 
                                                              
                        }
                    } else {
                        $value = $fieldData;
                        if (str_contains($fieldName, 'dynamic_input_')) {
                            $type = 'input';
                        } elseif (str_contains($fieldName, 'dynamic_textarea_')) {
                            $type = 'textarea';
                        }
                    }

                    if ($type === null) {
                        if (str_contains($fieldName, 'dynamic_input_')) {
                            $type = 'input';
                        } elseif (str_contains($fieldName, 'dynamic_textarea_')) {
                            $type = 'textarea';
                        } elseif (str_contains($fieldName, 'dynamic_select_')) {
                            $type = 'select';
                        }
                    }

                    if ($type) {
                        DynamicFormValue::create([
                            'master_data_id' => $masterDataId,
                            'field_name'     => $fieldName,
                            'field_value'    => $value,
                            'field_type'     => $type,
                            'field_options'  => $options, 
                        ]);
                    }
                }
            }

            return response()->json([
                'success'      => true,
                'message'      => 'Record and dynamic data saved successfully!',
                'redirect_url' => url('master-data/master-code-list/' . $request->master_code_id),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error saving record with dynamic elements: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the record: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteRecord($md_id)
    {

        $masterRecord = DB::table('master_datas')->where('md_id', $md_id)->first();
        $masterCode   = DB::table('master_datas')->where('md_id', $md_id)->value('md_master_code_id');

        $list_id = $this->rgf('master_codes', $masterCode, "id", "mc_code");

        if ($masterCode == config('constants.options.PROCUREMENT_CATEGORY')) {

            $md_code = 'ppd_' . str_replace(' ', '_', strtolower($masterRecord->md_code));
            $md_name = 'ppd_' . str_replace(' ', '_', strtolower($masterRecord->md_name));

            $md_code1 = 'ppt_' . str_replace(' ', '_', strtolower($masterRecord->md_code));
            $md_name2 = 'ppt_' . str_replace(' ', '_', strtolower($masterRecord->md_name));

            if (Schema::hasColumn('procurement_dates', $md_code) || Schema::hasColumn('procurement_dates', $md_name)) {
                Schema::table('procurement_dates', function (Blueprint $table) use ($md_name) {
                    $table->dropColumn($md_name);
                });
            }

            if (Schema::hasColumn('procurement_plan_thresholds', $md_code1) || Schema::hasColumn('procurement_plan_thresholds', $md_name2)) {
                Schema::table('procurement_plan_thresholds', function (Blueprint $table) use ($md_name2) {
                    $table->dropColumn($md_name);
                });
            }
        }

        DB::table('master_datas')
            ->where('md_id', $md_id)
            ->delete();

        return redirect('master-data/master-code-list/' . $list_id)->with('success', 'Record has been deleted successfully');
    }

    public function updateMasterrecord(Request $request)
    {

        $record_id = $request->record_id;

        $list_id = $this->rgf('master_datas', $record_id, "md_id", "md_master_code_id");

        $date    = time();
        $session = Helper::user_id();

        DB::table('master_datas')
            ->where('md_id', $record_id)
            ->update(['md_code' => $request->md_code, 'md_name' => $request->md_name, 'md_description' => $request->md_description, 'md_date_added' => $date, 'md_added_by' => $session]);

        $list_id = $this->rgf('master_codes', $request->md_master_code_id, "mc_id", "mc_code");

        return redirect('master-data/master-code-list/' . $list_id)
            ->with('success', 'Data has been updated successfully')
        ;
    }

    public function sendMasterCode(Request $request)
    {
        $date    = time();
        $session = Helper::user_id();

        $values = ['mc_id' => $request->mc_code, 'mc_code' => $request->mc_code, 'mc_name' => $request->mc_name, 'mc_description' => $request->mc_description, 'mc_date_added' => $date, 'mc_added_by' => $session];

        DB::table('master_codes')->insert($values);

        return redirect('master-data/master-code-to-data')
            ->with('success', 'New data code has been added');
    }

    public function deleteCode($mc_id)
    {
        DB::table('master_codes')
            ->where('mc_id', $mc_id)
            ->delete();

        return redirect('master-data/master-code-to-data')->with('success', 'Code has been deleted successfully');
    }

    public function updateMasterCode(Request $request)
    {

        $mc_id = $request->mc_id;

        $date    = time();
        $session = $request->user_id;

        $master_code = $request->md_master_code_id;
        DB::table('master_codes')
            ->where('mc_id', $mc_id)
            ->update(['mc_id' => $master_code, 'mc_code' => $master_code, 'mc_name' => $request->mc_name, 'mc_description' => $request->mc_description, 'mc_date_added' => $date, 'mc_added_by' => $session]);

        return redirect('master-data/master-code-to-data')->with('success', 'Master Code has been updated successfully');
    }

    public function storeRequisitionDocument(Request $request)
    {

        $select = DB::table('master_datas')->where('md_master_code_id', 30075)->where('md_code', 'REQ_DOC')->where('md_name', $request->supplier_document)->where('md_misc1', $request->category_of_procurement)->get();

        if (count($select)) {
            Alert::error('Error', 'Document already exists');
            return back();
        }

        DB::table('master_datas')->insert(
            [
                'md_master_code_id' => 30075,
                'md_code'           => "REQ_DOC",
                'md_name'           => $request->supplier_document,
                'md_misc1'          => $request->category_of_procurement,
                'md_misc2'          => $request->mandatory,
            ]
        );

        Alert::success('Success', 'New Document has been added successfully');
        return back();
    }

    public function deleteSupplierDocument($id)
    {
        DB::table('master_datas')
            ->where('md_id', '=', $id)
            ->delete();

        Alert::success('Success', 'Document has been deleted successfully');
        return back();
    }

    public function updateSupplierDocument(Request $request)
    {

        $md_md     = $request->md_id;
        $doc       = $request->supplier_document;
        $doc       = $request->supplier_document;
        $category  = $request->category_of_procurement;
        $mandatory = $request->mandatory;

        DB::table('master_datas')
            ->where('md_id', $md_md)
            ->update([
                'md_name'  => $doc,
                'md_misc2' => $mandatory,
                'md_misc1' => $category,
            ]);

        Alert::success('Success', 'Successfully Saved');

        return redirect('master-data/requisition-documents')->with('success', 'Master Code has been updated successfully');
    }

    public function storeTravelRequisitionDocument(Request $request)
    {

        $select = DB::table('master_datas')->where('md_code', 'TRA_DOC')
            ->where('md_name', $request->supplier_document)->get();

        if (count($select)) {
            Alert::error('Error', 'Document already exists');
            return back();
        }

        DB::table('master_datas')->insert(
            [
                'md_master_code_id' => 0001,
                'md_code'           => "TRA_DOC",
                'md_name'           => $request->supplier_document,
                'md_misc2'          => $request->mandatory,
            ]
        );

        Alert::success('Success', 'New Document has been added successfully');
        return back();
    }
}
