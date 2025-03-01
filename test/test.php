<?php
require_once '../src/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Student API</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Student List</h1>
        <div id="studentList" class="bg-white rounded-lg shadow p-6"></div>
    </div>

    <script>
        // Fetch students from the API
        fetch('../api/fetch-students.php')
            .then(response => response.json())
            .then(data => {
                const studentList = document.getElementById('studentList');
                
                if (data.success) {
                    // Create table
                    const table = document.createElement('table');
                    table.className = 'min-w-full divide-y divide-gray-200';
                    
                    // Create table header
                    const thead = document.createElement('thead');
                    thead.className = 'bg-gray-50';
                    thead.innerHTML = `
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    `;
                    table.appendChild(thead);
                    
                    // Create table body
                    const tbody = document.createElement('tbody');
                    tbody.className = 'bg-white divide-y divide-gray-200';
                    
                    data.data.forEach(student => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${student.first_name} ${student.last_name}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${student.email}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${student.course || 'N/A'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    ${student.is_archived ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}">
                                    ${student.is_archived ? 'Inactive' : 'Active'}
                                </span>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                    
                    table.appendChild(tbody);
                    studentList.appendChild(table);
                } else {
                    studentList.innerHTML = `
                        <div class="text-center text-gray-500">
                            ${data.message || 'No students found'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                document.getElementById('studentList').innerHTML = `
                    <div class="text-center text-red-500">
                        Error loading students: ${error.message}
                    </div>
                `;
            });
    </script>
</body>
</html>