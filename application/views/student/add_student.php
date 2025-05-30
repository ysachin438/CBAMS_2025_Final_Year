<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <title>Add Student Users</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FBDB93;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #8A2D3B;
            color: white;
            padding: 1rem;
            text-align: center;
            font-size: 24px;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #641B2E;
        }

        .section {
            margin-bottom: 30px;
        }

        input[type="file"] {
            padding: 8px;
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="date"] {
            padding: 6px 8px;
            width: 180px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #BE5B50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 5px;
        }

        button:hover {
            background-color: #8A2D3B;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        .add-row {
            margin-top: 10px;
            background-color: #28a745;
        }

        .add-row:hover {
            background-color: #218838;
        }

        .remove-btn {
            background-color: #dc3545;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {

            input[type="text"],
            input[type="date"] {
                width: 100%;
            }

            table th,
            table td {
                font-size: 14px;
                padding: 6px;
            }
        }
    </style>
</head>

<body>
    <?php if ($this->session->flashdata('toast_message')): ?>
        <div class="toast toast-<?= $this->session->flashdata('toast_type'); ?>">
            <?= $this->session->flashdata('toast_message'); ?>
        </div>
    <?php endif; ?>
    <nav class="navbar">
    <div class="logo">Add Student</div>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Attendance</a></li>
      <li><a href="#">Results</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </nav>

    <div class="container">

        <div class="section">
            <h2>Upload Students via CSV</h2>
            <form action="<?= base_url('students/import_csv') ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="csv_file" accept=".csv" required>
                <button type="submit">Upload CSV</button>
            </form>
            <p>CSV Format: roll_number,name,date_of_birth(YYYY-MM-DD),course</p>
        </div>

        <hr>

        <div class="section">
            <h2>Manually Add Students</h2>
            <form action="<?= base_url('index.php/student/add_student_authenticate') ?>" method="post">
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>Roll Number</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="students[0][roll_number]" required></td>
                            <td><input type="text" name="students[0][first_name]" required></td>
                            <td><input type="text" name="students[0][last_name]" required></td>
                            <td><input type="date" name="students[0][dob]" required></td>
                            <td><input type="text" name="students[0][course]" required></td>
                            <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="add-row" onclick="addRow()">Add Row</button>
                <br><br>
                <button type="submit">Save Students</button>
            </form>
        </div>

    </div>

    <script>
        let rowIndex = 1;

        function addRow() {
            const table = document.getElementById('studentsTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
      <td><input type="text" name="students[${rowIndex}][roll_number]" required></td>
      <td><input type="text" name="students[${rowIndex}][name]" required></td>
      <td><input type="date" name="students[${rowIndex}][dob]" required></td>
      <td><input type="text" name="students[${rowIndex}][course]" required></td>
      <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
    `;
            rowIndex++;
        }

        function removeRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>

</body>

</html>