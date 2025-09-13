<?php 
    session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once '../inc/database.php';

    $userId = $_SESSION['id'];
 
  

    $sqlCourse = "SELECT COUNT(*) AS courseCount FROM course";
    $stmtCourse = $pdo->prepare($sqlCourse);    
    $stmtCourse->execute();
    $totalCourse = $stmtCourse->fetchColumn();

    $sqlC = "SELECT COUNT(*) AS compltedCourse  FROM progress";
    $stmtC = $pdo->prepare($sqlC);    
    $stmtC->execute();
    $totalLesson = $stmtC->fetchColumn();

    $sqlB = "SELECT COUNT(*) AS users  FROM user";
    $stmtB = $pdo->prepare($sqlB);    
    $stmtB->execute();
    $totalUser = $stmtB->fetchColumn();

    

    



include_once 'inc/head.php'; 
?>

<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <?php include_once 'inc/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Mobile header -->
            <div class="md:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
                <button class="text-gray-600 focus:outline-none" id="mobile-menu-button">
                    <i data-feather="menu" class="w-6 h-6"></i>
                </button>
                <span class="text-xl font-bold text-gray-800 letter-spacing-wide">LearnHub</span>

            </div>

            <!-- Mobile sidebar (hidden by default) -->
            <div class="hidden md:hidden fixed inset-0 z-40" id="mobile-sidebar">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="mobile-sidebar-backdrop"></div>
                <div class="relative flex flex-col w-80 max-w-xs h-full bg-white">
                    <div class="flex items-center justify-between h-20 px-6 bg-indigo-600">
                        <div class="flex items-center">
                            <i data-feather="book" class="text-white mr-3 sidebar-icon"></i>
                            <span class="text-white font-bold text-xl letter-spacing-wide">LearnHub</span>
                        </div>
                        <button class="text-white focus:outline-none" id="close-mobile-menu">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <div class="flex-1 px-4 py-6 overflow-y-auto">
                        <nav class="flex-1 space-y-1">
                            <a href="index" class="flex items-center sidebar-item active">
                                <i data-feather="home" class="sidebar-icon"></i>
                                <span class="text-lg">Dashboard</span>
                            </a>
                            <a href="course" class="flex items-center sidebar-item">
                                <i data-feather="book-open" class="sidebar-icon"></i>
                                <span class="text-lg">Courses</span>
                            </a>
                            <a href="progress" class="flex items-center sidebar-item">
                                <i data-feather="trending-up" class="sidebar-icon"></i>
                                <span class="text-lg">Progress</span>
                            </a>
                            <a href="badge" class="flex items-center sidebar-item">
                                <i data-feather="award" class="sidebar-icon"></i>
                                <span class="text-lg">Badges</span>
                            </a>
                            <a href="lesson" class="flex items-center sidebar-item">
                                <i data-feather="file-text" class="sidebar-icon"></i>
                                <span class="text-lg">Lessons</span>
                            </a>
                            <a href="section" class="flex items-center sidebar-item">
                                <i data-feather="layers" class="sidebar-icon"></i>
                                <span class="text-lg">Sections</span>
                            </a>
                            <a href="student-badge" class="flex items-center sidebar-item">
                                <i data-feather="user-check" class="sidebar-icon"></i>
                                <span class="text-lg">Student Badges</span>
                            </a>
                            <a href="user" class="flex items-center sidebar-item">
                                <i data-feather="users" class="sidebar-icon"></i>
                                <span class="text-lg">Users</span>
                            </a>
                            
                        </nav>
                    </div>
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center">

                            <div class="ml-3">
                               
                                <p class="text-sm text-gray-600">Admin </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-auto p-6 readable-font">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">Welcome back, <span
                                class="highlight-text">Admin</span>!</h1>
                        <div class="flex space-x-3">
                            

                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <!-- Active Courses -->
                        <div
                            class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                    <i data-feather="book-open" class="w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-lg font-medium text-gray-500"> Courses</p>
                                    <p class="text-3xl font-bold text-gray-900"><?php echo $totalCourse ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Lessons -->
                        <div
                            class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i data-feather="check-circle" class="w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-lg font-medium text-gray-500">Completed Lessons</p>
                                    <p class="text-3xl font-bold text-gray-900"><?php echo $totalLesson ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Earned Badges -->
                        <div
                            class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i data-feather="users" class="w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-lg font-medium text-gray-500">Total Users</p>
                                    <p class="text-3xl font-bold text-gray-900"><?php echo $totalUser ?></p>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>



    <script>
    feather.replace();
    AOS.init();

    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.remove('hidden');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.add('hidden');
    });

    document.getElementById('mobile-sidebar-backdrop').addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.add('hidden');
    });
    </script>
</body>

</html>