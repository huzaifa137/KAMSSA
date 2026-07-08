<?php

use App\Models\ExaminationCategory;
use App\Models\ExaminationLevel;
use App\Models\SystemSetting;

/**
 * These helpers exist so that Controllers, PDF/certificate templates
 * (mPDF, DomPDF, etc.) and anything else outside of a normal Blade view
 * can also pull the client's current branding / examination setup
 * without hardcoding text.
 */

if (! function_exists('system_settings')) {
    function system_settings(): ?SystemSetting
    {
        try {
            return SystemSetting::current();
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (! function_exists('system_name')) {
    function system_name(): string
    {
        return system_settings()->system_name ?? 'Kampala Integrated Secondary Schools Examination';
    }
}

if (! function_exists('system_short_name')) {
    function system_short_name(): string
    {
        return system_settings()->short_name ?? 'KAMSSA';
    }
}

if (! function_exists('system_logo_url')) {
    function system_logo_url(): string
    {
        $settings = system_settings();
        return $settings ? $settings->logo_url : asset('assets/images/brand/logo.png');
    }
}

if (! function_exists('examination_categories')) {
    function examination_categories()
    {
        try {
            return ExaminationCategory::allWithLevels();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}

if (! function_exists('examination_levels')) {
    /**
     * Flat list of every active examination level, e.g. for building a
     * simple <select> without caring which category it belongs to.
     */
    function examination_levels()
    {
        try {
            return ExaminationLevel::activeFlat();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}

if (! function_exists('examination_level_name')) {
    /**
     * Resolve a stored short_code (e.g. "TH", "ID", "UCE") back to its
     * display name, e.g. for old records saved before the module
     * existed. Falls back to the raw code if not found.
     */
    function examination_level_name(?string $code): string
    {
        if (! $code) {
            return '';
        }

        $level = ExaminationLevel::findByCode($code);
        return $level ? $level->name : $code;
    }
}
