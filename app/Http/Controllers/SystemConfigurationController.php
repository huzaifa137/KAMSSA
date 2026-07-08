<?php

namespace App\Http\Controllers;

use App\Models\ExaminationCategory;
use App\Models\ExaminationLevel;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

/**
 * Everything a new client needs to re-brand and re-configure this system
 * without touching a single line of code lives behind this controller:
 *
 *  - System identity (name, acronym, logo, contact details)
 *  - Examination Categories (e.g. Islamic Mock, Primary Mock, Secondary Mock)
 *  - Examination Levels per category (e.g. Idaad/Thanawi, PLE, UCE/UACE)
 *
 * Academic Years already have their own module (AcademicYearController) and
 * are simply linked to from the System Configuration hub.
 */
class SystemConfigurationController extends Controller
{
    public static $page = "SYSTEM CONFIGURATION";

    /**
     * The System Configuration hub / landing page.
     */
    public function index()
    {
        $settings   = SystemSetting::current();
        $categories = ExaminationCategory::allWithLevels();

        return view('system-configuration.index', compact('settings', 'categories'));
    }

    /* ===================== SYSTEM IDENTITY / BRANDING ===================== */

    public function updateSettings(Request $request)
    {
        $request->validate([
            'system_name' => 'required|string|max:255',
            'short_name'  => 'required|string|max:30',
            'system_name_ar' => 'nullable|string|max:255',
            'tagline'     => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:255',
            'website'     => 'nullable|string|max:255',
            'footer_text' => 'nullable|string',
            'portal_welcome_text' => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'favicon'     => 'nullable|image|max:1024',
        ]);

        $settings = SystemSetting::current();

        $data = $request->only([
            'system_name', 'system_name_ar', 'short_name', 'tagline',
            'address', 'phone', 'email', 'website',
            'footer_text', 'portal_welcome_text',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('branding', 'public');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon_path'] = $request->file('favicon')->store('branding', 'public');
        }

        $settings->update($data);

        Alert::success('Success', 'System settings have been updated successfully');
        return back();
    }

    /* ===================== EXAMINATION CATEGORIES ===================== */

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:examination_categories,code',
        ]);

        ExaminationCategory::create([
            'name'       => $request->name,
            'code'       => strtoupper(str_replace(' ', '_', $request->code)),
            'name_ar'    => $request->name_ar,
            'description'=> $request->description,
            'sort_order' => (int) $request->sort_order,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        Alert::success('Success', 'Examination category added successfully');
        return back();
    }

    public function updateCategory(Request $request, ExaminationCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:examination_categories,code,' . $category->id,
        ]);

        $category->update([
            'name'       => $request->name,
            'code'       => strtoupper(str_replace(' ', '_', $request->code)),
            'name_ar'    => $request->name_ar,
            'description'=> $request->description,
            'sort_order' => (int) $request->sort_order,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        Alert::success('Success', 'Examination category updated successfully');
        return back();
    }

    public function destroyCategory(ExaminationCategory $category)
    {
        $category->delete(); // levels cascade-delete
        Alert::success('Success', 'Examination category deleted successfully');
        return back();
    }

    /* ===================== EXAMINATION LEVELS ===================== */

    public function storeLevel(Request $request)
    {
        $request->validate([
            'examination_category_id' => 'required|exists:examination_categories,id',
            'name'       => 'required|string|max:255',
            'short_code' => 'required|string|max:20',
        ]);

        ExaminationLevel::create([
            'examination_category_id' => $request->examination_category_id,
            'name'        => $request->name,
            'name_ar'     => $request->name_ar,
            'short_code'  => strtoupper($request->short_code),
            'description' => $request->description,
            'sort_order'  => (int) $request->sort_order,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        Alert::success('Success', 'Examination level added successfully');
        return back();
    }

    public function updateLevel(Request $request, ExaminationLevel $level)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'short_code' => 'required|string|max:20',
        ]);

        $level->update([
            'name'        => $request->name,
            'name_ar'     => $request->name_ar,
            'short_code'  => strtoupper($request->short_code),
            'description' => $request->description,
            'sort_order'  => (int) $request->sort_order,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        Alert::success('Success', 'Examination level updated successfully');
        return back();
    }

    public function destroyLevel(ExaminationLevel $level)
    {
        $level->delete();
        Alert::success('Success', 'Examination level deleted successfully');
        return back();
    }
}
