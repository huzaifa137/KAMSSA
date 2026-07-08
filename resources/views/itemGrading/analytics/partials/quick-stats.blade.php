<div class="col-md-3 mb-3">
    <div class="card bg-primary text-white h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50">Total Students</h6>
                    <h3 class="mb-0">{{ number_format($stats['total_students']) }}</h3>
                </div>
                <i class="fas fa-users fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="card bg-success text-white h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50">Total Schools</h6>
                    <h3 class="mb-0">{{ number_format($stats['total_schools']) }}</h3>
                </div>
                <i class="fas fa-school fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="card bg-info text-white h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50">Average Score</h6>
                    <h3 class="mb-0">{{ $stats['average_score'] }}%</h3>
                </div>
                <i class="fas fa-chart-line fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="card bg-warning text-white h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50">Pass Rate</h6>
                    <h3 class="mb-0">{{ $stats['pass_rate'] }}%</h3>
                </div>
                <i class="fas fa-check-circle fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
</div>