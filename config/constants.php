<?php

return [
    'options' => [
        'SCHOOL_PRODUCTS' => 1,
        'SCHOOL_GENDER' => 2,
        'SCHOOL_OWNERSHIP' => 3,
        'REGIONAL_LEVEL' => 4,
        'SCHOOL_POPULATION' => 5,
        'SCHOOL_TYPE' => 6,
        'SCHOOL_TERMS' => 7,
        // 'SCHOOL_OPTIONALS'  => ,

        // SUBJECTS

        'TECHNICAL_SUBJECTS' => 8,
        'OPTIONALS' => 9,
        'VOCATIONALS' => 10,
        'MATHEMATICS' => 11,
        'LANGUAGES' => 12,
        'SCIENCES' => 13,
        'HUMANITIES' => 14,
        'CLASS_STREAMS' => 15,

        // CLASSES

        'O_LEVEL' => 16,
        'A_LEVEL' => 17,
        'PRIMARY_LEVEL' => 18,
        'URPF' => 19,

        // SYSTEM SECTIONS

        // 1.SCHOOOL

        'School' => 16,
        'ThanawiPapers' => 20,
        'IdaadPapers' => 21,
        'ExaminationName' => 22,
        'PLEPapers' => 23,
        'UCEPapers' => 24,
        'UACEPapers' => 25,

    ],
];


// Access specific features (Each of these Add,Delete,Edit,View) ====> Accessing specific user right 
// public static function userHasSpecificPermission($userId, $permissionFeature, $permissionName, $permissionScope)

// Have all Rights for that feauture (All of these Add,Delete,Edit,View) ====> Accessing all user crud
// public static function userHasAllPermissions($userId, $permissionName, $permissionScope)

// Access specific Section in the system (All of these Add,Delete,Edit,View) ====> Accessing all user crud
// public static function userPermissionSectionAccess($userId, $permissionName, $permissionScope)


// if (PermissionHelper::userPermissionSectionAccess(session('LoggedStudent'), 155, 'school')) {

// } else {
//     return redirect()->route('student.dashboard')->with('error', 'You do not have permission to access that feature!');
// }

// @if (PermissionHelper::userPermissionSectionAccess(session('LoggedStudent'), 155, 'school'))
// @else

// @endif

// @if (PermissionHelper::userHasSpecificPermission(session('LoggedStudent'), 'view_155', 155, 'school'))
// @else
// <p style="color: red">Access restricted</p>
// @endif


// Most use ones Logic Implementation
// <<<< For Section and Routes>>>>
// =====> Used on Routes and applied on controllers also to limit the functionality access from that side also
// (Blade and Routes format Implementation)
//  @if (PermissionHelper::userHasSpecificPermission(session('LoggedAdmin'), Helper::getPermissionCode('view', config('constants.module_names')[2]), config('constants.options.Land'), 'school'))
// // (Controller format Implementation)
// Helper::checkPermissionOrAbort(Helper::getPermissionCode('view', config('constants.module_names')[2]), config('constants.options.Land'));

// <<<< For Custom Features Accessibility >>>>
//  @if (PermissionHelper::userHasFeature(session('LoggedAdmin'), config('constants.options.addNewPlots')))

// @if (PermissionHelper::userHasFeature(session('LoggedAdmin'), config('constants.options.addNewPlots')))
//     <li class="nav-item">
//         <a class="nav-link" href="javascript:void();">
//             <i class="mdi mdi-domain ml-1"></i>
//             <span style="padding-left: 2px;">Add New Estate Test</span>
//         </a>
//     </li>
// @endif


// Implementation Easily ===<>=== 


// 1. (VIEW CLOSING ALL)
// 2. (IMPLEMENTATION OF ONE LAYOUT IF NOT EDIT, DELETE, ETC)
// -----------------------------------------------------------------------------------------
// Helper::checkPermissionOrAbort(Helper::getPermissionCode('view', config('constants.module_names')[2]), config('constants.options.Land'));
// Helper::checkCustomPermissionOrAbort(config('constants.options.sellPlots'));
// ----> ADD,EDIT,DELETE,ETC 
// @if (PermissionHelper::userHasSpecificPermission(session('LoggedAdmin'), Helper::getPermissionCode('add', config('constants.module_names')[2]), config('constants.options.Land'), 'school'))