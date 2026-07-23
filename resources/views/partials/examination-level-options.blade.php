{{--
    Reusable Examination Level <option> list.

    Renders <option> tags for every active Examination Level, driven
    entirely by the System Configuration module (System Configuration >
    Examination Categories). This replaces hardcoded blocks like:

        <option value="UCE">O-LEVEL - UCE</option>
        <option value="UACE">A-LEVEL - UACE</option>

    Usage:
        <select name="category">
            @include('partials.examination-level-options')
        </select>

    Optional variables you can pass in:
        selected        - the currently selected short_code (string)
        category_code   - limit the list to one Examination Category's
                           code, e.g. 'SECONDARY_MOCK'. Omit to list
                           every active level across all categories.
        show_group      - (default true) wrap each category's levels in
                           an <optgroup> labelled with the category name.
--}}
@php
    $selected      = $selected ?? old('category');
    $showGroup     = $show_group ?? true;
    $categoryList  = $examinationCategories ?? \App\Models\ExaminationCategory::allWithLevels();

    if (!empty($category_code)) {
        $categoryList = $categoryList->where('code', $category_code);
    }
@endphp

@forelse ($categoryList as $cat)
    @if ($cat->activeLevels->count())
        @if ($showGroup)
            <optgroup label="{{ $cat->name }}">
        @endif

        @foreach ($cat->activeLevels as $lvl)
            <option value="{{ $lvl->short_code }}" {{ (string) $selected === (string) $lvl->short_code ? 'selected' : '' }}>
                {{ $lvl->name }} - {{ $lvl->short_code }}
            </option>
        @endforeach

        @if ($showGroup)
            </optgroup>
        @endif
    @endif
@empty
    <option value="" disabled>No examination levels configured yet</option>
@endforelse
