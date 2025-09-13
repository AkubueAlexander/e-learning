<?php 
    session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once 'inc/database.php';

    $userId = $_SESSION['id'];
 
   $sql = "SELECT * FROM course LIMIT 3";       
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $sqlCourse = "SELECT COUNT(*) AS courseCount FROM course";
    $stmtCourse = $pdo->prepare($sqlCourse);    
    $stmtCourse->execute();
    $totalCourse = $stmtCourse->fetchColumn();

    $sqlC = "SELECT COUNT(*) AS compltedCourse  FROM progress WHERE userId = :userId";
    $stmtC = $pdo->prepare($sqlC);    
    $stmtC->execute(['userId' => $userId]);
    $totalLesson = $stmtC->fetchColumn();

    $sqlB = "SELECT COUNT(*) AS badge  FROM studentbadge WHERE userId = :userId";
    $stmtB = $pdo->prepare($sqlB);    
    $stmtB->execute(['userId' => $userId]);
    $totalBadge = $stmtB->fetchColumn();

    

    



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
                            <a href="settings" class="flex items-center sidebar-item">
                                <i data-feather="settings" class="sidebar-icon"></i>
                                <span class="text-lg">Settings</span>
                            </a>
                        </nav>
                    </div>
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center">
                           
                            <div class="ml-3">
                                <p class="text-base font-bold text-gray-900"><?php echo $rowUser -> fullName ?></p>
                                <p class="text-sm text-gray-600">Premium Member</p>
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
                                class="highlight-text"><?php echo $rowUser -> fullName ?></span>!</h1>
                        <div class="flex space-x-3">
                            <button onclick="window.location.href='course';"
                                class="px-5 py-3 bg-indigo-600 text-white text-base font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                                <i data-feather="plus" class="w-5 h-5 inline mr-2"></i> New Course
                            </button>

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
                                    <i data-feather="award" class="w-6 h-6"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-lg font-medium text-gray-500">Earned Badges</p>
                                    <p class="text-3xl font-bold text-gray-900"><?php echo $totalBadge ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Course Card -->
                        <?php foreach($rows as $row):

                         $courseId = $row -> id;

                            $sql = "SELECT COUNT(*) AS lessonCount FROM lesson 
                                    INNER JOIN section ON lesson.sectionId = section.id 
                                    WHERE section.courseId = :courseId";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':courseId', $courseId);
                            $stmt->execute();
                            $lessonData = $stmt->fetchColumn();

                            $sqlTime = "SELECT ROUND(
                            IFNULL(SUM(TIME_TO_SEC(STR_TO_DATE(duration, '%i:%s'))) / 3600, 0), 2
                            ) AS totalHours
                            FROM lesson
                            INNER JOIN section ON lesson.sectionId = section.id
                            WHERE section.courseId = :courseId";
                                            $stmtTime = $pdo->prepare($sqlTime);
                            $stmtTime->bindParam(':courseId', $courseId);
                            $stmtTime->execute();
                            $totalDuration = $stmtTime->fetchColumn();

                            $sqlP = "SELECT COUNT(*) 
                            FROM progress 
                            WHERE courseId = :courseId 
                            AND userId = :userId";

                        $stmtP = $pdo->prepare($sqlP);
                        $stmtP->execute([
                            ':courseId' => $courseId,
                            ':userId'   => $userId
                        ]);

                        $lessonP = $stmtP->fetchColumn();
                       
                        
                        if ($lessonData == 0) {
                        $percentage = 0; // or null, or handle it differently
                        } else {
                        $percentage = round(($lessonP / $lessonData) * 100);

                        
                        }



                            

                            
                        ?>
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="h-40 <?php echo $row -> bg ?> flex items-center justify-center">
                                <i data-feather="<?php echo $row -> icon ?>" class="text-white w-12 h-12"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $row -> title ?>
                                    </h3>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        <?php echo $row -> level ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mb-4"><?php echo $row -> des ?></p>
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i data-feather="clock" class="w-4 h-4 mr-1"></i>
                                    <span> <?php echo $totalDuration ?> hours</span>
                                    <i data-feather="book" class="w-4 h-4 ml-3 mr-1"></i>
                                    <span><?php echo $lessonData ?> lessons</span>
                                </div>
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                                        <span>Progress</span>
                                        <span><?php echo $percentage ?>%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full"
                                            style="width: <?php echo $percentage ?>%"></div>
                                    </div>
                                </div>
                                <button onclick="window.location.href='course-detail?title=<?php echo $row -> title ?>';"
                                    class="w-full px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Continue Learning
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>


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