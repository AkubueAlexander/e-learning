<?php 
 session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once 'inc/database.php';
 
   $sql = "SELECT * FROM course";       
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    

    $userId = $_SESSION['id'];


include_once 'inc/head.php';

?> 

<body class="bg-gray-50 h-screen overflow-hidden">
    <div class="flex justify-between items-center p-4 bg-gray-100 border-b">
        <button id="toggle-dyslexia" class="px-3 py-2 bg-green-600 text-white rounded">
            Toggle Dyslexia-Friendly Mode
        </button>
        <button id="read-all" class="px-3 py-2 bg-indigo-600 text-white rounded">
            🔊 Read Page
        </button>
    </div>
    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #10B981;
        }
        html, body {
            height: 100%;
            overflow: hidden; /* Prevents double scrollbar */
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .course-tab.active {
            border-bottom: 2px solid #4F46E5;
            color: #4F46E5;
        }
    </style>
    <div class="flex h-full">
        <!-- Sidebar -->
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

            <!-- Content (scroll only here) -->
            <div class="flex-1 overflow-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">Courses</h1>
                        
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
                        <div class="bg-white rounded-lg shadow overflow-hidden course-card">
                            <div class="h-40 <?php echo $row -> bg ?> flex items-center justify-center">
                                <i data-feather="<?php echo $row -> icon ?>" class="text-white w-12 h-12"></i>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $row -> title ?>
                                    </h3>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        In Progress
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

  // Toggle dyslexia-friendly mode
  document.getElementById('toggle-dyslexia').addEventListener('click', () => {
      document.body.classList.toggle('dyslexia-mode');
  });

  // Speak function
  function speak(text) {
      const utterance = new SpeechSynthesisUtterance(text);
      utterance.rate = 1;   // speed
      utterance.pitch = 1;  // natural tone
      speechSynthesis.cancel(); // cancel any previous
      speechSynthesis.speak(utterance);
  }

  // Read entire page
  document.getElementById('read-all').addEventListener('click', () => {
      let text = document.body.innerText;
      speak(text);
  });

  // Add "🔊 Read Course" buttons to each course card
  document.querySelectorAll('.course-card').forEach((card) => {
      let btn = document.createElement('button');
      btn.innerText = "🔊 Read Course";
      btn.className = "tts-button";
      btn.onclick = () => {
          let text = card.innerText;
          speak(text);
      };
      card.querySelector('.p-6').appendChild(btn);
  });
</script>
</body>
</html>
