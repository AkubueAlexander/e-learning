<?php
    session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once 'inc/database.php';


    $title = $_GET['title'];
 
   $sql = "SELECT * FROM course WHERE title = :title";       
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title]);
    $row = $stmt->fetch();

    $sqlS = "SELECT * FROM section WHERE courseId = :courseId";       
    $stmtS = $pdo->prepare($sqlS);
    $stmtS->execute(['courseId' => $row -> id]);
    $rows = $stmtS->fetchAll();
   

    

    $userId = $_SESSION['id'];

 include_once 'inc/head.php'; 
 ?>

<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <style>
    @import url('https://fonts.cdnfonts.com/css/open-dyslexic');

    body {
        font-family: 'OpenDyslexic', 'Atkinson Hyperlegible', Arial, sans-serif;
        letter-spacing: 0.3px;
        line-height: 1.6;
    }

    .lesson-completed {
        color: #16A34A;
        font-weight: bold;
    }

    .accordion-content {
        display: none;
    }

    .accordion-content.active {
        display: block;
    }

    .lesson-item:hover {
        background: #fef3c7;
        /* warm yellow highlight */
        transform: scale(1.01);
        transition: 0.2s;
    }

    .accordion-toggle {
        background: linear-gradient(to right, #a78bfa, #60a5fa);
        color: white;
        border-radius: 0.75rem;
    }

    .accordion-toggle i {
        transition: transform 0.2s;
    }

    #lesson-viewer {
        border: 3px solid #d8b4fe;
        background: #faf5ff;
    }
    </style>

    <div class="flex h-screen overflow-hidden">
        <?php include_once 'inc/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">

            <!-- Header -->
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

            <!-- Course Content -->
            <div class="flex-1 overflow-auto p-6">
                <div class="max-w-6xl mx-auto space-y-8">

                    <!-- Course Header -->
                    <div class="bg-gradient-to-r from-pink-200 via-purple-200 to-blue-200 rounded-2xl shadow p-6">
                        <h1 class="text-4xl font-bold text-gray-900"> <?php echo $row -> title ?></h1>

                    </div>

                    <!-- About Section -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-indigo-400">
                        <h2 class="text-2xl font-bold text-indigo-700 mb-4">About this Course</h2>
                        <p class="text-gray-800 text-base leading-relaxed">
                            <?php echo $row -> des ?>
                        </p>
                    </div>

                    <!-- Curriculum -->
                    <div class="flex gap-6 flex-col md:flex-row">

                        <!-- Left Panel: Curriculum -->
                        <div class="w-full md:w-1/3 bg-white rounded-2xl shadow p-6">
                            <h2 class="text-2xl font-bold text-purple-700 mb-6">Course Content</h2>



                            <!-- Section 1 -->
                            <?php foreach($rows as $rowS): 

                            $sqlB = "SELECT COUNT(*) AS lesson  FROM lesson WHERE sectionId = :sectionId";
                            $stmtB = $pdo->prepare($sqlB);    
                            $stmtB->execute(['sectionId' => $rowS -> id]);
                            $total = $stmtB->fetchColumn();
                                
                                
                            ?>
                            <div class="mb-4 border rounded-xl overflow-hidden shadow">
                                <button
                                    class="accordion-toggle w-full flex justify-between items-center px-4 py-3 font-bold text-lg">
                                    <?php echo $rowS -> title ?>
                                    <span class="text-sm text-yellow-200"><?php echo $total ?> Lessons</span>
                                    <i data-feather="chevron-down"></i>
                                </button>
                                <div
                                    class="accordion-content bg-gradient-to-r from-white to-purple-50 px-4 py-3 space-y-3">

                                    <?php
                  $sqlL = "SELECT * FROM lesson WHERE sectionId = :sectionId";       
                  $stmtL = $pdo->prepare($sqlL);
                  $stmtL->execute(['sectionId' => $rowS -> id]);
                  $rowsL = $stmtL->fetchAll();

                ?>

                                    <!-- Video Lesson -->
                                    <?php foreach($rowsL as $rowL): ?>
                                    <div class="flex items-center justify-between cursor-pointer lesson-item rounded-lg p-2 shadow-sm"
                                        data-id="<?php echo $rowL->id ?>" data-course="<?php echo $row->id ?>"
                                        data-type="<?php echo $rowL->contentType ?>"
                                        data-src="<?php echo $rowL->contentUrl ?>">
                                        <span class="flex items-center text-gray-800 font-medium">
                                            <i data-feather="play-circle" class="w-5 h-5 mr-2 text-indigo-500"></i>
                                            <?php echo $rowL->title ?>
                                        </span>
                                        <span class="text-sm text-gray-600"><?php echo $rowL->duration ?></span>
                                    </div>

                                    <?php endforeach; ?>



                                    <!-- PDF Lesson -->
                                    <!-- <div class="flex items-center justify-between cursor-pointer lesson-item rounded-lg p-2 shadow-sm"
                    data-type="pdf" data-src="sample.pdf">
                    <span class="flex items-center text-gray-800 font-medium">
                      <i data-feather="file-text" class="w-5 h-5 mr-2 text-red-500"></i>
                      3. JavaScript Basics (PDF)
                    </span>
                    <span class="text-sm text-gray-600">12 pages</span>
                  </div> -->
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Right Panel: Lesson Viewer -->
                        <div class="flex-1 bg-white rounded-2xl shadow-lg p-6 border-l-4 border-pink-400">
                            <h2 class="text-2xl font-bold text-blue-700 mb-4"> Lesson Viewer</h2>
                            <div id="lesson-viewer"
                                class="aspect-video bg-gradient-to-r from-blue-50 to-indigo-50 flex items-center justify-center rounded-lg">
                                <span class="text-gray-600 font-medium"> Select a lesson to start</span>
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


    // Accordion
    document.querySelectorAll('.accordion-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            content.classList.toggle('active');
            const icon = button.querySelector('i');
            icon.classList.toggle('rotate-180');
        });
    });

    // Lesson Click Handler
    document.querySelectorAll(".lesson-item").forEach(item => {
        item.addEventListener("click", function() {
            const type = this.getAttribute("data-type");
            let src = this.getAttribute("data-src");
            const lessonId = this.getAttribute("data-id");
            const courseId = this.getAttribute("data-course");
            const viewer = document.getElementById("lesson-viewer");

            // Update lesson viewer
            if (type === "video") {
                if (src.includes("youtube.com/watch?v=")) {
                    const videoId = src.split("v=")[1].split("&")[0];
                    src = `https://www.youtube.com/embed/${videoId}`;
                }
                viewer.innerHTML =
                    `<iframe class="w-full h-full rounded-lg" src="${src}" frameborder="0" allowfullscreen></iframe>`;
            } else if (type === "pdf") {
                viewer.innerHTML =
                    `<iframe class="w-full h-full rounded-lg" src="${src}" frameborder="0"></iframe>`;
            }

            // Send AJAX request to track lesson progress
            fetch("track-progress.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `lessonId=${lessonId}&courseId=${courseId}&status=started`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        console.log("Lesson progress saved ");
                    } else {
                        console.error("Error:", data.message);
                    }
                })
                .catch(err => console.error("AJAX Error:", err));
        });
    });
    </script>
</body>

</html>