
    <div class="container my-4">
        <h3 class="mb-3 text-dark"><?= isset($title) ? htmlspecialchars($title) : 'View Attendance' ?></h3>

        <!-- Filter Form -->
        <form method="get" action="<?= site_url('teacher/view_attendance') ?>" class="mb-4 card p-3 shadow-sm rounded" style="background: rgba(255,255,255,0.9);">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="class_id" class="form-label">Class</label>
                    <select name="class_id" id="class_id" class="form-select">
                        <option value="">-- All Classes --</option>
                        <?php if (!empty($classes)): ?>
                            <?php foreach ($classes as $class_item): ?>
                                <option value="<?= htmlspecialchars($class_item->class_id) ?>" <?= ($selected_class_id == $class_item->class_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class_item->class_name) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">-- All Subjects --</option>
                         <?php if (!empty($subjects)): ?>
                            <?php foreach ($subjects as $subject_item): ?>
                                <option value="<?= htmlspecialchars($subject_item->subject_id) ?>" <?= ($selected_subject_id == $subject_item->subject_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject_item->name) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?= htmlspecialchars($selected_from_date ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?= htmlspecialchars($selected_to_date ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="background-color: #BE5B50; border: none;">🔍 Filter</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 text-end">
                     <a href="<?= site_url('teacher/view_attendance') ?>" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
                </div>
            </div>
        </form>

        <!-- Attendance Table -->
        <div class="card p-3 shadow-sm rounded" style="background: rgba(255,255,255,0.85);">
            <h5 class="text-dark mb-3">Attendance Records</h5>
            <?php if (!empty($report_data)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>S.No</th>
                                <th>Student Name</th>
                                <th>Roll Number</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($report_data as $record): ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($record['student_name'] ?? 'N/A') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($record['roll_number'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($record['class_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($record['subject_name'] ?? 'N/A') ?></td>
                                    <td class="text-center"><?= isset($record['attendance_date']) ? htmlspecialchars(date('d M, Y', strtotime($record['attendance_date']))) : 'N/A' ?></td>
                                    <td class="text-center">
                                        <?php
                                        $status = $record['status'] ?? 'N/A';
                                        $badge_class = 'bg-secondary'; // Default
                                        if ($status == 'Present') {
                                            $badge_class = 'bg-success';
                                        } elseif ($status == 'Absent') {
                                            $badge_class = 'bg-danger';
                                        } elseif ($status != 'N/A') {
                                            $badge_class = 'bg-warning text-dark'; // For other statuses like 'Leave'
                                        }
                                        ?>
                                        <span class="badge <?= $badge_class ?>"><?= htmlspecialchars($status) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    No attendance records found for the selected filters. Please try adjusting your criteria or <a href="<?= site_url('teacher/get_mark_attendance') ?>" class="alert-link">mark attendance</a> if none has been recorded.
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        // Placeholder for your exportCSV function if it's not globally defined
        // function exportCSV() {
        //     console.log('exportCSV function called');
        //     // Implement your CSV export logic here
        //     // For example, you might gather data from the table and format it as CSV
        // }

        // You might also want to add JavaScript to dynamically load subjects based on class selection.
    </script>
