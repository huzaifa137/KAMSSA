{{-- Subject + paper picker for a marks entrant.
$prefix must be unique per modal instance (e.g. "create" / "edit") so
checkbox ids/names don't collide when both modals exist on the page. --}}
<div class="assignment-picker" id="picker-{{ $prefix }}">
    <input type="text" class="form-control form-control-sm mb-2 assignment-search" placeholder="Search subjects..."
        oninput="meFilterAssignments('{{ $prefix }}', this.value)">

    <div class="me-tabs">
        @foreach ($catalog as $code => $group)
            <button type="button" class="me-tab {{ $loop->first ? 'active' : '' }}"
                data-target="me-panel-{{ $prefix }}-{{ $code }}" onclick="meShowTab('{{ $prefix }}', '{{ $code }}')">
                {{ $group['label'] }} <span class="badge bg-light text-dark">{{ $group['subjects']->count() }}</span>
            </button>
        @endforeach
    </div>

    @foreach ($catalog as $code => $group)
        <div class="me-panel" id="me-panel-{{ $prefix }}-{{ $code }}" style="{{ $loop->first ? '' : 'display:none;' }}">
            @if ($group['subjects']->isEmpty())
                <p class="text-muted small mb-0">No {{ $group['label'] }} subjects configured yet.</p>
            @endif
            @foreach ($group['subjects'] as $subject)
                <div class="me-subject-row" data-search="{{ strtolower($subject['name']) }}">
                    <div class="me-subject-name">{{ $subject['name'] }} <span class="text-muted">({{ $subject['code'] }})</span>
                    </div>
                    <div class="me-subject-papers">
                        @if ($subject['total_papers'] <= 1)
                            <label class="me-paper-check">
                                <input type="checkbox" name="assignments[]" value="{{ $subject['id'] }}:1">
                                Assign
                            </label>
                        @else
                            @for ($p = 1; $p <= $subject['total_papers']; $p++)
                                <label class="me-paper-check">
                                    <input type="checkbox" name="assignments[]" value="{{ $subject['id'] }}:{{ $p }}">
                                    P{{ $p }}
                                </label>
                            @endfor
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>