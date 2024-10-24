<?php
require_once "../../config_session.php";
require_once "../../Models/student_model.php";
require_once "../../dbh.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Student') {
    header("Location: ../../../index.php");
    die();
}

$user_id = $_SESSION['user_id'];
$student = getStudentDetails($pdo, $user_id);

// Check if all required fields are filled

$required_fields = ['first_name', 'last_name', 'email', 'phone_number', 'date_of_birth', 'gender', 'address'];

$is_profile_complete = true;

foreach ($required_fields as $field) {
    if (empty($student[$field])) {
        $is_profile_complete = false;
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../output.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/styles.css">
    <title>Student Profile</title>
</head>

<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Navigation bar -->
    <?php 
        $imageSrc = '../../../public/assets/images/bcp_logo.png';
        include($_SERVER['DOCUMENT_ROOT'] . '/php-SMS2/public/templates/header.php');
    ?>
    <div class="flex h-screen pt-20">
        <!-- sidebar -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/public/templates/student_sidebar.php');?>
        <main class="flex-1 p-8 overflow-y-auto">
            <h2 class="text-3xl font-semibold text-blue-800 mb-6">Student Profile</h2>
            <?php if ($is_profile_complete): ?>
                <div class="mb-4 flex justify-center items-center bg-green-600 p-4 w-full rounded-lg">
                    <p class="text-white">Your profile information is up to date!</p>
                </div>
            <?php else: ?>
                <div class="mb-4 flex justify-center items-center bg-rose-500 p-4 w-full rounded-lg">
                <p class="text-white">Please update your profile information to ensure it's complete.</p>
                </div>
            <?php endif; ?>

            <!-- Profile information -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Personal Information</h3>
                <?php if ($student): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <p><strong class="font-medium">Name:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['first_name'] ?? '') . ' ' . htmlspecialchars($student['last_name'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Student ID:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['user_id'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Email:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['email'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Phone:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['phone_number'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Date of Birth:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Gender:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['gender'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Address:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['address'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Enrollment Date:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['enrollment_date'] ?? ''); ?></span></p>
                        <p><strong class="font-medium">Status:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['status'] ?? ''); ?></span></p>
                    </div>
                    <div class="mt-6 sm:absolute sm:top-6 sm:right-6">
                        <button id="updateProfileBtn" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Profile
                        </button>
                    </div>
                <?php else: ?>
                    <p>No student information available.</p>
                <?php endif; ?>
            </div>
            <!-- You can add more sections here, such as academic information, contact details, etc. -->
                </main>
    </div>

    <!-- Modal -->
    <div id="updateProfileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Profile</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="updateProfileForm">
                        <input type="text" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($student['first_name'] ?? ''); ?>" class="mb-2 w-full px-3 py-2 border rounded-lg" required>
                        <input type="text" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($student['last_name'] ?? ''); ?>" class="mb-2 w-full px-3 py-2 border rounded-lg" required>
                        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>" class="mb-2 w-full px-3 py-2 border rounded-lg" required>
                        <input type="tel" name="phone_number" placeholder="Phone Number" value="<?php echo htmlspecialchars($student['phone_number'] ?? ''); ?>" class="mb-2 w-full px-3 py-2 border rounded-lg" required>
                        <input type="date" name="date_of_birth" placeholder="Date of Birth" value="<?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?>" class="mb-2 w-full px-3 py-2 border rounded-lg" required>
                        <select name="gender" class="mb-2 w-full px-3 py-2 border rounded-lg" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo ($student['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($student['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>

                        <textarea name="address" placeholder="Address" class="mb-2 w-full px-3 py-2 border rounded-lg" required><?php echo htmlspecialchars($student['address'] ?? ''); ?></textarea>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        const modal = document.getElementById('updateProfileModal');
        const btn = document.getElementById('updateProfileBtn');
        const form = document.getElementById('updateProfileForm');

        btn.onclick = function() {
            modal.classList.remove('hidden');

        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.add('hidden');
            }
        }

        // Add input validation

        const nameRegex = /^[A-Za-z\s]+$/;
        const phoneRegex = /^\d{11}$/;

        function showError(input, message) {
            input.classList.add('border-red-500');
            let errorDiv = input.nextElementSibling;

            if (!errorDiv || !errorDiv.classList.contains('error-message')) {
                errorDiv = document.createElement('div');
                errorDiv.classList.add('error-message', 'text-red-500', 'text-sm', 'mt-1');
                input.parentNode.insertBefore(errorDiv, input.nextSibling);

            }
            errorDiv.textContent = message;
        }



        function clearError(input) {
            input.classList.remove('border-red-500');
            let errorDiv = input.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('error-message')) {
                errorDiv.remove();
            }
        }



        form.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            let isValid = true;

            // Clear previous errors

            form.querySelectorAll('input, select, textarea').forEach(input => clearError(input));

            // Validate first name

            if (!nameRegex.test(formData.get('first_name'))) {
                showError(form.first_name, 'First name should only contain letters and spaces.');
                isValid = false;
            }



            // Validate last name

            if (!nameRegex.test(formData.get('last_name'))) {
                showError(form.last_name, 'Last name should only contain letters and spaces.');
                isValid = false;
            }



            // Validate phone number

            if (!phoneRegex.test(formData.get('phone_number'))) {
                showError(form.phone_number, 'Phone number should contain exactly 11 digits.');
                isValid = false;
            }



            if (!isValid) {
                return;
            }



            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to show updated information
                } else {
                    // Show error message at the top of the form
                    let errorDiv = document.getElementById('form-error');

                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.id = 'form-error';
                        errorDiv.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'px-4', 'py-3', 'rounded', 'relative', 'mb-4');
                        form.prepend(errorDiv);
                    }

                    errorDiv.textContent = data.message || 'Failed to update profile. Please try again.';
                }

            })

            .catch(error => {
                console.error('Error:', error);
                // Show error message at the top of the form

                let errorDiv = document.getElementById('form-error');

                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = 'form-error';
                    errorDiv.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'px-4', 'py-3', 'rounded', 'relative', 'mb-4');
                    form.prepend(errorDiv);
                }

                errorDiv.textContent = 'An error occurred. Please try again.';
            });
        }

    </script>
</body>
</html>


