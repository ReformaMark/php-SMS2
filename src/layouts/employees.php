<?php
    require_once "../config_session.php";
    require_once "../dbh.php";

    if(!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['Admin', 'SuperAdmin'])){
        header("Location: ../../index.php");
        die();
    }

    // Initialize employees array and error message
        $employees = [];
        $error_message = '';
        $searchTerm = $_GET['search'] ?? '';
        $departmentFilter = $_GET['department'] ?? '';

        try {
            $apiUrl = 'https://hr.schoolmanagementsystem2.com/api/fetch-employees.php';
            $ch = curl_init();
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FAILONERROR => true
            ]);
            
            $response = curl_exec($ch);
            
            if ($response === false) {
                throw new Exception('cURL Error: ' . curl_error($ch));
            }
            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if ($httpCode === 200) {
                $result = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Invalid JSON response');
                }
                
                if ($result['success']) {
                    $employees = $result['data'];
                    
                    // Filter employees AFTER fetching them
                    $filteredEmployees = array_filter($employees, function($employee) use ($searchTerm, $departmentFilter) {
                        $matchesSearch = empty($searchTerm) || 
                            stripos($employee['name'], $searchTerm) !== false ||
                            stripos($employee['id'], $searchTerm) !== false ||
                            stripos($employee['email'], $searchTerm) !== false ||
                            stripos($employee['position'], $searchTerm) !== false;
                            
                        $matchesDepartment = empty($departmentFilter) || 
                            $employee['department'] === $departmentFilter;
                            
                        return $matchesSearch && $matchesDepartment;
                    });
                } else {
                    $error_message = $result['message'] ?? 'Unknown error occurred';
                }
            } else {
                throw new Exception("HTTP Error: $httpCode");
            }
            
        } catch (Exception $e) {
            error_log("HR API Error: " . $e->getMessage());
            $error_message = "Failed to fetch employees: " . $e->getMessage();
        } finally {
            if (isset($ch) && is_resource($ch)) {
                curl_close($ch);
            }
        }

        // Debug logging
        if (empty($employees)) {
            error_log("Debug - Error Message: " . $error_message);
            error_log("Debug - Response: " . ($response ?? 'No response'));
            error_log("Debug - HTTP Code: " . ($httpCode ?? 'No HTTP code'));
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link href="../../output.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Navigation bar -->
    <?php 
        $imageSrc = '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
    ?>
    
    <div style="display: flex; height: 100vh; padding-top: 60px;">
        <!-- Sidebar -->
        <?php include('../../public/templates/sidebar.php');?>
        
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Employee Management</h1>
                <!-- <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="alert('This feature will be integrated with HR System')">
                    Sync with HR
                </button> -->
            </div>
            
            <div class="mb-6 flex gap-4">
                <form class="flex gap-4 w-full" method="GET">
                    <input type="text" 
                        name="search"
                        value="<?php echo htmlspecialchars($searchTerm); ?>"
                        placeholder="Search by name, ID, email, or position..." 
                        class="px-4 py-2 border rounded-lg flex-1">
                    
                    <!-- <select name="department" class="px-4 py-2 border rounded-lg">
                        <option value="">All Departments</option>
                        <option value="Faculty" <?php echo $departmentFilter === 'Faculty' ? 'selected' : ''; ?>>Faculty</option>
                        <option value="Administration" <?php echo $departmentFilter === 'Administration' ? 'selected' : ''; ?>>Administration</option>
                        <option value="Support Staff" <?php echo $departmentFilter === 'Support Staff' ? 'selected' : ''; ?>>Support Staff</option>
                    </select> -->
                    
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Search
                    </button>
                    
                    <?php if (!empty($searchTerm) || !empty($departmentFilter)): ?>
                        <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Clear
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- Employee List -->
            <div style="background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); overflow: hidden;">
                <table style="min-width: 100%;">
                    <thead style="background-color: #F9FAFB;">
                        <tr>
                            <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em;">
                                Employee ID
                            </th>
                            <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em;">
                                Name
                            </th>
                            <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em;">
                                Department
                            </th>
                            <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em;">
                                Position
                            </th>
                            <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em;">
                                Email
                            </th>
                            <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em;">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        <?php if (empty($filteredEmployees)): ?>
                            <tr>
                                <td colspan="6" style="padding: 1rem 1.5rem; text-align: center; color: #6B7280;">
                                    <?php 
                                    if (!empty($employees)) {
                                        echo 'No employees match your search criteria';
                                    } else {
                                        echo htmlspecialchars($error_message ?: 'No employees found or failed to fetch data from HR system');
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($filteredEmployees as $employee): ?>
                                <tr style="border-top: 1px solid #E5E7EB; transition: background-color 0.2s;" 
                                    onmouseover="this.style.backgroundColor='#F9FAFB'" 
                                    onmouseout="this.style.backgroundColor='white'">
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #111827;">
                                        <?php echo htmlspecialchars($employee['id']); ?>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #111827;">
                                        <?php echo htmlspecialchars($employee['name']); ?>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #111827;">
                                        <?php echo htmlspecialchars($employee['department']); ?>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #111827;">
                                        <?php echo htmlspecialchars($employee['position']); ?>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; color: #111827;">
                                        <?php echo htmlspecialchars($employee['email']); ?>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; white-space: nowrap;">
                                        <span style="padding: 0.25rem 0.5rem; display: inline-flex; font-size: 0.75rem; line-height: 1.25rem; font-weight: 600; border-radius: 9999px; background-color: #DEF7EC; color: #03543F;">
                                            <?php echo htmlspecialchars($employee['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.querySelector('input[name="search"]');
                const departmentSelect = document.querySelector('select[name="department"]');
                let searchTimeout;

                function debounceSearch() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        document.querySelector('form').submit();
                    }, 500);
                }

                searchInput.addEventListener('input', debounceSearch);
                departmentSelect.addEventListener('change', function() {
                    document.querySelector('form').submit();
                });
            });
</script>
    </div>
</body>
</html>