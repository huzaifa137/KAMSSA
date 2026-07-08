{{-- <div class="row w-100 g-2">
    <div class="col-12 col-sm-4 mb-2">
        <a  class="btn btn-white text-dark w-100">
            <i class="fas fa-search me-2"></i> Search Student
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('all.students.dashboard') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-user-plus me-2"></i> Add Students
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.all.students') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-users me-2"></i> All Students
        </a>
    </div>
</div> --}}


<div class="row w-100 g-2">
    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.individual.search') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-search me-2"></i> Search Student
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{ route('students.add.new.student') }}" class="btn btn-white text-dark w-100">
            <i class="fas fa-user-plus me-2"></i> Add Students
        </a>
    </div>

    <div class="col-12 col-sm-4 mb-2">
        <a href="{{route('students.all.students')}}" class="btn btn-white text-dark w-100">
            <i class="fas fa-users me-2"></i> All Students
        </a>
    </div>
</div>
