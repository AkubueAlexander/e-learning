<?php include_once '../inc/head.php'; ?> ?>
<body class="bg-gray-50">
     <style>       
        .note-tag {
            transition: all 0.2s;
        }
        .note-tag:hover {
            transform: translateY(-2px);
        }
    </style>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
       <?php include_once '../inc/sidebar.php'; ?>
       

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Mobile header -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <i data-feather="menu" class="text-gray-500 mr-2"></i>
                    <span class="text-gray-800 font-semibold">LearnHub</span>
                </div>
                <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/women/44.jpg" alt="User profile">
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Notes & Highlights</h1>
                            <p class="text-gray-500">All your saved notes and highlighted content</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i data-feather="plus" class="w-4 h-4 inline mr-1"></i> New Note
                            </button>
                        </div>
                    </div>

                    <!-- Filter and Search -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div class="flex space-x-2 mb-4 md:mb-0">
                            <button class="px-3 py-1 bg-indigo-600 text-white text-xs font-medium rounded-full">All</button>
                            <button class="px-3 py-1 bg-white text-gray-600 text-xs font-medium rounded-full border border-gray-300 hover:bg-gray-50">JavaScript</button>
                            <button class="px-3 py-1 bg-white text-gray-600 text-xs font-medium rounded-full border border-gray-300 hover:bg-gray-50">Database</button>
                            <button class="px-3 py-1 bg-white text-gray-600 text-xs font-medium rounded-full border border-gray-300 hover:bg-gray-50">Design</button>
                        </div>
                        <div class="relative">
                            <input type="text" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search notes...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-feather="search" class="text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Note Card 1 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        Advanced JavaScript
                                    </span>
                                    <div class="flex space-x-2">
                                        <button class="text-gray-400 hover:text-indigo-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Closures and Scope</h3>
                                <div class="prose prose-sm max-w-none text-gray-500 mb-4">
                                    <p>Closures allow functions to access variables from an enclosing scope even after the outer function has returned. This is because the function maintains a reference to its lexical environment.</p>
                                    <p class="bg-yellow-50 p-2 rounded italic mt-2">"Remember: A closure is created when a function is defined, not when it is executed."</p>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">closures</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">scope</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">functions</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                    <span>Created: 2 days ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Note Card 2 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Database Design
                                    </span>
                                    <div class="flex space-x-2">
                                        <button class="text-gray-400 hover:text-indigo-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Normalization Rules</h3>
                                <div class="prose prose-sm max-w-none text-gray-500 mb-4">
                                    <p>First Normal Form (1NF): Eliminate repeating groups in individual tables. Create a separate table for each set of related data. Identify each set with a primary key.</p>
                                    <p class="bg-yellow-50 p-2 rounded italic mt-2">"Second Normal Form (2NF): Create relationships between these new tables using foreign keys."</p>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">normalization</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">database</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                    <span>Created: 1 week ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Note Card 3 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        UI/UX Design
                                    </span>
                                    <div class="flex space-x-2">
                                        <button class="text-gray-400 hover:text-indigo-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Color Psychology</h3>
                                <div class="prose prose-sm max-w-none text-gray-500 mb-4">
                                    <p>Blue: Often associated with trust, security, and stability. Commonly used by financial institutions and tech companies.</p>
                                    <p class="bg-yellow-50 p-2 rounded italic mt-2">"Red: Creates a sense of urgency, often used for clearance sales. Also stimulates appetite, which is why many food brands use it."</p>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">colors</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">psychology</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">design</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                    <span>Created: 2 weeks ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Note Card 4 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        Advanced JavaScript
                                    </span>
                                    <div class="flex space-x-2">
                                        <button class="text-gray-400 hover:text-indigo-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Promise Patterns</h3>
                                <div class="prose prose-sm max-w-none text-gray-500 mb-4">
                                    <p>Promise.all() takes an array of promises and returns a single promise that resolves when all of the promises in the array have resolved.</p>
                                    <p class="bg-yellow-50 p-2 rounded italic mt-2">"Promise.race() returns a promise that resolves or rejects as soon as one of the promises in the array resolves or rejects."</p>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">async</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">promises</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                    <span>Created: 3 weeks ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Note Card 5 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Database Design
                                    </span>
                                    <div class="flex space-x-2">
                                        <button class="text-gray-400 hover:text-indigo-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Indexing Strategies</h3>
                                <div class="prose prose-sm max-w-none text-gray-500 mb-4">
                                    <p>Indexes should be created on columns that are frequently used in WHERE clauses, JOIN conditions, or as part of an ORDER BY.</p>
                                    <p class="bg-yellow-50 p-2 rounded italic mt-2">"Be careful with over-indexing as each index adds overhead to INSERT, UPDATE, and DELETE operations."</p>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">performance</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">indexes</span>
                                    <span class="note-tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">optimization</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <i data-feather="calendar" class="w-3 h-3 mr-1"></i>
                                    <span>Created: 1 month ago</span>
                                </div>
                            </div>
                        </div>

                        <!-- Note Card 6 -->
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        UI/UX Design
                                    </span>
                                    <div class="flex space-x-2">
                                        <button class="text-gray-400 hover:text-indigo-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Fitts's Law</h3>
                                <div class="prose prose-sm max-w-none text-gray-500 mb-4">
                                    <p>Fitts's Law states that the time required to move to a target area is a function of the distance to the target and the size of the target.</p>
                                    <p class="bg-yellow-50 p-2 rounded italic mt-2">"Important UI implications: Make clickable elements large enough and position frequently used elements near the natural resting position of the pointer."</p>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <
</body>
</html>