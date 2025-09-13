<?php
$userId = $_SESSION['id'];

$sqlUser = 'SELECT * FROM user WHERE id = :id LIMIT 1';
$stmtUser = $pdo->prepare($sqlUser);
$stmtUser->execute(['id' => $userId]);
$rowUser = $stmtUser->fetch();
?>

<!-- Sidebar -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-72 sidebar">
        <!-- Brand -->
        <div class="flex items-center justify-center h-20 px-6 bg-indigo-600">
            <div class="flex items-center">
                <i data-feather="book" class="text-white mr-3 sidebar-icon"></i>
                <span class="text-white font-bold text-xl letter-spacing-wide">LearnHub</span>
            </div>
        </div>

        <!-- Menu -->
        <div class="flex flex-col flex-grow px-4 py-6 overflow-y-auto">
            <nav class="flex-1 space-y-1">
                <a href="index" class="flex items-center sidebar-item active">
                    <i data-feather="home" class="sidebar-icon"></i>
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
               
            </nav>

            <!-- Logout -->
            <div class="mt-auto px-2">
                <div class="p-4 mt-4 bg-indigo-50 rounded-xl">
                    <div class="flex items-center">
                        <button onclick="location.href='logout'"
                                class="ml-auto text-indigo-600 hover:text-indigo-800">
                            <i data-feather="log-out"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

