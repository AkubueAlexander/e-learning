<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login');
    exit;
}

include_once 'inc/database.php';

$userId = $_SESSION['id'];

// Fetch only badges for this logged-in user, joined with badge metadata
$sql = "SELECT b.title AS badgeTitle, b.des, b.iconUrl, sb.courseId, b.createdAt, c.title AS courseTitle
        FROM studentbadge sb
        INNER JOIN badge b ON sb.badgeId = b.id
        INNER JOIN course c ON sb.courseId = c.id
        WHERE sb.userId = :userId";

$stmt = $pdo->prepare($sql);
$stmt->execute(['userId' => $userId]);
$rows = $stmt->fetchAll();

include_once 'inc/head.php';
?>

<body class="bg-gray-50 h-screen overflow-hidden">
    <style>
    :root {
        --primary: #4F46E5;
        --secondary: #10B981;
    }

    html,
    body {
        height: 100%;
        overflow: hidden;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .badge-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .badge-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
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

            <!-- Content -->
            <div class="flex-1 overflow-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">My Badges</h1>
                    </div>

                    <?php if (count($rows) > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <?php foreach ($rows as $row): ?>
                        <div class="badge-card bg-white rounded-2xl shadow p-4 flex flex-col items-center text-center">
                            <img src="<?= htmlspecialchars($row -> iconUrl) ?>" alt="Badge Icon" class="w-16 h-16 mb-4">
                            <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($row -> badgeTitle) ?>
                            </h2>
                            <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($row -> des) ?></p>
                            <p class="text-sm text-gray-500 italic mb-2">Course:
                                <?= htmlspecialchars($row -> courseTitle) ?></p>
                            <span class="text-xs text-gray-400">Awarded:
                                <?= date("M d, Y", strtotime($row -> createdAt)) ?></span>
                        </div>

                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-16">
                        <img src="assets/images/no-badges.svg" alt="No Badges" class="w-40 h-40 mx-auto mb-6">
                        <p class="text-gray-600">You haven’t earned any badges yet. Keep learning to unlock
                            achievements! 🎉</p>
                    </div>
                    <?php endif; ?>
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