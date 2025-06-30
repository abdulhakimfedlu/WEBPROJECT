<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
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
    
    // Logout handler
   function adminLogout() {
    // Show logout confirmation modal instead of direct redirect
    const logoutModal = document.getElementById('logoutConfirmModal');
    logoutModal.style.display = 'flex';
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
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(80,80,80,0.13);
            padding: 2.5rem 2rem 2rem 2rem;
            margin: 0 auto;
            position: relative;
            opacity: 1 !important;
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

        /* Add Orders tab/section */
        .order-notification {
            background: rgba(255,255,255,0.95);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(80,80,80,0.08);
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
            border: 1.5px solid #f0f0f0;
            transition: box-shadow 0.2s, border 0.2s;
        }
        .order-notification:hover {
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.13);
            border: 1.5px solid var(--primary-color);
        }
        .order-header {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        .order-status {
            font-size: 1.1rem;
            color: #4ecdc4;
            margin-bottom: 0.5rem;
        }
        .order-total {
            font-size: 1.1rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        .order-items ul {
            margin: 0.5rem 0 0 1.2rem;
            padding: 0;
            font-size: 1.1rem;
            color: #333;
        }

        /* Add badge styles */
        .badge {
            background: var(--primary-color);
            color: #fff;
            border-radius: 50%;
            padding: 0.2em 0.6em;
            font-size: 1.1rem;
            font-weight: 700;
            vertical-align: super;
            margin-left: 0.3em;
            min-width: 1.7em;
            text-align: center;
            display: inline-block;
        }

        /* Add a modal for order completion success */
        .order-complete-modal {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        .order-complete-modal.active {
            opacity: 1;
            visibility: visible;
            display: flex;
        }
        .order-complete-modal .modal-content {
            background: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transform: scale(0.95);
            transition: transform 0.3s;
        }
        .order-complete-modal.active .modal-content {
            transform: scale(1);
        }
        .order-complete-modal .modal-icon {
            font-size: 4rem;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            animation: bounceIn 0.8s ease;
        }
        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .order-complete-modal h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        .order-complete-modal p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2rem;
        }
        .order-complete-modal .ok-btn {
            background: var(--bg-gradient);
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }
        .order-complete-modal .ok-btn:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Add/Update modern button styles for food and category actions */
        .food-item-card .actions button, .category-card .actions button {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0.2rem;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .food-item-card .actions button:hover, .category-card .actions button:hover {
            background: var(--secondary-color);
            color: #fff;
            transform: scale(1.08);
        }

        /* Add/Update modern button styles for employee actions */
        .employee-card .actions button {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0.2rem;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .employee-card .actions button:hover {
            background: var(--secondary-color);
            color: #fff;
            transform: scale(1.08);
        }

        /* Add/Update modern style for Add Category button */
        .add-category button {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0.5rem 0;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
        }
        .add-category button:hover {
            background: var(--secondary-color);
            color: #fff;
            transform: scale(1.05);
        }

        /* Add/Update modern style for Add Food Item button and food item actions */
        .add-food-item button {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0.5rem 0;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
        }
        .add-food-item button:hover {
            background: var(--secondary-color);
            color: #fff;
            transform: scale(1.05);
        }
        .food-item-card .actions button {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0.2rem;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .food-item-card .actions button i {
            font-size: 1.7rem;
            transition: transform 0.2s;
        }
        .food-item-card .actions button:hover {
            background: var(--secondary-color);
            color: #fff;
            transform: scale(1.08);
        }
        .food-item-card .actions button:hover i {
            transform: scale(1.2);
        }

        .feedback-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.2rem;
        }

        .food-item-card, .food-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 10px rgba(255, 107, 107, 0.08);
            border: 1.5px solid #f2f2f2;
            padding: 2.2rem 1.5rem 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.2s, border 0.2s, transform 0.18s;
            min-width: 220px;
            position: relative;
        }
        .food-item-card:hover, .food-card:hover {
            box-shadow: 0 10px 32px rgba(255, 107, 107, 0.13);
            border: 1.5px solid var(--primary-color);
            transform: translateY(-6px) scale(1.025);
        }
        .food-item-card img, .food-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            background: #fff;
            border: 2px solid #f4f4f4;
        }
        .food-item-card h3, .food-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
            color: var(--dark-color);
            letter-spacing: 0.1px;
            text-align: center;
        }
        .food-item-card p, .food-card p {
            font-size: 1.05rem;
            color: var(--text-light);
            margin-bottom: 0.7rem;
            text-align: center;
        }
        .food-item-card .item-badge, .food-card .item-badge, .food-card span {
            font-size: 0.95rem;
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }
        .food-item-card .actions, .food-card .actions {
            display: flex;
            gap: 1.2rem;
            margin-top: 1.2rem;
        }
        .food-item-card .edit-btn, .food-item-card .delete-btn, .food-card button, .food-card .edit-btn, .food-card .delete-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 50px;
            padding: 0.8rem 1.7rem;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.10);
            gap: 0.7rem;
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            color: #fff;
            margin: 0 0.2rem;
        }
        .food-item-card .edit-btn, .food-card .edit-btn {
            background: linear-gradient(90deg, var(--secondary-color) 60%, var(--primary-color) 100%);
        }
        .food-item-card .edit-btn:hover, .food-card .edit-btn:hover {
            background: var(--accent-color);
            color: #fff;
            transform: scale(1.08);
        }
        .food-item-card .delete-btn, .food-card .delete-btn, .food-card button {
            background: linear-gradient(90deg, #ff6b6b 60%, #ff8e53 100%);
        }
        .food-item-card .delete-btn:hover, .food-card .delete-btn:hover, .food-card button:hover {
            background: var(--dark-color);
            color: #fff;
            transform: scale(1.08);
        }
        .food-item-card .edit-btn i, .food-item-card .delete-btn i, .food-card .edit-btn i, .food-card .delete-btn i {
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }
        @media (max-width: 768px) {
            .food-item-card, .food-card {
                min-width: 100%;
                padding: 1.2rem 0.5rem 1rem 0.5rem;
            }
            .food-item-card img, .food-card img {
                width: 90px;
                height: 90px;
            }
        }
        @media (max-width: 576px) {
            .food-item-card, .food-card {
                padding: 0.7rem 0.2rem 0.7rem 0.2rem;
            }
            .food-item-card img, .food-card img {
                width: 70px;
                height: 70px;
            }
            .food-item-card .actions, .food-card .actions {
                flex-direction: column;
                gap: 0.7rem;
            }
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
                    <li><a href="#employees"><i class="fas fa-users" aria-label="Employees"></i><span>Employees</span></a></li>
                    <li><a href="#food-items"><i class="fas fa-utensils" aria-label="Food Items"></i><span>Food Items</span></a></li>
                    <li><a href="#categories"><i class="fas fa-list" aria-label="Categories"></i><span>Categories</span></a></li>
                    <li><a href="#messages" id="messagesLink"><i class="fas fa-bell" aria-label="Messages"></i><span>Messages</span><span class="badge" id="messagesBadge" style="display:none;margin-left:8px;"></span></a></li>
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
            </div>

            <!-- Employees Page -->
            <div class="content-page" id="employees">
                <div class="admin-header">
                    <h1>Employees</h1>
                </div>
                <div class="employee-list" id="employeeList"></div>
                <div class="add-employee" data-aos="fade-up">
                    <button id="addEmployeeBtn">Add Employee</button>
                </div>
            </div>

            <!-- Food Items Page -->
            <div class="content-page" id="food-items">
                <div class="admin-header">
                    <h1>Food Items</h1>
                </div>
                <div class="food-items-list" id="foodItemsList"></div>
                <div class="add-food-item" data-aos="fade-up">
                    <button id="addFoodItemBtn">Add Food Item</button>
                </div>
            </div>

            <!-- Categories Page -->
            <div class="content-page" id="categories">
                <div class="admin-header">
                    <h1>Categories</h1>
                </div>
                <div class="categories-list" id="categoriesList"></div>
                <div class="add-category" data-aos="fade-up">
                    <button id="addCategoryBtn">Add Category</button>
                </div>
            </div>

            <!-- Messages Page (Orders as messages) -->
            <div class="content-page" id="messages">
                <div class="admin-header">
                    <h1>Messages</h1>
                    <button id="refreshMessagesBtn" class="refresh-btn" style="margin-left:2rem;display:flex;align-items:center;gap:0.6rem;background:linear-gradient(90deg,var(--primary-color) 60%,var(--secondary-color) 100%);color:#fff;border:none;border-radius:50px;padding:0.8rem 1.7rem;font-size:1.15rem;font-weight:700;box-shadow:0 2px 8px rgba(255,107,107,0.10);cursor:pointer;transition:background 0.2s,transform 0.2s;">
                        <i class="fas fa-sync-alt" id="refreshIcon" style="transition:transform 0.4s;"></i>
                        <span>Refresh</span>
                    </button>
                </div>
                <div id="messagesSection"></div>
            </div>

            <!-- Inventory Page -->
            <div class="content-page" id="inventory">
                <div class="admin-header">
                    <h1>Inventory Management</h1>
                </div>
                <div class="inventory-controls" style="margin-bottom: 2rem;">
                    <button id="addInventoryBtn" class="submit-btn" style="background: var(--bg-gradient); color: white; padding: 1rem 2rem; border: none; border-radius: 50px; font-size: 1.4rem; cursor: pointer;">
                        <i class="fas fa-plus" aria-label="Add"></i> Add Inventory Item
                    </button>
                </div>
                <div class="inventory-table" data-aos="fade-up">
                    <table id="inventoryTable">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                            <!-- Inventory items will be populated here -->
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
                        <input type="email" id="storeEmail" value="abduJabez@gmail.com">
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
                <!-- Add a hidden input to store the uploaded photo path -->
                <input type="hidden" id="employeePhotoPath" name="image">
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
                <!-- Add a hidden input to store the uploaded food photo path -->
                <input type="hidden" id="foodPhotoPath" name="image">
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

    <!-- Add a modal for order completion success -->
    <div class="order-complete-modal" id="orderCompleteModal">
        <div class="modal-content">
            <div class="modal-icon"><i class="fas fa-check-circle"></i></div>
            <h2>Order Completed!</h2>
            <p>The order has been marked as completed and removed from your messages.</p>
            <button class="ok-btn" id="orderCompleteOkBtn">OK</button>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logoutConfirmModal">
        <div class="modal-content">
            <div class="modal-icon" style="text-align: center; margin-bottom: 1.5rem;">
                <i class="fas fa-sign-out-alt" style="font-size: 3rem; color: var(--primary-color);"></i>
            </div>
            <h2 style="text-align: center; margin-bottom: 1rem;">Confirm Logout</h2>
            <p style="text-align: center; font-size: 1.4rem; color: var(--text-light); margin-bottom: 2rem;">
                Are you sure you want to logout from the admin panel?
            </p>
            <div class="modal-actions">
                <button class="submit-btn" id="confirmLogoutBtn">
                    <i class="fas fa-check" aria-label="Yes"></i> Yes, Logout
                </button>
                <button class="cancel-btn" id="cancelLogoutBtn">
                    <i class="fas fa-times" aria-label="No"></i> No, Stay
                </button>
            </div>
        </div>
    </div>

    <!-- Add styles for the modal -->
    <style>
        .order-complete-modal {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        .order-complete-modal.active {
            opacity: 1;
            visibility: visible;
            display: flex;
        }
        .order-complete-modal .modal-content {
            background: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transform: scale(0.95);
            transition: transform 0.3s;
        }
        .order-complete-modal.active .modal-content {
            transform: scale(1);
        }
        .order-complete-modal .modal-icon {
            font-size: 4rem;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            animation: bounceIn 0.8s ease;
        }
        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .order-complete-modal h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        .order-complete-modal p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2rem;
        }
        .order-complete-modal .ok-btn {
            background: var(--bg-gradient);
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }
        .order-complete-modal .ok-btn:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }
    </style>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="script.js"></script>
    <script>
        // Simulated Data Storage
        let employees = [];

        let foodItems = [
            { id: 1, name: 'Tropical Sunrise', price: 7.99, description: 'Mango, pineapple, orange & passionfruit with a hint of turmeric', category: 'Signature Juices', photo: 'https://via.placeholder.com/100', badge: 'Bestseller' },
            { id: 2, name: 'Green Detox', price: 6.99, description: 'Kale, Berry, green apple, lemon & ginger', category: 'Detox & Cleanses', photo: 'https://via.placeholder.com/100', badge: 'New' },
            { id: 3, name: 'Berry Blast', price: 8.49, description: 'Strawberry, blueberry, raspberry, blackberry & acai', category: 'Signature Juices', photo: 'https://via.placeholder.com/100', badge: '' }
        ];

        let categories = [];

        // Load Categories from Database
        function loadCategories() {
            fetch('get_categories.php')
                .then(response => response.json())
                .then(data => {
                    categories = data;
                    renderCategories();
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                });
        }

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

            // Add a hidden input to store the uploaded photo path
            let employeePhotoPathInput = document.getElementById('employeePhotoPath');
            if (!employeePhotoPathInput) {
                employeePhotoPathInput = document.createElement('input');
                employeePhotoPathInput.type = 'hidden';
                employeePhotoPathInput.id = 'employeePhotoPath';
                employeePhotoPathInput.name = 'image';
                document.getElementById('addEmployeeForm').appendChild(employeePhotoPathInput);
            }

            // Upload photo when selected
            employeePhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('photo', file);
                    fetch('upload_employee_photo.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            employeePhotoPathInput.value = data.file;
                            // Show preview
                            employeePhotoPreview.src = data.file;
                            employeePhotoPreview.style.display = 'block';
                        } else {
                            alert(data.message || 'Photo upload failed.');
                            employeePhotoPathInput.value = '';
                        }
                    })
                    .catch(() => {
                        alert('Photo upload failed.');
                        employeePhotoPathInput.value = '';
                    });
                }
            });

            // Add Food
            if (addFoodItemForm) {
                // Duplicate handler removed to prevent double submission
            }

            // Add Employee
            if (addEmployeeForm) {
                addEmployeeForm.addEventListener('submit', e => {
                    e.preventDefault();
                    const formData = new FormData(addEmployeeForm);
                    formData.append('action', 'add_employee');
                    // The image field is already set by the hidden input
                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            addEmployeeForm.reset();
                            employeePhotoPreview.style.display = 'none';
                            employeePhotoPathInput.value = '';
                            loadEmployees();
                            showAdminMessage('Employee added successfully!', 'success');
                        } else {
                            showAdminMessage(data.message || 'An error occurred.', 'error');
                        }
                    })
                    .catch(() => showAdminMessage('An error occurred.', 'error'));
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
                        updateCategoryDropdownsFromFoods(data);
                        renderCategories(data); // Pass foods directly
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
                                <img src="${employee.image || 'https://via.placeholder.com/100'}" alt="${employee.name}">
                                <h3>${employee.name}</h3>
                                <p>${employee.role.charAt(0).toUpperCase() + employee.role.slice(1)}</p>
                                <p>${employee.phone || ''}</p>
                                <p>${employee.salary ? employee.salary + ' Birr' : ''}</p>
                                <div class="actions">
                                    <button class="view-btn" data-id="${employee.id}" aria-label="View employee"><i class="fas fa-eye"></i></button>
                                    <button class="delete-btn" data-id="${employee.id}" aria-label="Delete employee"><i class="fas fa-trash"></i></button>
                                </div>
                            `;
                            employeeList.appendChild(employeeCard);
                        });
                        // Delete
                        document.querySelectorAll('.employee-card .delete-btn').forEach(button => {
                            button.addEventListener('click', () => {
                                const id = button.getAttribute('data-id');
                                customConfirm('Are you sure you want to delete this employee?', () => {
                                    const formData = new FormData();
                                    formData.append('action', 'delete_employee');
                                    formData.append('id', id);
                                    fetch('admin_process.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        showAdminMessage(data.message, data.success ? 'success' : 'error');
                                        if (data.success) loadEmployees();
                                    })
                                    .catch(() => showAdminMessage('An error occurred.', 'error'));
                                });
                            });
                        });
                        // View
                        document.querySelectorAll('.employee-card .view-btn').forEach(button => {
                            button.addEventListener('click', () => {
                                const id = button.getAttribute('data-id');
                                fetch('get_employees.php')
                                    .then(response => response.json())
                                    .then(data => {
                                        const emp = data.find(e => e.id == id);
                                        if (emp) {
                                            document.getElementById('viewEmployeePhoto').src = emp.image || 'https://via.placeholder.com/100';
                                            document.getElementById('viewEmployeeName').textContent = `Name: ${emp.name}`;
                                            document.getElementById('viewEmployeeRole').textContent = `Role: ${emp.role.charAt(0).toUpperCase() + emp.role.slice(1)}`;
                                            document.getElementById('viewEmployeePhone').textContent = `Phone: ${emp.phone}`;
                                            document.getElementById('viewEmployeeSalary').textContent = `Salary: ${emp.salary} Birr`;
                                            viewEmployeeModal.style.display = 'flex';
                                        }
                                    });
                            });
                        });
                        // Edit
                        document.querySelectorAll('.employee-card .edit-btn').forEach(button => {
                            button.addEventListener('click', () => {
                                const id = button.getAttribute('data-id');
                                fetch('get_employees.php')
                                    .then(response => response.json())
                                    .then(data => {
                                        const emp = data.find(e => e.id == id);
                                        if (emp) {
                                            document.getElementById('editEmployeeName').value = emp.name;
                                            document.getElementById('editEmployeeRole').value = emp.role;
                                            document.getElementById('editEmployeePhone').value = emp.phone;
                                            document.getElementById('editEmployeeSalary').value = emp.salary;
                                            document.getElementById('editEmployeePhotoPreview').src = emp.image || 'https://via.placeholder.com/100';
                                            document.getElementById('editEmployeePhotoPreview').style.display = 'block';
                                            editEmployeeForm.dataset.id = id;
                                            editEmployeeModal.style.display = 'flex';
                                        }
                                    });
                            });
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
                customConfirm('Are you sure you want to delete this food item?', () => {
                    const formData = new FormData();
                    formData.append('action', 'delete_food');
                    formData.append('id', id);

                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        showAdminMessage(data.message, data.success ? 'success' : 'error');
                        if (data.success) loadFoods();
                    })
                    .catch(() => showAdminMessage('An error occurred.', 'error'));
                });
            };

            // Delete Employee
            window.deleteEmployee = function(id) {
                customConfirm('Are you sure you want to delete this employee?', () => {
                    const formData = new FormData();
                    formData.append('action', 'delete_employee');
                    formData.append('id', id);

                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        showAdminMessage(data.message, data.success ? 'success' : 'error');
                        if (data.success) loadEmployees();
                    })
                    .catch(() => showAdminMessage('An error occurred.', 'error'));
                });
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
                        <img src="${item.image || 'https://via.placeholder.com/100'}" alt="${item.name}">
                        <h3>${item.name}</h3>
                        <p>$${item.price.toFixed(2)}</p>
                        <p>${item.category}</p>
                        ${item.badge ? `<div class="item-badge ${item.badge.toLowerCase()}">${item.badge}</div>` : ''}
                        <div class="actions">
                            <button class="edit-btn" data-id="${item.id}" aria-label="Edit item"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" data-id="${item.id}" aria-label="Delete item"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    foodItemsList.appendChild(card);
                });
                addFoodItemListeners();
            }

            function renderCategories(foods) {
                categoriesList.innerHTML = '';
                const uniqueCategories = [...new Set(foods.map(f => f.category).filter(Boolean))];
                uniqueCategories.forEach(catName => {
                    const catFood = foods.find(f => f.category === catName && parseFloat(f.price) === 0);
                    const description = catFood ? catFood.description : '';
                    const card = document.createElement('div');
                    card.classList.add('category-card');
                    card.innerHTML = `
                        <h3>${catName}</h3>
                        <p>${description}</p>
                        <div class="actions">
                            <button class="edit-btn" data-name="${catName}" aria-label="Edit"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" data-name="${catName}" aria-label="Delete category"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    categoriesList.appendChild(card);
                });
                addCategoryListeners();
            }

            // Sidebar Navigation
            sidebarLinks.forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                    const target = link.getAttribute('href').substring(1);
                    contentPages.forEach(page => page.classList.remove('active'));
                    document.getElementById(target).classList.add('active');
                    // Optionally, fetch data for the section if needed
                    if (target === 'messages') fetchMessages();
                    if (target === 'employees') loadEmployees();
                    if (target === 'food-items') loadFoods();
                    if (target === 'categories') loadCategories();
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

            cancelEditEmployeeModal.addEventListener('click', () => {
                editEmployeeModal.style.display = 'none';
                editEmployeeForm.reset();
                editEmployeePhotoPreview.style.display = 'none';
            });

            editEmployeeForm.addEventListener('submit', e => {
                e.preventDefault();
                const id = editEmployeeForm.dataset.id;
                const name = document.getElementById('editEmployeeName').value;
                const role = document.getElementById('editEmployeeRole').value;
                const phone = document.getElementById('editEmployeePhone').value;
                const salary = parseInt(document.getElementById('editEmployeeSalary').value);
                const photo = editEmployeePhotoPreview.src || 'https://via.placeholder.com/100';

                const formData = new FormData();
                formData.append('action', 'edit_employee');
                formData.append('id', id);
                formData.append('name', name);
                formData.append('role', role);
                formData.append('phone', phone);
                formData.append('salary', salary);
                formData.append('image', photo);

                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showAdminMessage(data.message, data.success ? 'success' : 'error');
                    if (data.success) {
                        editEmployeeModal.style.display = 'none';
                        editEmployeeForm.reset();
                        editEmployeePhotoPreview.style.display = 'none';
                        loadEmployees();
                    }
                })
                .catch(() => showAdminMessage('An error occurred.', 'error'));
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
                        customConfirm('Are you sure you want to delete this food item?', () => {
                            foodItems = foodItems.filter(item => item.id !== id);
                            renderFoodItems();
                        });
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
                const categoryName = document.getElementById('categoryName').value;
                const categoryDescription = document.getElementById('categoryDescription').value;

                // Instead of add_category, add a food item with category info
                const formData = new FormData();
                formData.append('action', 'add_food');
                formData.append('name', 'Category: ' + categoryName); // or leave blank if you want
                formData.append('description', categoryDescription);
                formData.append('price', 0);
                formData.append('category', categoryName);
                formData.append('image', '');
                formData.append('badge', '');

                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadFoods(); // This will also update categories
                        addCategoryModal.style.display = 'none';
                        addCategoryForm.reset();
                        showAdminMessage('Category added as a food item!', 'success');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding category');
                });
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

                // Update in database
                const formData = new FormData();
                formData.append('action', 'update_category');
                formData.append('old_name', oldName);
                formData.append('name', name);
                formData.append('description', description);

                fetch('admin_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCategories(); // Reload categories from database
                        loadFoods(); // Reload foods to update category references
                        editCategoryModal.style.display = 'none';
                        editCategoryForm.reset();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating category');
                });
            });

            closeViewCategoryModal.addEventListener('click', () => {
                viewCategoryModal.style.display = 'none';
            });

            function addCategoryListeners() {
                document.querySelectorAll('.category-card .delete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const name = button.dataset.name;
                        customConfirm('Are you sure you want to delete this category?', () => {
                            // Delete from database
                            const formData = new FormData();
                            formData.append('action', 'delete_category');
                            formData.append('name', name);

                            fetch('admin_process.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    loadCategories(); // Reload categories from database
                                    loadFoods(); // Reload foods to update category references
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error deleting category');
                            });
                        });
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

            // Fetch and render orders as messages
            function fetchMessages() {
                fetch('get_orders.php')
                    .then(response => response.json())
                    .then(data => {
                        renderMessages(data);
                    });
            }
            function renderMessages(orders) {
                const messagesSection = document.getElementById('messagesSection');
                messagesSection.innerHTML = '';
                if (!orders || orders.length === 0) {
                    messagesSection.innerHTML = '<div style="text-align:center;color:#aaa;font-size:1.2rem;">No messages yet.</div>';
                    return;
                }
                orders.forEach(order => {
                    const card = document.createElement('div');
                    card.classList.add('order-notification');
                    card.innerHTML = `
                        <div class="order-header">
                            <strong>${order.customer_name}</strong> <span style="color:#888;">(Table ${order.table_number})</span>
                            <span style="float:right;color:#aaa;font-size:1.1rem;">${order.created_at}</span>
                        </div>
                        <div class="order-items"><strong>Ordered:</strong><ul>${order.items.map(item => `<li>${item.name} x${item.quantity}</li>`).join('')}</ul></div>
                    `;
                    messagesSection.appendChild(card);
                });
            }

            // Initialize the admin panel
            loadEmployees();
            loadFoods();
            loadCategories();
            fetchMessages();

            // Expose data for menu.js
            window.menuData = { 
                foodItems: foodItems.map(item => ({ ...item, image: item.photo })), 
                categories 
            };

            // --- Order Notification Badge Logic ---
            function updateMessagesBadge() {
                fetch('get_orders.php')
                    .then(response => response.json())
                    .then(orders => {
                        if (!orders || orders.length === 0) {
                            document.getElementById('messagesBadge').style.display = 'none';
                            return;
                        }
                        const lastSeenId = parseInt(localStorage.getItem('lastSeenOrderId') || '0', 10);
                        // Orders are sorted DESC, so first is newest
                        const unseen = orders.filter(order => order.id > lastSeenId);
                        const badge = document.getElementById('messagesBadge');
                        if (unseen.length > 0) {
                            badge.textContent = unseen.length;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    });
            }
            // Call on load and every 10 seconds
            updateMessagesBadge();
            setInterval(updateMessagesBadge, 10000);

            // When admin opens Messages, update last seen and clear badge
            const messagesLink = document.getElementById('messagesLink');
            messagesLink.addEventListener('click', () => {
                fetch('get_orders.php')
                    .then(response => response.json())
                    .then(orders => {
                        if (orders && orders.length > 0) {
                            localStorage.setItem('lastSeenOrderId', orders[0].id);
                        }
                        document.getElementById('messagesBadge').style.display = 'none';
                    });
            });

            // Add a modal for order completion success
            const orderCompleteModal = document.createElement('div');
            orderCompleteModal.className = 'order-complete-modal';
            orderCompleteModal.style.display = 'none';
            orderCompleteModal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-icon"><i class="fas fa-check-circle"></i></div>
                    <h2>Order Completed!</h2>
                    <p>The order has been marked as completed and removed from your messages.</p>
                    <button class="ok-btn" id="orderCompleteOkBtn">OK</button>
                </div>
            `;
            document.body.appendChild(orderCompleteModal);

            // Modal OK button logic
            const orderCompleteOkBtn = orderCompleteModal.querySelector('#orderCompleteOkBtn');
            orderCompleteOkBtn.addEventListener('click', () => {
                orderCompleteModal.classList.remove('active');
                orderCompleteModal.style.opacity = 0;
                orderCompleteModal.style.visibility = 'hidden';
            });

            // Add a UI message div for employee actions
            const adminMessage = document.createElement('div');
            adminMessage.id = 'adminMessage';
            adminMessage.style.display = 'none';
            document.body.prepend(adminMessage);
            function showAdminMessage(msg, type = 'info') {
                adminMessage.textContent = msg;
                adminMessage.style.display = 'block';
                adminMessage.style.background = type === 'error' ? 'rgba(255,107,107,0.12)' : 'rgba(78,205,196,0.10)';
                adminMessage.style.color = type === 'error' ? '#ff6b6b' : '#4ecdc4';
                adminMessage.style.fontWeight = '600';
                adminMessage.style.textAlign = 'center';
                adminMessage.style.padding = '1.2rem 0';
                setTimeout(() => { adminMessage.style.display = 'none'; }, 3500);
            }

            function loadFeedback() {
                fetch('get_feedback.php')
                    .then(response => response.json())
                    .then(data => {
                        const feedbackList = document.getElementById('feedbackList');
                        feedbackList.innerHTML = '';
                        if (data.length === 0) {
                            feedbackList.innerHTML = '<div style="color:#aaa;">No feedback yet.</div>';
                            return;
                        }
                        data.forEach(item => {
                            const card = document.createElement('div');
                            card.classList.add('feedback-card');
                            card.innerHTML = `
                                <strong>${item.name}</strong> <span style="color:#888;">(${item.email})</span>
                                <div style="margin:0.5rem 0;">${item.message}</div>
                                <div style="color:#aaa;font-size:0.9rem;">${item.created_at}</div>
                            `;
                            feedbackList.appendChild(card);
                        });
                    });
            }
            // Call this on page load in admin panel:
            loadFeedback();

            document.getElementById('refreshMessagesBtn').addEventListener('click', fetchMessages);

            // Add a hidden input to store the uploaded food photo path
            let foodPhotoPathInput = document.getElementById('foodPhotoPath');
            if (!foodPhotoPathInput) {
                foodPhotoPathInput = document.createElement('input');
                foodPhotoPathInput.type = 'hidden';
                foodPhotoPathInput.id = 'foodPhotoPath';
                foodPhotoPathInput.name = 'image';
                document.getElementById('addFoodItemForm').appendChild(foodPhotoPathInput);
            }

            // Upload food photo when selected
            foodPhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('photo', file);
                    fetch('upload_food_photo.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            foodPhotoPathInput.value = data.file;
                            // Show preview
                            foodPhotoPreview.src = data.file;
                            foodPhotoPreview.style.display = 'block';
                        } else {
                            alert(data.message || 'Photo upload failed.');
                            foodPhotoPathInput.value = '';
                        }
                    })
                    .catch(() => {
                        alert('Photo upload failed.');
                        foodPhotoPathInput.value = '';
                    });
                }
            });

            // In Add Food Item submit, use the uploaded file path
            if (addFoodItemForm) {
                addFoodItemForm.addEventListener('submit', e => {
                    e.preventDefault();
                    const formData = new FormData(addFoodItemForm);
                    formData.append('action', 'add_food');
                    // The image field is already set by the hidden input
                    fetch('admin_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        showAdminMessage(data.message, data.success ? 'success' : 'error');
                        if (data.success) {
                            addFoodItemForm.reset();
                            foodPhotoPreview.style.display = 'none';
                            foodPhotoPathInput.value = '';
                            loadFoods();
                        }
                    })
                    .catch(() => showAdminMessage('An error occurred.', 'error'));
                });
            }

            // Logout Confirmation Modal Handlers
            const logoutConfirmModal = document.getElementById('logoutConfirmModal');
            const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
            const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

            confirmLogoutBtn.addEventListener('click', () => {
                // Redirect to logout page
                window.location.href = 'logout.php';
            });

            cancelLogoutBtn.addEventListener('click', () => {
                // Hide the modal and stay on the page
                logoutConfirmModal.style.display = 'none';
                showAdminMessage('You chose to stay on the admin panel.', 'success');
            });

            // Close modal when clicking outside
            logoutConfirmModal.addEventListener('click', (e) => {
                if (e.target === logoutConfirmModal) {
                    logoutConfirmModal.style.display = 'none';
                }
            });
        });

        // Add a reusable confirmation modal to the HTML body if not present
        if (!document.getElementById('customConfirmModal')) {
            const modal = document.createElement('div');
            modal.id = 'customConfirmModal';
            modal.style.display = 'none';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100vw';
            modal.style.height = '100vh';
            modal.style.background = 'rgba(0,0,0,0.5)';
            modal.style.zIndex = '2001';
            modal.innerHTML = `
                <div style="background:white;padding:2rem 2.5rem;border-radius:15px;max-width:350px;width:90%;margin:10% auto;text-align:center;box-shadow:0 8px 32px rgba(80,80,80,0.13);">
                    <div id="customConfirmMessage" style="font-size:1.3rem;margin-bottom:2rem;">Are you sure?</div>
                    <button id="customConfirmYes" style="background:var(--primary-color);color:white;padding:0.7rem 2.2rem;border:none;border-radius:50px;font-size:1.1rem;margin-right:1rem;">Yes</button>
                    <button id="customConfirmNo" style="background:#eee;color:#333;padding:0.7rem 2.2rem;border:none;border-radius:50px;font-size:1.1rem;">Cancel</button>
                </div>
            `;
            document.body.appendChild(modal);
        }
        function customConfirm(message, onConfirm) {
            const modal = document.getElementById('customConfirmModal');
            const msg = document.getElementById('customConfirmMessage');
            const yes = document.getElementById('customConfirmYes');
            const no = document.getElementById('customConfirmNo');
            msg.textContent = message;
            modal.style.display = 'flex';
            yes.onclick = () => { modal.style.display = 'none'; onConfirm(); };
            no.onclick = () => { modal.style.display = 'none'; };
        }

        // Helper: Get unique categories from foods
        function updateCategoryDropdownsFromFoods(foods) {
            const foodCategorySelect = document.getElementById('foodCategory');
            const editFoodCategorySelect = document.getElementById('editFoodCategory');
            const uniqueCategories = [...new Set(foods.map(f => f.category).filter(Boolean))];
            foodCategorySelect.innerHTML = uniqueCategories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
            editFoodCategorySelect.innerHTML = uniqueCategories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
        }

        // Add this after DOMContentLoaded in the script section
        const refreshBtn = document.getElementById('refreshMessagesBtn');
        const refreshIcon = document.getElementById('refreshIcon');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                refreshBtn.disabled = true;
                refreshIcon.style.transform = 'rotate(360deg)';
                fetchMessages();
                setTimeout(() => {
                    refreshBtn.disabled = false;
                    refreshIcon.style.transform = 'rotate(0deg)';
                }, 800);
            });
        }
    </script>
</body>
</html>