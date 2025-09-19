<?php

    session_start();
        if (!isset($_SESSION['id'])) {
            header('location: login');
        } 
    
    include_once 'inc/database.php';

    $userId = $_SESSION['id'];

    $sqlCourse = "SELECT COUNT(*) AS courseCount FROM course";
    $stmtCourse = $pdo->prepare($sqlCourse);    
    $stmtCourse->execute();
    $totalCourse = $stmtCourse->fetchColumn();

    $sqlC = "SELECT COUNT(*) AS lesson  FROM progress WHERE userId = :userId";
    $stmtC = $pdo->prepare($sqlC);    
    $stmtC->execute(['userId' => $userId]);
    $totalLesson = $stmtC->fetchColumn();

    $sqlL = "SELECT COUNT(*) AS lesson  FROM lesson";
    $stmtL = $pdo->prepare($sqlL);    
    $stmtL->execute();
    $totalL = $stmtL->fetchColumn();

    $sqlB = "SELECT COUNT(*) AS badge  FROM studentbadge WHERE userId = :userId";
    $stmtB = $pdo->prepare($sqlB);    
    $stmtB->execute(['userId' => $userId]);
    $totalBadge = $stmtB->fetchColumn();

    $sql = "SELECT * FROM course ";       
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();



include_once 'inc/head.php';

?>

<body class="bg-gray-50">
    <link href="https://fonts.cdnfonts.com/css/open-dyslexic" rel="stylesheet">
    <style>
    /* Dyslexia-mode styles */
    .dyslexia-mode {
        font-family: 'OpenDyslexic', 'Atkinson Hyperlegible', Arial, sans-serif !important;
        letter-spacing: 0.04em;
        line-height: 1.75;
        background-color: #fbfbfb;
        color: #111827;
    }

    /* TTS button */
    .tts-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-left: 0.5rem;
        padding: 6px 10px;
        border-radius: 8px;
        background: #4f46e5;
        color: white;
        font-size: 0.875rem;
        cursor: pointer;
        border: none;
    }

    .tts-small {
        padding: 4px 8px;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .tts-button:focus {
        outline: 3px solid rgba(79, 70, 229, 0.25);
    }

    .progress-ring__circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    </style>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once 'inc/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex flex-col flex-1">
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
            <div class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">Your Learning Progress</h1>
                        <p class="text-gray-500">Track your progress across all courses and lessons</p>
                    </div>
                    <div class="mb-6 flex gap-3">
                        <button id="toggle-dyslexia" class="tts-button">A11y: Dyslexia Mode</button>
                        <button id="read-page" class="tts-button">🔊 Read Page</button>
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

                    <!-- Progress Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Overall Progress -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900">Overall Progress</h2>
                                <span class="text-sm text-gray-500">Last 30 days</span>
                            </div>
                            <div class="flex items-center justify-center py-8">
                                <?php
        // Prevent division by zero
        $percentage = $totalL > 0 ? round(($totalLesson / $totalL) * 100) : 0;

        $radius = 40;
        $circumference = 2 * M_PI * $radius;
        $offset = $circumference - ($percentage / 100 * $circumference);
    ?>
                                <div class="relative w-48 h-48">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <!-- Background circle -->
                                        <circle class="text-gray-200" stroke-width="8" stroke="currentColor"
                                            fill="transparent" r="<?= $radius ?>" cx="50" cy="50" />

                                        <!-- Progress circle -->
                                        <circle class="progress-ring__circle text-indigo-600" stroke-width="8"
                                            stroke-dasharray="<?= $circumference ?>" stroke-dashoffset="<?= $offset ?>"
                                            stroke-linecap="round" stroke="currentColor" fill="transparent"
                                            r="<?= $radius ?>" cx="50" cy="50"
                                            style="transform: rotate(-90deg); transform-origin: 50% 50%;" />
                                    </svg>

                                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                                        <div class="text-center">
                                            <p class="text-3xl font-bold text-gray-900"><?= $percentage ?>%</p>
                                            <p class="text-sm text-gray-500">Completed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-sm text-gray-500">Courses</p>
                                    <p class="text-lg font-semibold text-gray-900"><?php echo $totalCourse ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lessons</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        <?php echo $totalLesson  ?>/<?php echo $totalL  ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Earned Badges</p>
                                    <p class="text-lg font-semibold text-gray-900"><?php echo $totalBadge ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Course Progress -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Course Progress</h2>
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="divide-y divide-gray-200">
                                    <!-- Example items -->
                                    <?php foreach($rows as $row):

                                    $courseId = $row -> id;

                                    $sql = "SELECT COUNT(*) AS lessonCount FROM lesson 
                                    INNER JOIN section ON lesson.sectionId = section.id 
                                    WHERE section.courseId = :courseId";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':courseId', $courseId);
                                    $stmt->execute();
                                    $lessonData = $stmt->fetchColumn();

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
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-sm font-medium text-gray-900"><?php $row -> title ?></h3>
                                            <span class="text-sm text-gray-500"><?php echo $percentage ?>%
                                                complete</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-600 h-2 rounded-full"
                                                style="width: <?php echo $percentage ?>%"></div>
                                        </div>
                                        <div class="flex justify-between mt-2 text-xs text-gray-500">
                                            <span><?php echo $lessonP ?>/<?php echo $lessonData ?> lessons</span>

                                        </div>
                                    </div>
                                    <?php endforeach; ?>

                                    <!-- More courses... -->
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

  // ===== Simple TTS function =====
function speak(text, opts = {}) {
    if (!('speechSynthesis' in window)) {
        alert('Text-to-Speech not supported by this browser.');
        return;
    }
    window.speechSynthesis.cancel();
    const utter = new SpeechSynthesisUtterance(text);
    utter.rate = opts.rate || 0.9; // slower for readability
    utter.pitch = opts.pitch || 1;
    utter.lang = "en-US";
    speechSynthesis.speak(utter);
}

// ===== Read entire page =====
document.getElementById('read-page').addEventListener('click', () => {
    const text = document.body.innerText;
    speak(text);
});

// ===== Dyslexia mode toggle =====
document.getElementById('toggle-dyslexia').addEventListener('click', (e) => {
    const enabled = document.body.classList.toggle('dyslexia-mode');
    e.target.innerText = enabled ? 'A11y: Dyslexia Mode ✓' : 'A11y: Dyslexia Mode';
});

    </script>
</body>

</html>