<?php
session_start();
include ("../backend/conn.php");

if (isset($_SESSION['email']) && $_SESSION['usertype'] == 'patient') {
    $pid = $_SESSION['id'];

    if (isset($_GET['did']) && is_numeric($_GET['did'])) {
        $did = $_GET['did'];

        // Prepare the statements
        $query1 = "SELECT * FROM patient WHERE pid = ?";
        $query2 = "SELECT * FROM doctor WHERE did = ?";

        if ($stmt1 = $conn->prepare($query1)) {
            $stmt1->bind_param('i', $pid);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            if ($result1->num_rows > 0) {
                $patient = $result1->fetch_assoc();
            } else {
                echo "Patient not found.";
                exit();
            }
            $stmt1->close();
        } else {
            echo "Operation Failed.";
            exit();
        }

        if ($stmt2 = $conn->prepare($query2)) {
            $stmt2->bind_param('i', $did);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $doctor = $result2->fetch_assoc();
            } else {
                echo "Doctor not found.";
                exit();
            }
            $stmt2->close();
        } else {
            echo "Operation Failed.";
            exit();
        }
    } else {
        echo "Invalid doctor ID.";
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}

$errors = [
    'appointment_date' => '',
    'appointment_time' => '',
    'reason_for_visit' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_appointment'])) {
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason_for_visit = $_POST['reason_for_visit'];

    // Validate appointment date
    $currentDate = new DateTime();
    $selectedDate = new DateTime($appointment_date);
    
    // Create a DateTime object for 2 days from now
    $maxDate = (new DateTime())->modify('+2 days')->setTime(0, 0);
    
    // Check if the selected date is not within 2 days from now
    if ($selectedDate < $currentDate || $selectedDate > $maxDate) {
        $errors['appointment_date'] = 'Please select an appointment date within 2 days.';
    }
    

    // Validate appointment time
    $availabilityStart = new DateTime($doctor['Availability_start']);
    $availabilityEnd = new DateTime($doctor['Availability_End']);
    $appointmentTime = new DateTime($appointment_time);

    if ($appointmentTime < $availabilityStart || $appointmentTime > $availabilityEnd) {
        $errors['appointment_time'] = 'Appointment time must be between ' . $availabilityStart->format('H:i') . ' and ' . $availabilityEnd->format('H:i') . '.';
    }

    // Check for double booking
    $checkQuery = "SELECT * FROM appointments WHERE did = ? AND AppointmentDate = ? AND AppointmentTime = ?";
    if ($checkStmt = $conn->prepare($checkQuery)) {
        $checkStmt->bind_param('iss', $did, $appointment_date, $appointment_time);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $errors['appointment_time'] = 'This time slot is already booked. Please choose another time.';
        }
        $checkStmt->close();
    } else {
        echo "Failed to prepare the check SQL statement.";
        exit();
    }

    // If no errors, proceed to book the appointment
    if (empty(array_filter($errors))) {
        $query = "INSERT INTO appointments (pid, did, AppointmentDate, AppointmentTime, ReasonForVisit, Status) VALUES (?, ?, ?, ?, ?, ?)";
        $status = 'Pending'; // Default status

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('iissss', $pid, $did, $appointment_date, $appointment_time, $reason_for_visit, $status);

            if ($stmt->execute()) {
                echo "<script>alert('Appointment booked successfully.'); window.close();</script>";
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .report-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .logout-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <h2>Book your appointment</h2>
        <form action="appointmentform.php?did=<?php echo htmlspecialchars($did); ?>" method="post">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name"
                    value="<?php echo htmlspecialchars($patient['pname']); ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="doctor_name">Doctor Name:</label>
                <input type="text" id="doctor_name" name="doctor_name"
                    value="<?php echo htmlspecialchars($doctor['dname']); ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" required>
                <span class="error"><?php echo $errors['appointment_date']; ?></span>
            </div>
            <div class="form-group">
                <label for="appointment_time">Appointment Time:</label>
                <input type="time" id="appointment_time" name="appointment_time" required>
                <span class="error"><?php echo $errors['appointment_time']; ?></span>
            </div>
            <div class="form-group">
                <label for="reason_for_visit">Reason for Visit:</label>
                <textarea id="reason_for_visit" name="reason_for_visit" required></textarea>
                <span class="error"><?php echo $errors['reason_for_visit']; ?></span>
            </div>
            <div class="form-group">
                <button class="logout-btn" type="button" onclick="prev()">Go Back</button> &nbsp; &nbsp;
                <button class="logout-btn" type="submit" name="book_appointment">Book Appointment</button>
            </div>
            <input type="hidden" name="pid" value="<?php echo htmlspecialchars($pid); ?>">
            <input type="hidden" name="did" value="<?php echo htmlspecialchars($did); ?>">
        </form>
    </div>
    <script>
        function prev() {
            window.close();
        }
    </script>
</body>

</html>