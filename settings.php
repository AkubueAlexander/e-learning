<?php
    session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once 'inc/database.php';

   


    if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $fullName = trim($_POST['fullName']);    
    $pass = trim($_POST['pass']);
    $passMd5 = md5($pass);

    $stmt = $pdo->prepare("UPDATE user SET fullName = :fullName,email = :email, pass = :pass WHERE id = :id");
    $stmt->execute(['id' => $userId, 'fullName' => $fullName, 'email' => $email,'pass' => $passMd5]);
    header("Location: settings?updated=1");

    }


include_once 'inc/head.php'; 


?>



<body class="bg-gray-50">
     <?php
        if (isset($_GET['updated'])) {
            echo "<script>
                Swal.fire({
                    title: 'Account Updated Successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
        ?>
        <link href="https://fonts.cdnfonts.com/css/open-dyslexic" rel="stylesheet">
    <style>
        .progress-ring__circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
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
                <div class="mb-6 flex gap-3">
                        <button id="toggle-dyslexia" class="tts-button">A11y: Dyslexia Mode</button>
                        <button id="read-page" class="tts-button">🔊 Read Page</button>
                    </div>

             <form class="space-y-4" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                      <div class="md:col-span-2">
                           <label class="block text-gray-700 text-sm mb-1">FullName</label>
                            <input type="text" placeholder="Enter FullName" name="fullName"
                                value="<?php echo $rowUser -> fullName ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>
                       
                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Email</label>
                            <input type="email" placeholder="Enter email" name="email"
                                value="<?php echo $rowUser -> email ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Password</label>
                            <input type="password" placeholder="Enter Password" name="pass" required
                                value=""  autocomplete="new-password"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>
                        
                        
                    </div>
                    <button type="submit" name="submit"
                        class="mt-4 w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition">Save
                        Changes</button>
                </form>

                

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
