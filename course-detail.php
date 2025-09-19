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
    <!-- load OpenDyslexic (fallbacks included) -->
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
        outline: 3px solid rgba(79,70,229,0.25);
    }

    /* Page layout important bits (kept your styles) */
    body {
        font-family: 'Inter', sans-serif;
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
        transform: scale(1.01);
        transition: 0.12s;
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

    /* ensure lesson-item content is not crowded with the new button */
    .lesson-item {
        gap: 0.5rem;
    }
    .lesson-meta {
        display:flex;
        align-items:center;
        gap:0.5rem;
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
                    <div class="bg-gradient-to-r from-pink-200 via-purple-200 to-blue-200 rounded-2xl shadow p-6 flex items-start justify-between">
                        <div>
                            <h1 id="course-title" class="text-4xl font-bold text-gray-900"> <?php echo $row -> title ?></h1>
                            <p id="course-sub" class="text-gray-700 mt-2"><?php echo htmlspecialchars($row->des) ?></p>
                        </div>

                        <!-- Accessibility controls (page-level) -->
                        <div class="flex flex-col items-end space-y-2">
                            <button id="toggle-dyslexia" class="tts-button" aria-pressed="false">A11y: Dyslexia Mode</button>
                            <button id="read-page" class="tts-button">🔊 Read Course Page</button>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-indigo-400">
                        <h2 class="text-2xl font-bold text-indigo-700 mb-4">About this Course</h2>
                        <p id="about-text" class="text-gray-800 text-base leading-relaxed">
                            <?php echo $row -> des ?>
                        </p>
                    </div>

                    <!-- Curriculum -->
                    <div class="flex gap-6 flex-col md:flex-row">

                        <!-- Left Panel: Curriculum -->
                        <div class="w-full md:w-1/3 bg-white rounded-2xl shadow p-6" id="curriculum">
                            <h2 class="text-2xl font-bold text-purple-700 mb-6">Course Content</h2>

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
                                <div class="accordion-content bg-gradient-to-r from-white to-purple-50 px-4 py-3 space-y-3">

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
                                        <span class="flex items-center text-gray-800 font-medium lesson-title">
                                            <i data-feather="play-circle" class="w-5 h-5 mr-2 text-indigo-500"></i>
                                            <?php echo $rowL->title ?>
                                        </span>

                                        <div class="lesson-meta">
                                            <span class="text-sm text-gray-600 lesson-duration"><?php echo $rowL->duration ?></span>
                                            <!-- per-lesson TTS button (will be visible and wired by JS) -->
                                            <button class="tts-button tts-small lesson-tts" title="Read lesson" aria-label="Read lesson">
                                                🔊
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>

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

    // safe getters
    const safeGet = id => document.getElementById(id);

    // Mobile menu toggle (try/catch to avoid errors)
    try {
        const mobileBtn = safeGet('mobile-menu-button');
        if (mobileBtn) {
            mobileBtn.addEventListener('click', function() {
                document.getElementById('mobile-sidebar').classList.remove('hidden');
            });
        }
        const closeMobile = safeGet('close-mobile-menu');
        if (closeMobile) {
            closeMobile.addEventListener('click', function() {
                document.getElementById('mobile-sidebar').classList.add('hidden');
            });
        }
        const backDrop = safeGet('mobile-sidebar-backdrop');
        if (backDrop) {
            backDrop.addEventListener('click', function() {
                document.getElementById('mobile-sidebar').classList.add('hidden');
            });
        }
    } catch (e) { console.warn(e); }

    // Accordion
    document.querySelectorAll('.accordion-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            content.classList.toggle('active');
            const icon = button.querySelector('i');
            if (icon) icon.classList.toggle('rotate-180');
        });
    });

    // Lesson Click Handler (keeps original viewer + progress tracking)
    document.querySelectorAll(".lesson-item").forEach(item => {
        item.addEventListener("click", function(event) {
            // If the tts button inside was clicked, do not handle lesson navigation here.
            const origin = event.target;
            if (origin.closest('.lesson-tts')) {
                return; // tts handler will handle it
            }

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
            } else {
                // fallback text or unsupported type
                viewer.innerHTML = `<div class="p-6 text-gray-700">This lesson type is not previewable here.</div>`;
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

    // ===== TTS functionality =====
    function speak(text, opts = {}) {
        if (!('speechSynthesis' in window)) {
            alert('Text-to-Speech not supported by this browser.');
            return;
        }
        window.speechSynthesis.cancel();
        const utter = new SpeechSynthesisUtterance(text);
        // Small defaults; can be exposed later
        utter.rate = opts.rate || 1;
        utter.pitch = opts.pitch || 1;
        // choose a voice if provided (optional)
        if (opts.voiceName) {
            const voices = speechSynthesis.getVoices();
            const v = voices.find(x => x.name === opts.voiceName);
            if (v) utter.voice = v;
        }
        speechSynthesis.speak(utter);
    }

    // Compose a readable course page summary (used by Read Course Page)
    function composeCourseText() {
        const title = document.querySelector('#course-title')?.innerText || '';
        const about = document.querySelector('#about-text')?.innerText || '';
        // sections & lessons
        let sections = [];
        document.querySelectorAll('#curriculum > .mb-4').forEach(sectionEl => {
            const secTitle = sectionEl.querySelector('.accordion-toggle')?.innerText || '';
            // gather lesson titles inside this section
            let lessons = [];
            sectionEl.querySelectorAll('.lesson-item').forEach(li => {
                const lt = li.querySelector('.lesson-title')?.innerText || '';
                const dur = li.querySelector('.lesson-duration')?.innerText || '';
                if (lt) lessons.push(lt + (dur ? (', duration ' + dur) : ''));
            });
            if (secTitle) sections.push(secTitle + ': ' + lessons.join('. '));
        });
        return [title, about].concat(sections).join('. \n');
    }

    // Page-level Read
    const readPageBtn = document.getElementById('read-page');
    if (readPageBtn) {
        readPageBtn.addEventListener('click', () => {
            const text = composeCourseText();
            speak(text, {rate: 1});
        });
    }

    // Dyslexia mode toggle
    const dysBtn = document.getElementById('toggle-dyslexia');
    if (dysBtn) {
        dysBtn.addEventListener('click', () => {
            const enabled = document.body.classList.toggle('dyslexia-mode');
            dysBtn.setAttribute('aria-pressed', enabled ? 'true' : 'false');
            // provide polite feedback
            dysBtn.innerText = enabled ? 'A11y: Dyslexia Mode ✓' : 'A11y: Dyslexia Mode';
        });
    }

    // Wire per-lesson TTS buttons (stopPropagation to avoid selecting lesson)
    document.querySelectorAll('.lesson-tts').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation(); // important: avoid triggering lesson play
            const parent = btn.closest('.lesson-item');
            if (!parent) return;
            const title = parent.querySelector('.lesson-title')?.innerText || '';
            const dur = parent.querySelector('.lesson-duration')?.innerText || '';
            const speakText = title + (dur ? (', duration ' + dur) : '');
            speak(speakText, {rate: 1});
        });
    });

    // Ensure voices are loaded (some browsers load voices async)
    if (typeof speechSynthesis !== 'undefined') {
        speechSynthesis.onvoiceschanged = () => {
            // no-op for now, reserved for future voice selection UI
            console.log('voices loaded', speechSynthesis.getVoices().length);
        };
    }
    </script>
</body>
</html>
