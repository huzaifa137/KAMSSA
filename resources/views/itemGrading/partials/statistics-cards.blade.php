<div class="col-md-3">
    <div class="card bg-primary text-white">
        <div class="card-body">
            <h6>Total Students</h6>
            <h3>{{ $statistics['total_students'] ?? 0 }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card bg-success text-white">
        <div class="card-body">
            <h6>Average Performance</h6>
            <h3>{{ number_format($statistics['avg_percentage'] ?? 0, 1) }}%</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card bg-warning text-white">
        <div class="card-body">
            <h6>Highest Score</h6>
            <h3>{{ number_format($statistics['max_percentage'] ?? 0, 1) }}%</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card bg-info text-white">
        <div class="card-body">
            <h6>Pass Rate</h6>
            <h3>{{ number_format($statistics['pass_rate'] ?? 0, 1) }}%</h3>
        </div>
    </div>
</div>