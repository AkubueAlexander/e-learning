<?php 
    session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once '../inc/database.php';

      // Fetch Courses
    $sql = 'SELECT * FROM section'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    if (isset($_POST['submit'])) {
        $sectionId = $_POST['sectionId'];
        $title = $_POST['title'];
        $position = $_POST['position'];
        $contentUrl = $_POST['contentUrl'];
        $contentType = $_POST['contentType'];
        $duration = $_POST['duration'];

        $sqlCreate = "INSERT INTO lesson (sectionId, title, position, contentUrl, contentType, duration) 
                      VALUES (:sectionId, :title, :position, :contentUrl, :contentType, :duration)";
       $stmtCreate = $pdo->prepare($sqlCreate);
       $stmtCreate->execute([
           ':sectionId' => $sectionId,
           ':title' => $title,
           ':position' => $position,
           ':contentUrl' => $contentUrl,
           ':contentType' => $contentType,
           ':duration' => $duration
       ]);
       header('Location: lesson?created');               
    }


    



    

    



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
                                <i data-feather="index" class="sidebar-icon"></i>
                                <span class="text-lg">Dashboard</span>
                            </a>
                            <a href="course" class="flex items-center sidebar-item">
                                <i data-feather="book-open" class="sidebar-icon"></i>
                                <span class="text-lg">Courses</span>
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

                            <a href="user" class="flex items-center sidebar-item">
                                <i data-feather="users" class="sidebar-icon"></i>
                                <span class="text-lg">Users</span>
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

                                <p class="text-sm text-gray-600">Admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-auto p-6 readable-font">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-6 md:col-span-2">
                            <label for="sectionId" class="block text-gray-800 text-sm font-semibold mb-2">
                                Select Section
                            </label>

                            <div class="relative">
                                <select name="sectionId" id="sectionId" required class="w-full appearance-none px-4 py-3 bg-white border border-gray-300 rounded-xl shadow-sm 
                                    text-gray-700 text-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 focus:outline-none 
                                    transition duration-200 ease-in-out cursor-pointer">
                                    <option value="" disabled selected class="text-gray-400">-- Select an Event --
                                    </option>
                                    <?php foreach ($rows as $row): ?>
                                    <option value="<?php echo $row->id; ?>"
                                        <?php echo isset($_POST['sectionId']) && $_POST['sectionId'] == $row->id ? 'selected' : ''; ?>>
                                        <?php echo $row->title; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Title</label>
                            <input type="text" placeholder="Title" name="title" required
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Position</label>
                            <input type="text" placeholder="e.g 1" name="position" required
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Content Url</label>
                            <input type="text" placeholder="content url" name="contentUrl" required
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Content Type</label>
                            <input type="text" placeholder="e.g video" name="contentType" required
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm mb-1">Duration</label>
                            <input type="text" placeholder="e.g 01:24:19" name="duration" required
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" />
                        </div>


                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" name="submit"
                            class="mt-6 px-6 py-2 rounded-2xl bg-blue-600 text-white shadow hover:bg-blue-700 transition">
                            Create
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Add Select2 CSS -->


    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
    feather.replace();
    AOS.init();

    $(document).ready(function() {
        $('#sectionId').select2({
            placeholder: "Type or select a Section",
            allowClear: true,
            width: '100%' // ensures it takes full width of your container
        });
    });

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