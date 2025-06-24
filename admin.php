<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Juice Plus+</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script>
    // JS authentication check
    if (localStorage.getItem('admin_logged_in') !== 'true') {
        window.location.href = 'middleware.php';
    }
    // Logout handler
    function adminLogout() {
        localStorage.removeItem('admin_logged_in');
        window.location.href = 'middleware.php';
    }
    </script>
    <style>
        /* Admin Panel Styles */
        .admin-panel {
            display: flex;
            min-height: 100vh;
            background: #f4f7fa;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: var(--dark-color);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100%;
            transition: var(--transition);
            z-index: 1001;
        }

        .admin-sidebar .logo {
            font-size: 2.2rem;
            padding: 0 2rem;
            margin-bottom: 3rem;
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .sidebar-nav ul li {
            margin-bottom: 1rem;
        }

        .sidebar-nav ul li a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 1.5rem;
            transition: var(--transition);
        }

        .sidebar-nav ul li a:hover,
        .sidebar-nav ul li a.active {
            background: var(--primary-color);
            color: white;
        }

        .sidebar-nav ul li a i {
            font-size: 1.8rem;
            transition: transform 0.2s;
        }

        .sidebar-nav ul li a:hover i {
            transform: scale(1.2);
        }

        /* Main Content */
        .admin-main {
            margin-left: 250px;
            flex: 1;
            padding: 3rem;
            transition: var(--transition);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .admin-header h1 {
            font-size: 3rem;
            color: var(--dark-color);
        }

        .admin-search {
            position: relative;
            max-width: 300px;
        }

        .admin-search input {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            border: 1px solid #eee;
            border-radius: 50px;
            font-size: 1.4rem;
        }

        .admin-search i {
            position: absolute;
            top: 50%;
            left: 1.5rem;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.6rem;
            transition: transform 0.2s;
        }

        .admin-search:hover i {
            transform: translateY(-50%) scale(1.2);
        }

        /* Dashboard Stats */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: transform 0.2s;
        }

        .stat-card:hover i {
            transform: scale(1.1);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: 1.4rem;
            color: var(--text-light);
        }

        /* Tabs */
        .admin-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .tab-btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            background: #eee;
            color: var(--dark-color);
            font-size: 1.4rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .tab-btn.active {
            background: var(--primary-color);
            color: white;
        }

        /* Lists */
        .employee-list,
        .food-items-list,
        .categories-list,
        .order-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .employee-card,
        .food-item-card,
        .category-card,
        .order-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: var(--transition);
        }

        .employee-card:hover,
        .food-item-card:hover,
        .category-card:hover,
        .order-card:hover {
            transform: translateY(-5px);
        }

        .employee-card img,
        .food-item-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .employee-card h3,
        .food-item-card h3,
        .category-card h3,
        .order-card h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .employee-card p,
        .food-item-card p,
        .category-card p,
        .order-card p {
            font-size: 1.4rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .employee-card .actions,
        .food-item-card .actions .category-card,
        .actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 1rem;
        }

        .employee-card .actions button,
        .food-item-card .actions button,
        .category-card .actions button {
            padding: 0.8rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .view-btn {
            background: var(--secondary-color);
            color: white;
        }

        .edit-btn {
            background: var(--accent-color);
            color: white;
        }

        .delete-btn {
            background: var(--primary-color);
            color: white;
        }

        .employee-card .actions button i,
        .food-item-card .actions button i,
        .category-card .actions button i {
            font-size: 1.6rem;
            transition: transform 0.2s;
        }

        .employee-card .actions button:hover,
        .food-item-card .actions button:hover,
        .category-card .actions button:hover {
            transform: translateY(-2px);
        }

        .employee-card .actions button:hover i,
        .food-item-card .actions button:hover i,
        .category-card .actions button:hover i {
            transform: scale(1.2);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1002;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
            box-shadow: var(--box-shadow);
        }

        .view-modal-content {
            max-width: 400px;
            text-align: center;
        }

        .view-modal-content img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .view-modal-content p {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .modal-content h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid #eee;
            border-radius: 10px;
            font-size: 1.4rem;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .image-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 1rem auto;
            object-fit: cover;
            display: none;
        }

        .form-group input[type="file"] {
            padding: 0;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .submit-btn,
        .cancel-btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-size: 1.4rem;
            transition: var(--transition);
        }

        .submit-btn {
            background: var(--bg-gradient);
            color: white;
        }

        .cancel-btn {
            background: #eee;
            color: var(--dark-color);
        }

        .submit-btn i,
        .cancel-btn i {
            margin-right: 0.5rem;
            font-size: 1.6rem;
            transition: transform 0.2s;
        }

        .submit-btn:hover i,
        .cancel-btn:hover i {
            transform: scale(1.2);
        }

        /* Content Pages */
        .content-page {
            display: none;
        }

        .content-page.active {
            display: block;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .inventory-table th,
        .inventory-table td {
            padding: 1.5rem;
            text-align: left;
            font-size: 1.4rem;
        }

        .inventory-table th {
            background: var(--primary-color);
            color: white;
        }

        .inventory-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .inventory-table .edit-btn i {
            font-size: 1.6rem;
            transition: transform 0.2s;
        }

        .inventory-table .edit-btn:hover i {
            transform: scale(1.2);
        }

        .settings-form {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
        }

        .settings-form .submit-btn i {
            font-size: 1.6rem;
            transition: transform 0.2s;
        }

        .settings-form .submit-btn:hover i {
            transform: scale(1.2);
        }

        .report-charts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .chart-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            text-align: center;
        }

        .chart-placeholder {
            width: 100%;
            height: 200px;
            background: #eee;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.4rem;
            color: var(--text-light);
        }

        /* Orders Section */
        .orders-section {
            margin-top: 3rem;
        }

        .orders-section h2 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 2rem;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 70px;
            }

            .admin-sidebar .logo {
                font-size: 1.8rem;
                text-align: center;
            }

            .sidebar-nav ul li a span {
                display: none;
            }

            .sidebar-nav ul li a {
                justify-content: center;
            }

            .sidebar-nav ul li a i {
                font-size: 2rem;
            }

            .admin-main {
                margin-left: 70px;
            }

            .admin-header {
                flex-direction: column;
                gap: 2rem;
            }

            .admin-search {
                max-width: 100%;
            }

            .admin-tabs {
                flex-wrap: wrap;
            }

            .employee-card .actions button,
            .food-item-card .actions button,
            .category-card .actions button {
                width: 35px;
                height: 35px;
            }

            .employee-card .actions button i,
            .food-item-card .actions button i,
            .category-card .actions button i {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .employee-list,
            .food-items-list,
            .categories-list,
            .order-list {
                grid-template-columns: 1fr;
            }

            .employee-card .actions button,
            .food-item-card .actions button,
            .category-card .actions button {
                width: 30px;
                height: 30px;
            }

            .employee-card .actions button i,
            .food-item-card .actions button i,
            .category-card .actions button i {
                font-size: 1.2rem;
            }

            .modal-content {
                padding: 2rem;
            }
        }

        .logout-btn {
            background: none;
            border: none;
            color: inherit;
            font: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1rem;
            width: 100%;
            padding: 1rem 2rem;
            font-size: 1.5rem;
            transition: var(--transition);
        }
        .logout-btn:hover {
            background: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Admin Panel -->
    <div class="admin-panel">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="logo">Juice <span class="plus-glow">Plus+</span></div>
            <div class="sidebar-nav">
                <ul>
                    <li><a href="#dashboard" class="active"><i class="fas fa-tachometer-alt" aria-label="Dashboard"></i><span>Dashboard</span></a></li>
                    <li><a href="#inventory"><i class="fas fa-boxes" aria-label="Inventory"></i><span>Inventory</span></a></li>
                    <li><a href="#settings"><i class="fas fa-cog" aria-label="Settings"></i><span>Settings</span></a></li>
                    <li><a href="#reports"><i class="fas fa-chart-bar" aria-label="Reports"></i><span>Reports</span></a></li>
                    <li><button class="logout-btn" onclick="adminLogout()"><i class="fas fa-sign-out-alt" aria-label="Logout"></i><span>Logout</span></button></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Dashboard Page -->
            <div class="content-page active" id="dashboard">
                <div class="admin-header">
                    <h1>Admin Dashboard</h1>
                    <div class="admin-search">
                        <i class="fas fa-search" aria-label="Search"></i>
                        <input type="text" id="searchInput" placeholder="Search..." aria-label="Search input">
                    </div>
                </div>

                <!-- Dashboard Stats -->
                <div class="dashboard-stats">
                    <div class="stat-card" data-aos="fade-up">
                        <i class="fas fa-users" aria-label="Total Employees"></i>
                        <h3>12</h3>
                        <p>Total Employees</p>
                    </div>
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-dollar-sign" aria-label="Monthly Revenue"></i>
                        <h3>15,000</h3>
                        <p>Monthly Revenue</p>
                    </div>
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-box" aria-label="Items in Stock"></i>
                        <h3>250</h3>
                        <p>Items in Stock</p>
                    </div>
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-utensils" aria-label="Menu Items"></i>
                        <h3>20</h3>
                        <p>Menu Items</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="admin-tabs">
                    <button class="tab-btn active" data-tab="employees">Employees</button>
                    <button class="tab-btn" data-tab="food-items">Food Items</button>
                    <button class="tab-btn" data-tab="categories">Categories</button>
                </div>

                <!-- Employees Tab -->
                <div class="tab-content employees active" id="employees">
                    <div class="employee-list" id="employeeList">
                        <div class="employee-card">
                            <img src="https://via.placeholder.com/100" alt="Abel Kebede">
                            <h3>Abel Kebede</h3>
                            <p>Manager</p>
                            <p>+25190101745</p>
                            <p>7000 Birr</p>
                            <div class="actions">
                                <button class="view-btn" data-name="Abel Kebede" aria-label="View employee"><i class="fas fa-eye"></i></button>
                                <button class="edit-btn" data-name="Abel Kebede" aria-label="Edit employee"><i class="fas fa-edit"></i></button>
                                <button class="delete-btn" data-name="Abel Kebede" aria-label="Delete employee"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="employee-card">
                            <img src="https://via.placeholder.com/100" alt="Nahom Girum">
                            <h3>Nahom Girum</h3>
                            <p>Waiter</p>
                            <p>+251987654321</p>
                            <p>123 Birr</p>
                            <div class="actions">
                                <button class="view-btn" data-name="Nahom Girum" aria-label="View employee"><i class="fas fa-eye"></i></button>
                                <button class="edit-btn" data-name="Nahom Girum" aria-label="Edit employee"><i class="fas fa-edit"></i></button>
                                <button class="delete-btn" data-name="Nahom Girum" aria-label="Delete employee"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="employee-card">
                            <img src="https://via.placeholder.com/100" alt="Martha Tadese">
                            <h3>Martha Tadese</h3>
                            <p>Waiter</p>
                            <p>+251123456789</p>
                            <p>12 Birr</p>
                            <div class="actions">
                                <button class="view-btn" data-name="Martha Tadese" aria-label="View employee"><i class="fas fa-eye"></i></button>
                                <button class="edit-btn" data-name="Martha Tadese" aria-label="Edit employee"><i class="fas fa-edit"></i></button>
                                <button class="delete-btn" data-name="Martha Tadese" aria-label="Delete employee"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="add-employee" data-aos="fade-up">
                        <button id="addEmployeeBtn">Add Employee</button>
                    </div>
                </div>

                <!-- Food Items Tab -->
                <div class="tab-content food-items" id="food-items">
                    <div class="food-items-list" id="foodItemsList">
                        <!-- Dynamically populated -->
                    </div>
                    <div class="add-food-item" data-aos="fade-up">
                        <button id="addFoodItemBtn">Add Food Item</button>
                    </div>
                </div>

                <!-- Categories Tab -->
                <div class="tab-content categories" id="categories">
                    <div class="categories-list" id="categoriesList">
                        <!-- Dynamically populated -->
                    </div>
                    <div class="add-category" data-aos="fade-up">
                        <button id="addCategoryBtn">Add Category</button>
                    </div>
                </div>
            </div>

            <!-- Inventory Page -->
            <div class="content-page" id="inventory">
                <div class="admin-header">
                    <h1>Inventory Management</h1>
                </div>
                <div class="inventory-table" data-aos="fade-up">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Organic Apples</td>
                                <td>150</td>
                                <td>kg</td>
                                <td>In Stock</td>
                                <td><button class="edit-btn" aria-label="Edit item"><i class="fas fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td>Kale</td>
                                <td>50</td>
                                <td>kg</td>
                                <td>Low Stock</td>
                                <td><button class="edit-btn" aria-label="Edit item"><i class="fas fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td>Mangoes</td>
                                <td>200</td>
                                <td>kg</td>
                                <td>In Stock</td>
                                <td><button class="edit-btn" aria-label="Edit item"><i class="fas fa-edit"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Settings Page -->
            <div class="content-page" id="settings">
                <div class="admin-header">
                    <h1>Settings</h1>
                </div>
                <div class="settings-form" data-aos="fade-up">
                    <h2>Store Settings</h2>
                    <div class="form-group">
                        <label for="storeName">Store Name</label>
                        <input type="text" id="storeName" value="Juice Plus+">
                    </div>
                    <div class="form-group">
                        <label for="storeEmail">Email</label>
                        <input type="email" id="storeEmail" value="hello@juiceplus.com">
                    </div>
                    <div class="form-group">
                        <label for="storeHours">Operating Hours</label>
                        <textarea id="storeHours">Mon-Sat: 7am-7pm, Sun: 8am-5pm</textarea>
                    </div>
                    <button class="submit-btn"><i class="fas fa-save" aria-label="Save"></i> Save Changes</button>
                </div>
            </div>

            <!-- Reports Page -->
            <div class="content-page" id="reports">
                <div class="admin-header">
                    <h1>Reports</h1>
                </div>
                <div class="report-charts" data-aos="fade-up">
                    <div class="chart-card">
                        <h3>Sales Overview</h3>
                        <div class="chart-placeholder">Sales Chart Placeholder</div>
                    </div>
                    <div class="chart-card">
                        <h3>Top Products</h3>
                        <div class="chart-placeholder">Product Chart Placeholder</div>
                    </div>
                    <div class="chart-card">
                        <h3>Customer Feedback</h3>
                        <div class="chart-placeholder">Feedback Chart Placeholder</div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="orders-section">
                <h2>Orders</h2>
                <div class="order-list"></div>
            </div>
        </main>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal" id="addEmployeeModal">
        <div class="modal-content">
            <h2>Add New Employee</h2>
            <form id="addEmployeeForm">
                <div class="form-group">
                    <label for="employeeName">Full Name</label>
                    <input type="text" id="employeeName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="employeeRole">Role</label>
                    <select id="employeeRole" name="role" required>
                        <option value="manager">Manager</option>
                        <option value="waiter">Waiter</option>
                        <option value="barista">Barista</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="employeePhone">Phone Number</label>
                    <input type="tel" id="employeePhone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="employeeSalary">Salary (Birr)</label>
                    <input type="number" id="employeeSalary" name="salary" required>
                </div>
                <div class="form-group">
                    <label for="employeePhoto">Employee Photo</label>
                    <input type="file" id="employeePhoto" name="photo" accept="image/*">
                    <img id="employeePhotoPreview" class="image-preview" alt="Photo preview">
                </div>
                <div class="modal-actions">
                    <button type="submit" class="submit-btn"><i class="fas fa-plus" aria-label="Add"></i> Add Employee</button>
                    <button type="button" class="cancel-btn" id="cancelEmployeeModal"><i class="fas fa-times" aria-label="Cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal" id="editEmployeeModal">
        <div class="modal-content">
            <h2>Edit Employee</h2>
            <form id="editEmployeeForm">
                <div class="form-group">
                    <label for="editEmployeeName">Full Name</label>
                    <input type="text" id="editEmployeeName" required>
                </div>
                <div class="form-group">
                    <label for="editEmployeeRole">Role</label>
                    <select id="editEmployeeRole" required>
                        <option value="manager">Manager</option>
                        <option value="waiter">Waiter</option>
                        <option value="barista">Barista</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editEmployeePhone">Phone Number</label>
                    <input type="tel" id="editEmployeePhone" required>
                </div>
                <div class="form-group">
                    <label for="editEmployeeSalary">Salary (Birr)</label>
                    <input type="number" id="editEmployeeSalary" required>
                </div>
                <div class="form-group">
                    <label for="editEmployeePhoto">Employee Photo</label>
                    <input type="file" id="editEmployeePhoto" accept="image/*">
                    <img id="editEmployeePhotoPreview" class="image-preview" alt="Photo preview">
                </div>
                <div class="modal-actions">
                    <button type="submit" class="submit-btn"><i class="fas fa-save" aria-label="Save"></i> Save Changes</button>
                    <button type="button" class="cancel-btn" id="cancelEditEmployeeModal"><i class="fas fa-times" aria-label="Cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Employee Modal -->
    <div class="modal" id="viewEmployeeModal">
        <div class="view-modal-content">
            <h2>Employee Details</h2>
            <img id="viewEmployeePhoto" alt="Employee photo">
            <p id="viewEmployeeName"></p>
            <p id="viewEmployeeRole"></p>
            <p id="viewEmployeePhone"></p>
            <p id="viewEmployeeSalary"></p>
            <div class="modal-actions">
                <button class="cancel-btn" id="closeViewEmployeeModal"><i class="fas fa-times" aria-label="Close"></i> Close</button>
            </div>
        </div>
    </div>

    <!-- Add Food Item Modal -->
    <div class="modal" id="addFoodItemModal">
        <div class="modal-content">
            <h2>Add New Food Item</h2>
            <form id="addFoodItemForm">
                <div class="form-group">
                    <label for="foodName">Item Name</label>
                    <input type="text" id="foodName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="foodPrice">Price ($)</label>
                    <input type="number" id="foodPrice" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="foodDescription">Description</label>
                    <textarea id="foodDescription" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="foodCategory">Category</label>
                    <select id="foodCategory" name="category" required>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="foodPhoto">Item Photo</label>
                    <input type="file" id="foodPhoto" name="photo" accept="image/*">
                    <img id="foodPhotoPreview" class="image-preview" alt="Photo preview">
                </div>
                <div class="form-group">
                    <label for="foodBadge">Badge (optional)</label>
                    <select id="foodBadge" name="badge">
                        <option value="">None</option>
                        <option value="Bestseller">Bestseller</option>
                        <option value="New">New</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="submit-btn"><i class="fas fa-plus" aria-label="Add"></i> Add Item</button>
                    <button type="button" class="cancel-btn" id="cancelFoodItemModal"><i class="fas fa-times" aria-label="Cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Food Item Modal -->
    <div class="modal" id="editFoodItemModal">
        <div class="modal-content">
            <h2>Edit Food Item</h2>
            <form id="editFoodItemForm">
                <div class="form-group">
                    <label for="editFoodName">Item Name</label>
                    <input type="text" id="editFoodName" required>
                </div>
                <div class="form-group">
                    <label for="editFoodPrice">Price ($)</label>
                    <input type="number" id="editFoodPrice" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="editFoodDescription">Description</label>
                    <textarea id="editFoodDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label for="editFoodCategory">Category</label>
                    <select id="editFoodCategory" required>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="editFoodPhoto">Item Photo</label>
                    <input type="file" id="editFoodPhoto" accept="image/*">
                    <img id="editFoodPhotoPreview" class="image-preview" alt="Photo preview">
                </div>
                <div class="form-group">
                    <label for="editFoodBadge">Badge (optional)</label>
                    <select id="editFoodBadge">
                        <option value="">None</option>
                        <option value="Bestseller">Bestseller</option>
                        <option value="New">New</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="submit-btn"><i class="fas fa-save" aria-label="Save"></i> Save Changes</button>
                    <button type="button" class="cancel-btn" id="cancelEditFoodItemModal"><i class="fas fa-times" aria-label="Cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Food Item Modal -->
    <div class="modal" id="viewFoodItemModal">
        <div class="view-modal-content">
            <h2>Food Item Details</h2>
            <img id="viewFoodPhoto" alt="Food item photo">
            <p id="viewFoodName"></p>
            <p id="viewFoodPrice"></p>
            <p id="viewFoodDescription"></p>
            <p id="viewFoodCategory"></p>
            <p id="viewFoodBadge"></p>
            <div class="modal-actions">
                <button class="cancel-btn" id="closeViewFoodItemModal"><i class="fas fa-times" aria-label="Close"></i> Close</button>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal" id="addCategoryModal">
        <div class="modal-content">
            <h2>Add New Category</h2>
            <form id="addCategoryForm">
                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" id="categoryName" required>
                </div>
                <div class="form-group">
                    <label for="categoryDescription">Description</label>
                    <textarea id="categoryDescription" required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="submit-btn"><i class="fas fa-plus" aria-label="Add"></i> Add Category</button>
                    <button type="button" class="cancel-btn" id="cancelCategoryModal"><i class="fas fa-times" aria-label="Cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal" id="editCategoryModal">
        <div class="modal-content">
            <h2>Edit Category</h2>
            <form id="editCategoryForm">
                <div class="form-group">
                    <label for="editCategoryName">Category Name</label>
                    <input type="text" id="editCategoryName" required>
                </div>
                <div class="form-group">
                    <label for="editCategoryDescription">Description</label>
                    <textarea id="editCategoryDescription" required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="submit-btn"><i class="fas fa-save" aria-label="Save"></i> Save Changes</button>
                    <button type="button" class="cancel-btn" id="cancelEditCategoryModal"><i class="fas fa-times" aria-label="Cancel"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Category Modal -->
    <div class="modal" id="viewCategoryModal">
        <div class="view-modal-content">
            <h2>Category Details</h2>
            <p id="viewCategoryName"></p>
            <p id="viewCategoryDescription"></p>
            <div class="modal-actions">
                <button class="cancel-btn" id="closeViewCategoryModal"><i class="fas fa-times" aria-label="Close"></i> Close</button>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="script.js"></script>
    <script>
        // Simulated Data Storage
        let employees = [
            { name: 'Abel Kebede', role: 'manager', phone: '+25190101745', salary: 7000, photo: 'https://via.placeholder.com/100' },
            { name: 'Nahom Girum', role: 'waiter', phone: '+251987654321', salary: 123, photo: 'https://via.placeholder.com/100' },
            { name: 'Martha Tadese', role: 'waiter', phone: '+251123456789', salary: 12, photo: 'https://via.placeholder.com/100' }
        ];

        let foodItems = [
            { id: 1, name: 'Tropical Sunrise', price: 7.99, description: 'Mango, pineapple, orange & passionfruit with a hint of turmeric', category: 'Signature Juices', photo: 'https://via.placeholder.com/100', badge: 'Bestseller' },
            { id: 2, name: 'Green Detox', price: 6.99, description: 'Kale, Berry, green apple, lemon & ginger', category: 'Detox & Cleanses', photo: 'https://via.placeholder.com/100', badge: 'New' },
            { id: 3, name: 'Berry Blast', price: 8.49, description: 'Strawberry, blueberry, raspberry, blackberry & acai', category: 'Signature Juices', photo: 'https://via.placeholder.com/100', badge: '' }
        ];

        let categories = [
            { name: 'Signature Juices', description: 'Our most popular blends that customers keep coming back for' },
            { name: 'Detox & Cleanses', description: 'Purify your system with our nutrient-packed detox blends' }
        ];

        // Admin Functionality
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init();
            const addEmployeeBtn = document.getElementById('addEmployeeBtn');
            const addEmployeeModal = document.getElementById('addEmployeeModal');
            const cancelEmployeeModal = document.getElementById('cancelEmployeeModal');
            const addEmployeeForm = document.getElementById('addEmployeeForm');
            const employeeList = document.getElementById('employeeList');
            const employeePhotoInput = document.getElementById('employeePhoto');
            const employeePhotoPreview = document.getElementById('employeePhotoPreview');
            const editEmployeeModal = document.getElementById('editEmployeeModal');
            const cancelEditEmployeeModal = document.getElementById('cancelEditEmployeeModal');
            const editEmployeeForm = document.getElementById('editEmployeeForm');
            const editEmployeePhotoInput = document.getElementById('editEmployeePhoto');
            const editEmployeePhotoPreview = document.getElementById('editEmployeePhotoPreview');
            const viewEmployeeModal = document.getElementById('viewEmployeeModal');
            const closeViewEmployeeModal = document.getElementById('closeViewEmployeeModal');
            const addFoodItemBtn = document.getElementById('addFoodItemBtn');
            const addFoodItemModal = document.getElementById('addFoodItemModal');
            const cancelFoodItemModal = document.getElementById('cancelFoodItemModal');
            const addFoodItemForm = document.getElementById('addFoodItemForm');
            const foodItemsList = document.getElementById('foodItemsList');
            const foodPhotoInput = document.getElementById('foodPhoto');
            const foodPhotoPreview = document.getElementById('foodPhotoPreview');
            const editFoodItemModal = document.getElementById('editFoodItemModal');
            const cancelEditFoodItemModal = document.getElementById('cancelEditFoodItemModal');
            const editFoodItemForm = document.getElementById('editFoodItemForm');
            const editFoodPhotoInput = document.getElementById('editFoodPhoto');
            const editFoodPhotoPreview = document.getElementById('editFoodPhotoPreview');
            const viewFoodItemModal = document.getElementById('viewFoodItemModal');
            const closeViewFoodItemModal = document.getElementById('closeViewFoodItemModal');
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const addCategoryModal = document.getElementById('addCategoryModal');
            const cancelCategoryModal = document.getElementById('cancelCategoryModal');
            const addCategoryForm = document.getElementById('addCategoryForm');
            const editCategoryModal = document.getElementById('editCategoryModal');
            const cancelEditCategoryModal = document.getElementById('cancelEditCategoryModal');
            const editCategoryForm = document.getElementById('editCategoryForm');
            const viewCategoryModal = document.getElementById('viewCategoryModal');
            const closeViewCategoryModal = document.getElementById('closeViewCategoryModal');
            const categoriesList = document.getElementById('categoriesList');
            const searchInput = document.getElementById('searchInput');
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
            const contentPages = document.querySelectorAll('.content-page');

            // Add Food
            if (addFoodItemForm) {
                addFoodItemForm.addEventListener('submit', e => {
                    e.preventDefault();
                    const formData = new FormData(addFoodItemForm);
                    formData.append('action', 'add_food');

                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) {
                            addFoodItemForm.reset();
                            loadFoods();
                        }
                    })
                    .catch(() => alert('An error occurred.'));
                });
            }

            // Add Employee
            if (addEmployeeForm) {
                addEmployeeForm.addEventListener('submit', e => {
                    e.preventDefault();
                    const formData = new FormData(addEmployeeForm);
                    formData.append('action', 'add_employee');

                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) {
                            addEmployeeForm.reset();
                            loadEmployees();
                        }
                    })
                    .catch(() => alert('An error occurred.'));
                });
            }

            // Load Foods
            function loadFoods() {
                fetch('get_foods.php')
                    .then(response => response.json())
                    .then(data => {
                        foodItemsList.innerHTML = '';
                        data.forEach(item => {
                            const foodCard = document.createElement('div');
                            foodCard.classList.add('food-card');
                            foodCard.innerHTML = `
                                <h3>${item.name}</h3>
                                <p>${item.description}</p>
                                <p>Price: $${item.price}</p>
                                <p>Category: ${item.category}</p>
                                ${item.image ? `<img src="${item.image}" alt="${item.name}" style="width:100px;">` : ''}
                                ${item.badge ? `<span>${item.badge}</span>` : ''}
                                <button onclick="deleteFood(${item.id})">Delete</button>
                            `;
                            foodItemsList.appendChild(foodCard);
                        });
                    });
            }

            // Load Employees
            function loadEmployees() {
                fetch('get_employees.php')
                    .then(response => response.json())
                    .then(data => {
                        employeeList.innerHTML = '';
                        data.forEach(employee => {
                            const employeeCard = document.createElement('div');
                            employeeCard.classList.add('employee-card');
                            employeeCard.innerHTML = `
                                <h3>${employee.name}</h3>
                                <p>Role: ${employee.role}</p>
                                ${employee.image ? `<img src="${employee.image}" alt="${employee.name}" style="width:100px;">` : ''}
                                <button onclick="deleteEmployee(${employee.id})">Delete</button>
                            `;
                            employeeList.appendChild(employeeCard);
                        });
                    });
            }

            // Load Orders
            function loadOrders() {
                fetch('get_orders.php')
                    .then(response => response.json())
                    .then(data => {
                        const orderList = document.querySelector('.order-list');
                        orderList.innerHTML = '';
                        data.forEach(order => {
                            const orderCard = document.createElement('div');
                            orderCard.classList.add('order-card');
                            orderCard.innerHTML = `
                                <h3>Order #${order.id}</h3>
                                <p>Total: $${order.total_amount}</p>
                                <p>Status: ${order.status}</p>
                                <p>Placed: ${order.created_at}</p>
                                <ul>
                                    ${order.items.map(item => `<li>${item.name} x${item.quantity} ($${item.price})</li>`).join('')}
                                </ul>
                            `;
                            orderList.appendChild(orderCard);
                        });
                    });
            }

            // Delete Food
            window.deleteFood = function(id) {
                if (confirm('Are you sure?')) {
                    const formData = new FormData();
                    formData.append('action', 'delete_food');
                    formData.append('id', id);

                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) loadFoods();
                    })
                    .catch(() => alert('An error occurred.'));
                }
            };

            // Delete Employee
            window.deleteEmployee = function(id) {
                if (confirm('Are you sure?')) {
                    const formData = new FormData();
                    formData.append('action', 'delete_employee');
                    formData.append('id', id);

                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) loadEmployees();
                    })
                    .catch(() => alert('An error occurred.'));
                }
            };

            // Photo Preview Handlers
            employeePhotoInput.addEventListener('change', () => {
                const file = employeePhotoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        employeePhotoPreview.src = reader.result;
                        employeePhotoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            editEmployeePhotoInput.addEventListener('change', () => {
                const file = editEmployeePhotoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        editEmployeePhotoPreview.src = reader.result;
                        editEmployeePhotoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            foodPhotoInput.addEventListener('change', () => {
                const file = foodPhotoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        foodPhotoPreview.src = reader.result;
                        foodPhotoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            editFoodPhotoInput.addEventListener('change', () => {
                const file = editFoodPhotoInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        editFoodPhotoPreview.src = reader.result;
                        editFoodPhotoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Initialize Lists
            function renderEmployees() {
                employeeList.innerHTML = '';
                employees.forEach(emp => {
                    const card = document.createElement('div');
                    card.classList.add('employee-card');
                    card.innerHTML = `
                        <img src="${emp.photo || 'https://via.placeholder.com/100'}" alt="${emp.name}">
                        <h3>${emp.name}</h3>
                        <p>${emp.role.charAt(0).toUpperCase() + emp.role.slice(1)}</p>
                        <p>${emp.phone}</p>
                        <p>${emp.salary} Birr</p>
                        <div class="actions">
                            <button class="view-btn" data-name="${emp.name}" aria-label="View employee"><i class="fas fa-eye"></i></button>
                            <button class="edit-btn" data-name="${emp.name}" aria-label="Edit employee"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" data-name="${emp.name}" aria-label="Delete employee"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    employeeList.appendChild(card);
                });
                addEmployeeListeners();
            }

            function renderFoodItems() {
                foodItemsList.innerHTML = '';
                foodItems.forEach(item => {
                    const card = document.createElement('div');
                    card.classList.add('food-item-card');
                    card.innerHTML = `
                        <img src="${item.photo || 'https://via.placeholder.com/100'}" alt="${item.name}">
                        <h3>${item.name}</h3>
                        <p>$${item.price.toFixed(2)}</p>
                        <p>${item.category}</p>
                        ${item.badge ? `<div class="item-badge ${item.badge.toLowerCase()}">${item.badge}</div>` : ''}
                        <div class="actions">
                            <button class="view-btn" data-id="${item.id}" aria-label="View item"><i class="fas fa-eye"></i></button>
                            <button class="edit-btn" data-id="${item.id}" aria-label="Edit item"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" data-id="${item.id}" aria-label="Delete item"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    foodItemsList.appendChild(card);
                });
                addFoodItemListeners();
            }

            function renderCategories() {
                categoriesList.innerHTML = '';
                const foodCategorySelect = document.getElementById('foodCategory');
                const editFoodCategorySelect = document.getElementById('editFoodCategory');
                foodCategorySelect.innerHTML = categories.map(cat => `<option value="${cat.name}">${cat.name}</option>`).join('');
                editFoodCategorySelect.innerHTML = categories.map(cat => `<option value="${cat.name}">${cat.name}</option>`).join('');
                categories.forEach(category => {
                    const card = document.createElement('div');
                    card.classList.add('category-card');
                    card.innerHTML = `
                        <h3>${category.name}</h3>
                        <p>${category.description}</p>
                        <div class="actions">
                            <button class="view-btn" data-name="${category.name}" aria-label="View category"><i class="fas fa-eye"></i></button>
                            <button class="edit-btn" data-name="${category.name}" aria-label="Edit"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" data-name="${category.name}" aria-label="Delete category"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    categoriesList.appendChild(card);
                });
                addCategoryListeners();
            }

            // Tab Switching
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    button.classList.add('active');
                    document.getElementById(button.dataset.tab).classList.add('active');
                    searchInput.placeholder = `Search ${button.dataset.tab}...`;
                });
            });

            // Sidebar Navigation
            sidebarLinks.forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const target = link.getAttribute('href').substring(1);
                    if (target !== 'index.php') {
                        sidebarLinks.forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                        contentPages.forEach(page => page.classList.remove('active'));
                        document.getElementById(target).classList.add('active');
                    }
                });
            });

            // Search Functionality
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                const activeTab = document.querySelector('.tab-content.active').id;
                if (activeTab === 'employees') {
                    const employeeCards = employeeList.querySelectorAll('.employee-card');
                    employeeCards.forEach(card => {
                        const name = card.querySelector('h3').textContent.toLowerCase();
                        card.style.display = name.includes(searchTerm) ? 'block' : 'none';
                    });
                } else if (activeTab === 'food-items') {
                    const foodCards = foodItemsList.querySelectorAll('.food-item-card');
                    foodCards.forEach(card => {
                        const name = card.querySelector('h3').textContent.toLowerCase();
                        card.style.display = name.includes(searchTerm) ? 'block' : 'none';
                    });
                } else if (activeTab === 'categories') {
                    const categoryCards = categoriesList.querySelectorAll('.category-card');
                    categoryCards.forEach(card => {
                        const name = card.querySelector('h3').textContent.toLowerCase();
                        card.style.display = name.includes(searchTerm) ? 'block' : 'none';
                    });
                }
            });

            // Employee Modals
            addEmployeeBtn.addEventListener('click', () => {
                addEmployeeModal.style.display = 'flex';
                employeePhotoPreview.style.display = 'none';
            });

            cancelEmployeeModal.addEventListener('click', () => {
                addEmployeeModal.style.display = 'none';
                addEmployeeForm.reset();
                employeePhotoPreview.style.display = 'none';
            });

            addEmployeeForm.addEventListener('submit', e => {
                e.preventDefault();
                const name = document.getElementById('employeeName').value;
                const role = document.getElementById('employeeRole').value;
                const phone = document.getElementById('employeePhone').value;
                const salary = parseInt(document.getElementById('employeeSalary').value);
                const photo = employeePhotoPreview.src || 'https://via.placeholder.com/100';

                employees.push({ name, role, phone, salary, photo });
                renderEmployees();
                addEmployeeModal.style.display = 'none';
                addEmployeeForm.reset();
                employeePhotoPreview.style.display = 'none';
            });

            cancelEditEmployeeModal.addEventListener('click', () => {
                editEmployeeModal.style.display = 'none';
                editEmployeeForm.reset();
                editEmployeePhotoPreview.style.display = 'none';
            });

            editEmployeeForm.addEventListener('submit', e => {
                e.preventDefault();
                const name = document.getElementById('editEmployeeName').value;
                const role = document.getElementById('editEmployeeRole').value;
                const phone = document.getElementById('editEmployeePhone').value;
                const salary = parseInt(document.getElementById('editEmployeeSalary').value);
                const photo = editEmployeePhotoPreview.src || 'https://via.placeholder.com/100';
                const oldName = editEmployeeForm.dataset.name;

                employees = employees.map(emp => 
                    emp.name === oldName ? { name, role, phone, salary, photo } : emp
                );
                renderEmployees();
                editEmployeeModal.style.display = 'none';
                editEmployeeForm.reset();
                editEmployeePhotoPreview.style.display = 'none';
            });

            closeViewEmployeeModal.addEventListener('click', () => {
                viewEmployeeModal.style.display = 'none';
            });

            function addEmployeeListeners() {
                document.querySelectorAll('.employee-card .delete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        employees = employees.filter(emp => emp.name !== name);
                        renderEmployees();
                    });
                });

                document.querySelectorAll('.employee-card .edit-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        const emp = employees.find(e => e.name === name);
                        document.getElementById('editEmployeeName').value = emp.name;
                        document.getElementById('editEmployeeRole').value = emp.role;
                        document.getElementById('editEmployeePhone').value = emp.phone;
                        document.getElementById('editEmployeeSalary').value = emp.salary;
                        editEmployeePhotoPreview.src = emp.photo;
                        editEmployeePhotoPreview.style.display = 'block';
                        editEmployeeForm.dataset.name = name;
                        editEmployeeModal.style.display = 'flex';
                    });
                });

                document.querySelectorAll('.employee-card .view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        const emp = employees.find(e => e.name === name);
                        document.getElementById('viewEmployeePhoto').src = emp.photo || 'https://via.placeholder.com/100';
                        document.getElementById('viewEmployeeName').textContent = `Name: ${emp.name}`;
                        document.getElementById('viewEmployeeRole').textContent = `Role: ${emp.role.charAt(0).toUpperCase() + emp.role.slice(1)}`;
                        document.getElementById('viewEmployeePhone').textContent = `Phone: ${emp.phone}`;
                        document.getElementById('viewEmployeeSalary').textContent = `Salary: ${emp.salary} Birr`;
                        viewEmployeeModal.style.display = 'flex';
                    });
                });
            }

            // Food Item Modals
            addFoodItemBtn.addEventListener('click', () => {
                addFoodItemModal.style.display = 'flex';
                foodPhotoPreview.style.display = 'none';
            });

            cancelFoodItemModal.addEventListener('click', () => {
                addFoodItemModal.style.display = 'none';
                addFoodItemForm.reset();
                foodPhotoPreview.style.display = 'none';
            });

            addFoodItemForm.addEventListener('submit', e => {
                e.preventDefault();
                const name = document.getElementById('foodName').value;
                const price = parseFloat(document.getElementById('foodPrice').value);
                const description = document.getElementById('foodDescription').value;
                const category = document.getElementById('foodCategory').value;
                const photo = foodPhotoPreview.src || 'https://via.placeholder.com/100';
                const badge = document.getElementById('foodBadge').value;
                const id = foodItems.length + 1;

                foodItems.push({ id, name, price, description, category, photo, badge });
                renderFoodItems();
                addFoodItemModal.style.display = 'none';
                addFoodItemForm.reset();
                foodPhotoPreview.style.display = 'none';
            });

            cancelEditFoodItemModal.addEventListener('click', () => {
                editFoodItemModal.style.display = 'none';
                editFoodItemForm.reset();
                editFoodPhotoPreview.style.display = 'none';
            });

            editFoodItemForm.addEventListener('submit', e => {
                e.preventDefault();
                const id = parseInt(editFoodItemForm.dataset.id);
                const name = document.getElementById('editFoodName').value;
                const price = parseFloat(document.getElementById('editFoodPrice').value);
                const description = document.getElementById('editFoodDescription').value;
                const category = document.getElementById('editFoodCategory').value;
                const photo = editFoodPhotoPreview.src || 'https://via.placeholder.com/100';
                const badge = document.getElementById('editFoodBadge').value;

                foodItems = foodItems.map(item => 
                    item.id === id ? { id, name, price, description, category, photo, badge } : item
                );
                renderFoodItems();
                editFoodItemModal.style.display = 'none';
                editFoodItemForm.reset();
                editFoodPhotoPreview.style.display = 'none';
            });

            closeViewFoodItemModal.addEventListener('click', () => {
                viewFoodItemModal.style.display = 'none';
            });

            function addFoodItemListeners() {
                document.querySelectorAll('.food-item-card .delete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = parseInt(button.dataset.id);
                        foodItems = foodItems.filter(item => item.id !== id);
                        renderFoodItems();
                    });
                });

                document.querySelectorAll('.food-item-card .edit-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = parseInt(button.dataset.id);
                        const item = foodItems.find(i => i.id === id);
                        document.getElementById('editFoodName').value = item.name;
                        document.getElementById('editFoodPrice').value = item.price;
                        document.getElementById('editFoodDescription').value = item.description;
                        document.getElementById('editFoodCategory').value = item.category;
                        document.getElementById('editFoodBadge').value = item.badge || '';
                        editFoodPhotoPreview.src = item.photo;
                        editFoodPhotoPreview.style.display = 'block';
                        editFoodItemForm.dataset.id = id;
                        editFoodItemModal.style.display = 'flex';
                    });
                });

                document.querySelectorAll('.food-item-card .view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = parseInt(button.dataset.id);
                        const item = foodItems.find(i => i.id === id);
                        document.getElementById('viewFoodPhoto').src = item.photo || 'https://via.placeholder.com/100';
                        document.getElementById('viewFoodName').textContent = `Name: ${item.name}`;
                        document.getElementById('viewFoodPrice').textContent = `Price: $${item.price.toFixed(2)}`;
                        document.getElementById('viewFoodDescription').textContent = `Description: ${item.description}`;
                        document.getElementById('viewFoodCategory').textContent = `Category: ${item.category}`;
                        document.getElementById('viewFoodBadge').textContent = item.badge ? `Badge: ${item.badge}` : '';
                        viewFoodItemModal.style.display = 'flex';
                    });
                });
            }

            // Category Modals
            addCategoryBtn.addEventListener('click', () => {
                addCategoryModal.style.display = 'flex';
            });

            cancelCategoryModal.addEventListener('click', () => {
                addCategoryModal.style.display = 'none';
                addCategoryForm.reset();
            });

            addCategoryForm.addEventListener('submit', e => {
                e.preventDefault();
                const name = document.getElementById('categoryName').value;
                const description = document.getElementById('categoryDescription').value;

                categories.push({ name, description });
                renderCategories();
                addCategoryModal.style.display = 'none';
                addCategoryForm.reset();
            });

            cancelEditCategoryModal.addEventListener('click', () => {
                editCategoryModal.style.display = 'none';
                editCategoryForm.reset();
            });

            editCategoryForm.addEventListener('submit', e => {
                e.preventDefault();
                const name = document.getElementById('editCategoryName').value;
                const description = document.getElementById('editCategoryDescription').value;
                const oldName = editCategoryForm.dataset.name;

                categories = categories.map(cat => 
                    cat.name === oldName ? { name, description } : cat
                );
                foodItems = foodItems.map(item => 
                    item.category === oldName ? { ...item, category: name } : item
                );
                renderCategories();
                renderFoodItems();
                editCategoryModal.style.display = 'none';
                editCategoryForm.reset();
            });

            closeViewCategoryModal.addEventListener('click', () => {
                viewCategoryModal.style.display = 'none';
            });

            function addCategoryListeners() {
                document.querySelectorAll('.category-card .delete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        categories = categories.filter(cat => cat.name !== name);
                        foodItems = foodItems.filter(item => item.category !== name);
                        renderCategories();
                        renderFoodItems();
                    });
                });

                document.querySelectorAll('.category-card .edit-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        const cat = categories.find(c => c.name === name);
                        document.getElementById('editCategoryName').value = cat.name;
                        document.getElementById('editCategoryDescription').value = cat.description;
                        editCategoryForm.dataset.name = name;
                        editCategoryModal.style.display = 'flex';
                    });
                });

                document.querySelectorAll('.category-card .view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        const cat = categories.find(c => c.name === name);
                        document.getElementById('viewCategoryName').textContent = `Name: ${cat.name}`;
                        document.getElementById('viewCategoryDescription').textContent = `Description: ${cat.description}`;
                        viewCategoryModal.style.display = 'flex';
                    });
                });
            }

            // Initial Load
            renderEmployees();
            renderFoodItems();
            renderCategories();
            loadOrders();
            loadFoods();
            loadEmployees();

            // Expose data for menu.js
            window.menuData = { 
                foodItems: foodItems.map(item => ({ ...item, image: item.photo })), 
                categories 
            };
        });
    </script>
</body>
</html>