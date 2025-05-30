<div class="container mt-5">
    <h2 class="mb-4 text-dark">Class Schedule</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!empty($schedule)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="text-white" style="background-color: #641B2E;">
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Classroom</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach ($schedule as $row): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= esc($row['course']) ?></td>
                                    <td><?= esc($row['subject']) ?></td>
                                    <td><?= date('d M Y', strtotime($row['date'])) ?></td>
                                    <td><?= date('h:i A', strtotime($row['time'])) ?></td>
                                    <td><?= esc($row['classroom']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert alert-warning">No class schedules found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
