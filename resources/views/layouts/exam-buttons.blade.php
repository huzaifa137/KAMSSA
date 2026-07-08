<div class="row w-100 g-2">
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('all.specific.students') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-user-plus me-2"></i> Create Exams
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('manage.exams') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-cogs me-2"></i> Manage Exams
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('edit.exams') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-check-circle me-2"></i> Edit Exams
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('upload.exams') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-file-upload me-2"></i>
            Upload Exams
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('generate.exams.results') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-chart-line me-2"></i>
            Generate Exam Results
        </a>
    </div>

</div>