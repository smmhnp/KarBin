<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<script>
// Page title mapping
const pageTitles = {
    'login-screen': 'ورود به سیستم - TaskFlow',
    'register-screen': 'ثبت‌نام کاربر - TaskFlow',
    'dashboard-screen': 'داشبورد وظایف - TaskFlow',
    'workflow-board-screen': 'تابلوی جریان کار - TaskFlow',
    'task-detail-screen': 'جزئیات وظیفه - TaskFlow',
    'task-form-screen': 'ایجاد/ویرایش وظیفه - TaskFlow',
    'profile-screen': 'پروفایل و تنظیمات - TaskFlow',
    'notifications-screen': 'مرکز اعلان‌ها - TaskFlow',
    'projects-screen': 'مدیریت پروژه‌ها - TaskFlow',
    'admin-users-screen': 'مدیریت کاربران - TaskFlow'
};

// Global variables to track current filters
const activeFilters = {
    dashboard: {
        status: 'all',
        priority: 'all',
        project: 'all',
        assignee: 'all',
        search: ''
    },
    workflow: {
        priority: 'all',
        project: 'all',
        assignee: 'all',
        search: ''
    }
};

// Show the tab based on URL hash
function showTab(tabId) {
    // Hide all sections
    document.querySelectorAll('section[id$="-screen"]').forEach(section => {
        section.style.display = 'none';
    });

    // Show the requested section
    const targetSection = document.getElementById(tabId);
    if (targetSection) {
        targetSection.style.display = 'block';
        
        // Update page title
        document.title = pageTitles[tabId] || 'سیستم مدیریت وظایف - TaskFlow';
        
        // Update main title visibility based on section
        const pageTitle = document.getElementById('page-title');
        if (tabId === 'login-screen' || tabId === 'register-screen') {
            pageTitle.style.display = 'none';
        } else {
            pageTitle.style.display = 'block';
            pageTitle.textContent = 'سیستم مدیریت وظایف سازمانی';
        }

        // Update navigation active state
        updateNavActiveState(tabId);
        
        // Update task counts when entering workflow screen
        if (tabId === 'workflow-board-screen') {
            updateTaskCounts();
        }
    } else {
        // Fallback to login screen if section not found
        document.getElementById('login-screen').style.display = 'block';
    }
    
    // Hide mobile menu if it was open
    const mobileMenu = document.querySelector('.mobile-menu-drawer');
    mobileMenu.classList.remove('open');
}

// Update active state in navigation
function updateNavActiveState(activeTabId) {
    // Desktop nav
    document.querySelectorAll('.main-nav .nav-link').forEach(link => {
        const href = link.getAttribute('href').substring(1); // Remove #
        if (href === activeTabId) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Mobile nav
    document.querySelectorAll('.mobile-menu-drawer .mobile-nav-link').forEach(link => {
        const href = link.getAttribute('href').substring(1); // Remove #
        if (href === activeTabId) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// Handle hash change
function handleHashChange() {
    const hash = window.location.hash.substring(1) || 'login-screen';
    showTab(hash);
}

// Filter Dropdown Toggle
function setupFilterButtons() {
    // Get all filter buttons
    const filterButtons = document.querySelectorAll('.btn-filter');
    
    // Add click event to each button
    filterButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const filterId = this.id.replace('FilterBtn', 'FilterDropdown');
            const dropdown = document.getElementById(filterId);
            
            // Close all other dropdowns first
            document.querySelectorAll('.filter-dropdown').forEach(d => {
                if (d.id !== filterId) {
                    d.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        });
    });
    
    // Close dropdown when clicking elsewhere
    document.addEventListener('click', function() {
        document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    });
    
    // Prevent closing when clicking inside dropdown
    document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
        dropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
    
    // Close button in dropdown
    document.querySelectorAll('.filter-dropdown-close').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.filter-dropdown').classList.remove('show');
        });
    });
    
    // Filter dropdown items
    document.querySelectorAll('.filter-dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            // Update active state
            const dropdown = this.closest('.filter-dropdown');
            dropdown.querySelectorAll('.filter-dropdown-item').forEach(di => {
                di.classList.remove('active');
            });
            this.classList.add('active');
            
            // Get filter type and value
            const filterId = dropdown.id;
            const filterType = dropdown.previousElementSibling.getAttribute('data-filter');
            const filterValue = this.getAttribute('data-value');
            
            // Update button text
            const buttonText = filterType === 'status' ? `وضعیت: ${getFilterLabel(filterType, filterValue)}` :
                                filterType === 'priority' ? `اولویت: ${getFilterLabel(filterType, filterValue)}` :
                                filterType === 'project' ? `پروژه: ${getFilterLabel(filterType, filterValue)}` :
                                `مسئول: ${getFilterLabel(filterType, filterValue)}`;
            
            dropdown.previousElementSibling.innerHTML = buttonText + ' <i class="fas fa-chevron-down"></i>' + 
                                                        '<span class="filtered-indicator"></span>';
            
            // Is this button in workflow or dashboard?
            const screen = dropdown.id.startsWith('workflow') ? 'workflow' : 'dashboard';
            
            // Update active filters
            activeFilters[screen][filterType] = filterValue;
            
            // Visual indication of active filter
            if (filterValue !== 'all') {
                dropdown.previousElementSibling.classList.add('is-filtered');
            } else {
                dropdown.previousElementSibling.classList.remove('is-filtered');
            }
            
            // Apply filter
            if (screen === 'dashboard') {
                filterDashboardTasks();
            } else {
                filterWorkflowTasks();
            }
            
            // Close dropdown
            dropdown.classList.remove('show');
        });
    });
}

// Get human-readable filter labels
function getFilterLabel(type, value) {
    if (value === 'all') return 'همه';
    
    const labels = {
        status: {
            todo: 'برای انجام',
            inprogress: 'در حال انجام',
            review: 'بازبینی',
            done: 'انجام شده'
        },
        priority: {
            high: 'بالا',
            medium: 'متوسط',
            low: 'پایین'
        },
        project: {
            alpha: 'پروژه آلفا',
            beta: 'پروژه بتا'
        }
    };
    
    return type === 'assignee' ? value : labels[type][value];
}

// Function to filter dashboard tasks
function filterDashboardTasks() {
    const { status, priority, project, assignee, search } = activeFilters.dashboard;
    const rows = document.querySelectorAll('#tasks-table-body tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        const rowPriority = row.getAttribute('data-priority');
        const rowProject = row.getAttribute('data-project');
        const rowAssignee = row.getAttribute('data-assignee');
        
        // Get all searchable text from the row
        const searchableText = row.textContent.toLowerCase();
        const searchMatch = !search || searchableText.includes(search.toLowerCase());
        
        // Check if row matches all active filters
        const statusMatch = status === 'all' || rowStatus === status;
        const priorityMatch = priority === 'all' || rowPriority === priority;
        const projectMatch = project === 'all' || rowProject === project;
        const assigneeMatch = assignee === 'all' || rowAssignee === assignee;
        
        if (statusMatch && priorityMatch && projectMatch && assigneeMatch && searchMatch) {
            row.classList.remove('filtered-out');
            visibleCount++;
            
            // Highlight search term if present
            if (search) {
                highlightSearchTerm(row, search);
            } else {
                // Remove any existing highlights
                removeHighlights(row);
            }
        } else {
            row.classList.add('filtered-out');
        }
    });
    
    // Update "no results" message if needed
    const tableContainer = document.querySelector('.table-container');
    let noResultsMsg = tableContainer.querySelector('.no-results-message');
    
    if (visibleCount === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results-message';
            noResultsMsg.style.padding = '20px';
            noResultsMsg.style.textAlign = 'center';
            noResultsMsg.style.color = 'var(--text-muted)';
            noResultsMsg.innerHTML = 'هیچ وظیفه‌ای با فیلترهای انتخاب شده پیدا نشد.<br>لطفاً فیلترها را تغییر دهید.';
            tableContainer.appendChild(noResultsMsg);
        }
    } else if (noResultsMsg) {
        noResultsMsg.remove();
    }
}

// Function to filter workflow tasks
function filterWorkflowTasks() {
    const { priority, project, assignee, search } = activeFilters.workflow;
    const cards = document.querySelectorAll('.task-card-horizontal');
    let visibleCount = 0;
    
    // Reset visible counts for each stage
    const stageCounts = {
        todo: 0,
        inprogress: 0,
        review: 0,
        done: 0
    };
    
    cards.forEach(card => {
        const cardPriority = card.getAttribute('data-priority');
        const cardProject = card.getAttribute('data-project');
        const cardAssignee = card.getAttribute('data-assignee');
        const stageId = card.closest('.stage-tasks').id.split('-')[0]; // Extract 'todo' from 'todo-tasks'
        
        // Get all searchable text from the card
        const searchableText = card.textContent.toLowerCase();
        const searchMatch = !search || searchableText.includes(search.toLowerCase());
        
        // Check if card matches all active filters
        const priorityMatch = priority === 'all' || cardPriority === priority;
        const projectMatch = project === 'all' || cardProject === project;
        const assigneeMatch = assignee === 'all' || cardAssignee === assignee;
        
        if (priorityMatch && projectMatch && assigneeMatch && searchMatch) {
            card.classList.remove('filtered-out');
            visibleCount++;
            stageCounts[stageId]++;
            
            // Highlight search term if present
            if (search) {
                highlightSearchTerm(card, search);
            } else {
                // Remove any existing highlights
                removeHighlights(card);
            }
        } else {
            card.classList.add('filtered-out');
        }
    });
    
    // Update task counts for each stage
    updateTaskCounts(stageCounts);
    
    // Show "no tasks" message if needed in each stage
    document.querySelectorAll('.stage-tasks').forEach(stage => {
        const stageId = stage.id.split('-')[0];
        let visibleInStage = stageCounts[stageId];
        let noTasksMsg = stage.querySelector('.no-tasks-message');
        
        if (visibleInStage === 0) {
            if (!noTasksMsg) {
                noTasksMsg = document.createElement('div');
                noTasksMsg.className = 'no-tasks-message';
                noTasksMsg.style.padding = '20px';
                noTasksMsg.style.textAlign = 'center';
                noTasksMsg.style.color = 'var(--text-muted)';
                noTasksMsg.style.backgroundColor = 'var(--background-alt)';
                noTasksMsg.style.borderRadius = 'var(--border-radius-md)';
                noTasksMsg.innerHTML = 'هیچ وظیفه‌ای با فیلترهای انتخاب شده در این مرحله وجود ندارد';
                stage.appendChild(noTasksMsg);
            }
        } else if (noTasksMsg) {
            noTasksMsg.remove();
        }
    });
}

// Update task counts in workflow view
function updateTaskCounts(counts = null) {
    if (!counts) {
        // If no counts provided, count visible tasks in each stage
        counts = {
            todo: document.querySelectorAll('#todo-tasks .task-card-horizontal:not(.filtered-out)').length,
            inprogress: document.querySelectorAll('#inprogress-tasks .task-card-horizontal:not(.filtered-out)').length,
            review: document.querySelectorAll('#review-tasks .task-card-horizontal:not(.filtered-out)').length,
            done: document.querySelectorAll('#done-tasks .task-card-horizontal:not(.filtered-out)').length
        };
    }
    
    // Update the DOM with counts
    document.querySelector('.workflow-stage:nth-child(1) .task-count').textContent = `(${counts.todo})`;
    document.querySelector('.workflow-stage:nth-child(2) .task-count').textContent = `(${counts.inprogress})`;
    document.querySelector('.workflow-stage:nth-child(3) .task-count').textContent = `(${counts.review})`;
    document.querySelector('.workflow-stage:nth-child(4) .task-count').textContent = `(${counts.done})`;
}

// Search functionality
function setupSearch() {
    // Dashboard search
    const dashboardSearch = document.getElementById('dashboard-search');
    dashboardSearch.addEventListener('input', function() {
        activeFilters.dashboard.search = this.value;
        filterDashboardTasks();
    });
    
    // Workflow search
    const workflowSearch = document.getElementById('workflow-search');
    workflowSearch.addEventListener('input', function() {
        activeFilters.workflow.search = this.value;
        filterWorkflowTasks();
    });
}

// Highlight search term in text
function highlightSearchTerm(element, term) {
    // First remove any existing highlights
    removeHighlights(element);
    
    // No search term, nothing to highlight
    if (!term) return;
    
    // Get all text nodes inside this element
    const textNodes = getAllTextNodes(element);
    
    for (let node of textNodes) {
        const text = node.nodeValue;
        const lowercaseText = text.toLowerCase();
        const lowercaseTerm = term.toLowerCase();
        
        if (lowercaseText.includes(lowercaseTerm)) {
            const parts = text.split(new RegExp(`(${escapeRegExp(term)})`, 'gi'));
            const fragment = document.createDocumentFragment();
            
            parts.forEach(part => {
                if (part.toLowerCase() === lowercaseTerm) {
                    // This part matches the search term, highlight it
                    const highlight = document.createElement('span');
                    highlight.className = 'search-highlight';
                    highlight.textContent = part;
                    fragment.appendChild(highlight);
                } else {
                    // This is just regular text
                    fragment.appendChild(document.createTextNode(part));
                }
            });
            
            // Replace the text node with our fragment
            node.parentNode.replaceChild(fragment, node);
        }
    }
}

// Remove highlight spans
function removeHighlights(element) {
    const highlights = element.querySelectorAll('.search-highlight');
    highlights.forEach(highlight => {
        const parent = highlight.parentNode;
        parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
        parent.normalize(); // Merge adjacent text nodes
    });
}

// Escape special characters in search term for RegExp
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Get all text nodes inside an element
function getAllTextNodes(element) {
    const textNodes = [];
    const walker = document.createTreeWalker(
        element,
        NodeFilter.SHOW_TEXT,
        {
            acceptNode: function(node) {
                // Skip empty text nodes and nodes inside highlights
                if (node.nodeValue.trim() === '' || 
                    node.parentNode.classList?.contains('search-highlight')) {
                    return NodeFilter.FILTER_REJECT;
                }
                return NodeFilter.FILTER_ACCEPT;
            }
        }
    );
    
    let node;
    while (node = walker.nextNode()) {
        textNodes.push(node);
    }
    
    return textNodes;
}

// Handle mobile menu toggle
document.getElementById('toggleMobileMenu').addEventListener('click', function() {
    const mobileMenu = document.querySelector('.mobile-menu-drawer');
    mobileMenu.classList.toggle('open');
});

// Initialize
window.addEventListener('hashchange', handleHashChange);

// On page load
document.addEventListener('DOMContentLoaded', function() {
    // Setup filter buttons
    setupFilterButtons();
    
    // Setup search functionality
    setupSearch();
    
    // Initialize with hash or login screen
    if (window.location.hash) {
        handleHashChange();
    } else {
        window.location.hash = '#login-screen';
    }
});
</script>