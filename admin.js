function adminLogout() {
    const logoutModal = document.getElementById('logoutConfirmModal');
    logoutModal.style.display = 'flex';
}


// Simulat

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
            console.log('Loaded categories:', data); 
            categories = data;
            renderCategories();
            updateCategoryDropdowns();
        })
        .catch(error => {
            console.error('Error loading categories:', error);
        });
}

function updateCategoryDropdowns() {
    fetch('get_categories.php')
        .then(response => response.json())
        .then(data => {
            const foodCategorySelect = document.getElementById('foodCategory');
            const editFoodCategorySelect = document.getElementById('editFoodCategory');
            if (!foodCategorySelect || !editFoodCategorySelect) return;
            foodCategorySelect.innerHTML = data.map(cat => `<option value="${cat.name}">${cat.name}</option>`).join('');
            editFoodCategorySelect.innerHTML = data.map(cat => `<option value="${cat.name}">${cat.name}</option>`).join('');
        });
}

// Admin Functionali
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
                        <p>Category: ${item.category_name}</p>
                        ${item.image ? `<img src="${item.image}" alt="${item.name}" style="width:100px;">` : ''}
                        ${item.badge ? `<span>${item.badge}</span>` : ''}
                        <button onclick="deleteFood(${item.id})">Delete</button>
                    `;
                    foodItemsList.appendChild(foodCard);
                });
                updateCategoryDropdownsFromFoods(data);
                // renderCategories(data); // REMOVE THIS LINE
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
                                    // Fix image path for correct display
                                    let imgPath = emp.image ? '/WEBWEB/' + emp.image.replace(/^\/+/, '') : 'https://via.placeholder.com/100';
                                    document.getElementById('viewEmployeePhoto').src = imgPath;
                                    document.getElementById('viewEmployeeName').textContent = `Name: ${emp.name}`;
                                    document.getElementById('viewEmployeeRole').textContent = `Role: ${emp.role.charAt(0).toUpperCase() + emp.role.slice(1)}`;
                                    document.getElementById('viewEmployeePhone').textContent = `Phone: ${emp.phone || ''}`;
                                    document.getElementById('viewEmployeeSalary').textContent = `Salary: ${emp.salary ? emp.salary + ' Birr' : ''}`;
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
                <p>${item.category_name}</p>
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

    function renderCategories() {
        categoriesList.innerHTML = '';
        categories.forEach(cat => {
            const name = cat.name || '(No Name)';
            const desc = cat.description || '';
            const card = document.createElement('div');
            card.classList.add('category-card');
            card.innerHTML = `
                <h3>${name}</h3>
                <p>${desc}</p>
                <div class="actions">
                    <button class="edit-btn" data-id="${cat.id}" aria-label="Edit"><i class="fas fa-edit"></i></button>
                    <button class="delete-btn" data-id="${cat.id}" aria-label="Delete category"><i class="fas fa-trash"></i></button>
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
        updateCategoryDropdowns(); // Ensure dropdown is always up-to-date
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
                document.getElementById('viewFoodCategory').textContent = `Category: ${item.category_name}`;
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
        const formData = new FormData();
        formData.append('action', 'add_category');
        formData.append('name', name);
        formData.append('description', description);
        fetch('admin_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addCategoryForm.reset();
                loadCategories();
                showAdminMessage('Category added successfully!', 'success');
            } else {
                showAdminMessage(data.message || 'An error occurred.', 'error');
            }
        })
        .catch(() => showAdminMessage('An error occurred.', 'error'));
    });

    cancelEditCategoryModal.addEventListener('click', () => {
        editCategoryModal.style.display = 'none';
        editCategoryForm.reset();
    });

    editCategoryForm.addEventListener('submit', e => {
        e.preventDefault();
        const id = editCategoryForm.dataset.id;
        const name = document.getElementById('editCategoryName').value;
        const description = document.getElementById('editCategoryDescription').value;
        const formData = new FormData();
        formData.append('action', 'edit_category');
        formData.append('id', id);
        formData.append('name', name);
        formData.append('description', description);
        fetch('admin_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCategories();
                showAdminMessage('Category updated successfully!', 'success');
            } else {
                showAdminMessage(data.message || 'An error occurred.', 'error');
            }
        })
        .catch(() => showAdminMessage('An error occurred.', 'error'));
    });

    closeViewCategoryModal.addEventListener('click', () => {
        viewCategoryModal.style.display = 'none';
    });

    function addCategoryListeners() {
        document.querySelectorAll('.category-card .delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = parseInt(button.dataset.id);
                customConfirm('Are you sure you want to delete this category?', () => {
                    deleteCategory(id);
                });
            });
        });

        document.querySelectorAll('.category-card .edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = parseInt(button.dataset.id);
                const cat = categories.find(c => c.id === id);
                document.getElementById('editCategoryName').value = cat.name;
                document.getElementById('editCategoryDescription').value = cat.description;
                editCategoryForm.dataset.id = id;
                editCategoryModal.style.display = 'flex';
            });
        });

        document.querySelectorAll('.category-card .view-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = parseInt(button.dataset.id);
                const cat = categories.find(c => c.id === id);
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
                if (!data.length) {
                    feedbackList.innerHTML = '<div style="color:#aaa;">No feedback yet.</div>';
                    return;
                }
                data.forEach(item => {
                    const card = document.createElement('div');
                    card.classList.add('feedback-card');
                    card.innerHTML = `
                        <div style="font-weight:600;font-size:1.1rem;">${item.name} <span style="color:#888;font-size:0.98rem;">(${item.email})</span></div>
                        <div style="margin:0.3rem 0 0.5rem 0;color:#555;"><strong>Subject:</strong> ${item.subject}</div>
                        <div style="margin-bottom:0.5rem;">${item.message}</div>
                        <div style="color:#aaa;font-size:0.9rem;">${item.created_at}</div>
                    `;
                    feedbackList.appendChild(card);
                });
            });
    }
    // Load feedback on reports tab open
    const reportsTab = document.querySelector('a[href="#reports"]');
    if (reportsTab) reportsTab.addEventListener('click', loadFeedback);
    if (document.getElementById('reports').classList.contains('active')) loadFeedback();

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
            // Do NOT change or delete the 'category' field!
            fetch('admin_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showAdminMessage(data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    addFoodItemForm.reset();
                    if (typeof foodPhotoPreview !== 'undefined') foodPhotoPreview.style.display = 'none';
                    if (typeof foodPhotoPathInput !== 'undefined') foodPhotoPathInput.value = '';
                    loadFoods();
                }
            })
            .catch(() => showAdminMessage('An error occurred.', 'error'));
        });
    }


    const logoutConfirmModal = document.getElementById('logoutConfirmModal');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

    confirmLogoutBtn.addEventListener('click', () => {
        
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

    // Inside DOMContentLoaded event, after all other modal/form logic
    // --- Inventory Section Logic ---
    const addInventoryBtn = document.getElementById('addInventoryBtn');
    const addInventoryModal = document.getElementById('addInventoryModal');
    const cancelAddInventoryModal = document.getElementById('cancelAddInventoryModal');
    const addInventoryForm = document.getElementById('addInventoryForm');
    const addInventoryMsg = document.getElementById('addInventoryMsg');
    const editInventoryModal = document.getElementById('editInventoryModal');
    const cancelEditInventoryModal = document.getElementById('cancelEditInventoryModal');
    const editInventoryForm = document.getElementById('editInventoryForm');
    const editInventoryMsg = document.getElementById('editInventoryMsg');
    const inventoryTableBody = document.getElementById('inventoryTableBody');

    function showInventoryMsg(el, msg, type = 'info') {
        el.textContent = msg;
        el.style.display = 'block';
        el.style.background = type === 'error' ? 'rgba(255,107,107,0.12)' : 'rgba(78,205,196,0.10)';
        el.style.color = type === 'error' ? '#ff6b6b' : '#4ecdc4';
        el.style.fontWeight = '600';
        el.style.textAlign = 'center';
        el.style.padding = '1.2rem 0';
        setTimeout(() => { el.style.display = 'none'; }, 3500);
    }

    function loadInventory() {
        fetch('inventory_process.php?action=list')
            .then(res => res.json())
            .then(data => {
                inventoryTableBody.innerHTML = '';
                if (!data.success || !data.items.length) {
                    inventoryTableBody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:#aaa;">No inventory items.</td></tr>';
                    return;
                }
                data.items.forEach(item => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${item.item}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit}</td>
                        <td>${item.status}</td>
                        <td>
                            <button class="edit-btn" data-id="${item.id}"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    inventoryTableBody.appendChild(tr);
                });
                // Add edit/delete listeners
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.onclick = function() {
                        const id = this.getAttribute('data-id');
                        const item = data.items.find(i => i.id == id);
                        document.getElementById('editInventoryId').value = item.id;
                        document.getElementById('editInventoryItem').value = item.item;
                        document.getElementById('editInventoryQuantity').value = item.quantity;
                        document.getElementById('editInventoryUnit').value = item.unit;
                        document.getElementById('editInventoryStatus').value = item.status;
                        editInventoryModal.style.display = 'flex';
                    };
                });
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.onclick = function() {
                        const id = this.getAttribute('data-id');
                        customConfirm('Are you sure you want to delete this inventory item?', () => {
                            fetch('inventory_process.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: new URLSearchParams({action:'delete', id})
                            })
                            .then(res => res.json())
                            .then(data => {
                                showInventoryMsg(addInventoryMsg, data.message, data.success ? 'success' : 'error');
                                if (data.success) loadInventory();
                            });
                        });
                    };
                });
            });
    }

    if (addInventoryBtn && addInventoryModal && addInventoryForm) {
        addInventoryBtn.addEventListener('click', () => {
            addInventoryModal.style.display = 'flex';
        });
        cancelAddInventoryModal.addEventListener('click', () => {
            addInventoryModal.style.display = 'none';
            addInventoryForm.reset();
        });
        addInventoryForm.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(addInventoryForm);
            formData.append('action', 'add');
            fetch('inventory_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                showInventoryMsg(addInventoryMsg, data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    addInventoryForm.reset();
                    addInventoryModal.style.display = 'none';
                    loadInventory();
                }
            });
        };
    }

    if (editInventoryModal && editInventoryForm) {
        cancelEditInventoryModal.addEventListener('click', () => {
            editInventoryModal.style.display = 'none';
            editInventoryForm.reset();
        });
        editInventoryForm.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(editInventoryForm);
            formData.append('action', 'edit');
            fetch('inventory_process.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                showInventoryMsg(editInventoryMsg, data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    editInventoryForm.reset();
                    editInventoryModal.style.display = 'none';
                    loadInventory();
                }
            });
        };
    }

    // Load inventory on inventory tab open
    const inventoryTab = document.querySelector('a[href="#inventory"]');
    if (inventoryTab) inventoryTab.addEventListener('click', loadInventory);
    if (document.getElementById('inventory').classList.contains('active')) loadInventory();
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
    const uniqueCategories = [...new Set(foods.map(f => f.category_name).filter(Boolean))];
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

// --- Admin Settings Section Logic ---
const addAdminForm = document.getElementById('addAdminForm');
const addAdminMsg = document.getElementById('addAdminMsg');
const adminListContainer = document.getElementById('adminListContainer');

function showSettingsMsg(el, msg, type = 'info') {
    el.textContent = msg;
    el.style.display = 'block';
    el.style.background = type === 'error' ? 'rgba(255,107,107,0.12)' : 'rgba(78,205,196,0.10)';
    el.style.color = type === 'error' ? '#ff6b6b' : '#4ecdc4';
    el.style.fontWeight = '600';
    el.style.textAlign = 'center';
    el.style.padding = '1.2rem 0';
    setTimeout(() => { el.style.display = 'none'; }, 3500);
}

function loadAdmins() {
    fetch('admin_settings.php?action=list')
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                adminListContainer.innerHTML = '<div style="color:#ff6b6b;">Failed to load admins.</div>';
                return;
            }
            const currentEmail = data.current_email;
            adminListContainer.innerHTML = `<table style="width:100%;border-collapse:collapse;">
                <thead><tr><th>Email</th><th>Created</th><th>Action</th></tr></thead>
                <tbody>
                    ${data.admins.map(admin => `
                        <tr>
                            <td>${admin.email}${admin.email === currentEmail ? ' <span style=\'color:#4ecdc4;font-weight:700;\'>(You)</span>' : ''}</td>
                            <td>${admin.created_at}</td>
                            <td>
                                ${currentEmail === 'fedluabdulhakim7@gmail.com' && admin.email !== currentEmail ? `<button class='delete-btn' data-id='${admin.id}' style='padding:0.5rem 1.2rem;font-size:1rem;'>Delete</button>` : ''}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>`;
            // Add delete handlers
            adminListContainer.querySelectorAll('.delete-btn').forEach(btn => {
                btn.onclick = function() {
                    const id = this.getAttribute('data-id');
                    customConfirm('Are you sure you want to delete this admin account?', () => {
                        fetch('admin_settings.php', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                            body: new URLSearchParams({action:'delete', id})
                        })
                        .then(res => res.json())
                        .then(data => {
                            showSettingsMsg(addAdminMsg, data.message, data.success ? 'success' : 'error');
                            if (data.success) loadAdmins();
                        });
                    });
                };
            });
        });
}

addAdminForm.addEventListener('submit', e => {
    e.preventDefault();
    const email = document.getElementById('newAdminEmail').value.trim();
    const password = document.getElementById('newAdminPassword').value;
    if (!email || !password) {
        showSettingsMsg(addAdminMsg, 'Email and password are required.', 'error');
        return;
    }
    fetch('admin_settings.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({action:'add', email, password})
    })
    .then(res => res.json())
    .then(data => {
        showSettingsMsg(addAdminMsg, data.message, data.success ? 'success' : 'error');
        if (data.success) {
            addAdminForm.reset();
            loadAdmins();
        }
    });
});

// Load admins on settings tab open
const settingsTab = document.querySelector('a[href="#settings"]');
if (settingsTab) settingsTab.addEventListener('click', loadAdmins);
if (document.getElementById('settings').classList.contains('active')) loadAdmins();
