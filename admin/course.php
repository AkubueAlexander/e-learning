<?php 
    session_start();
    if (!isset($_SESSION['id'])) {
         header('location: login');
    } 
    
    include_once '../inc/database.php';

      // Fetch Courses
    $sql = 'SELECT * FROM course'; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();


    
if (isset($_POST['edit'])) {

       

        $id = $_POST['id'];               
        $title = $_POST['title'];
        $des = $_POST['des'];
        $bg = $_POST['bg'];    
        $level = $_POST['level'];
        $icon = $_POST['icon'];     
        
    
        $sqlUpdate = "UPDATE course SET title = :title, des = :des, bg = :bg, level = :level, icon = :icon WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':title' => $title,
            ':des' => $des,
            ':bg' => $bg,
            ':level' => $level,
            ':icon' => $icon,
            ':id' => $id
        ]);
        
    
       header("Location: course?updated=true");
        exit;

    
}


    

    



include_once 'inc/head.php'; 
?>

<body class="bg-gray-50">
    <?php
        if (isset($_GET['updated'])) {
            echo "<script>
                Swal.fire({
                    title: 'Course Updated Successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
        ?>
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
                <div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow" x-data="courseTable()" x-init="init()">


                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                        <h1 class="text-xl font-semibold text-gray-800">Donation History</h1>
                        <input type="text" placeholder="Search..."
                            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none"
                            x-model="search" @input="filterRows()" />
                    </div>

                    <div class="overflow-x-auto ">
                        <table class="min-w-max divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100 text-gray-700 font-semibold">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Title</th>
                                    <th class="px-4 py-2 text-left">Description</th>
                                    <th class="px-4 py-2 text-left">Background</th>
                                    <th class="px-4 py-2 text-left">Level</th>
                                    <th class="px-4 py-2 text-left">Icon</th>
                                    <th class="px-4 py-2 text-left">Action</th>



                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="row in paginatedRows()" :key="row.id">
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="px-4 py-2" x-text="row.id"></td>
                                        <td class="px-4 py-2" x-text="row.title"></td>
                                        <td class="px-4 py-2" x-text="row.des"></td>
                                        <td class="px-4 py-2" x-text="row.bg"></td>
                                        <td class="px-4 py-2" x-text="row.level"></td>
                                        <td class="px-4 py-2" x-text="row.icon"></td>

                                        <td class="border border-gray-300 p-2 flex gap-2">
                                            <button @click="showModal(row, false)"
                                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button @click="showModal(row, true)"
                                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button @click="confirmDelete(row.id)"
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        <!-- Modal (drop-in replacement) -->
                        <div x-show="modalOpen" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-transition
                            @keydown.escape.window="modalOpen=false" @click.self="modalOpen=false">
                            <div class="bg-white w-[95%] max-w-2xl rounded-xl shadow-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold"
                                        x-text="isEditing ? 'Edit Course' : 'View Course'">
                                    </h2>
                                    <button @click="modalOpen=false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                                </div>
                                <form action="" method="post">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- ID (always read-only) -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1">ID</label>
                                            <input type="text" x-model="modalData.id"
                                                class="w-full border rounded-lg p-2 bg-gray-100 cursor-not-allowed"
                                                readonly>
                                            <input type="hidden" name="id" x-model="modalData.id">
                                        </div>



                                        <div>
                                            <label class="block text-sm font-medium mb-1">Title</label>
                                            <input type="text" x-model="modalData.title" name="title"
                                                class="w-full border rounded-lg p-2" :readonly="!isEditing"
                                                :class="!isEditing ? 'bg-gray-50' : ''">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <label class="block text-sm font-medium mb-1">Description</label>
                                            <textarea type="text" x-model="modalData.des"
                                                class="md:col-span-2 w-full border rounded-lg p-2"
                                                :readonly="!isEditing" :class="!isEditing ? 'bg-gray-50' : ''"
                                                name="des" placeholder="message"></textarea>
                                        </div>


                                        <div>
                                            <label class="block text-sm font-medium mb-1">Background</label>
                                            <input type="text" x-model="modalData.bg" name="bg"
                                                class="w-full border rounded-lg p-2" :readonly="!isEditing"
                                                :class="!isEditing ? 'bg-gray-50' : ''">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Level</label>
                                            <input type="text" x-model="modalData.level" name="level"
                                                class="w-full border rounded-lg p-2" :readonly="!isEditing"
                                                :class="!isEditing ? 'bg-gray-50' : ''">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Level</label>
                                            <input type="text" x-model="modalData.level" name="level"
                                                class="w-full border rounded-lg p-2" :readonly="!isEditing"
                                                :class="!isEditing ? 'bg-gray-50' : ''">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Icon</label>
                                            <input type="text" x-model="modalData.icon" name="icon"
                                                class="w-full border rounded-lg p-2" :readonly="!isEditing"
                                                :class="!isEditing ? 'bg-gray-50' : ''">
                                        </div>



                                    </div>

                                    <div class="flex justify-end gap-2 mt-6">
                                        <button @click="modalOpen=false"
                                            class="px-4 py-2 rounded-lg border">Close</button>
                                        <button type="submit" x-show="isEditing" @click="saveEdit()" name="edit"
                                            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- Pagination -->
                    <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-4 md:space-y-0">
                        <p class="text-sm text-gray-600"
                            x-text="`Showing ${startIndex + 1} to ${Math.min(endIndex(), filtered.length)} of ${filtered.length} messages`">
                        </p>
                        <div class="flex items-center space-x-1">
                            <button class="px-3 py-1 border rounded hover:bg-gray-200" @click="prevPage"
                                :disabled="currentPage === 1">Prev</button>
                            <template x-for="page in totalPages()" :key="page">
                                <button class="px-3 py-1 border rounded"
                                    :class="page === currentPage ? 'bg-blue-600 text-white' : 'hover:bg-gray-200'"
                                    @click="currentPage = page" x-text="page"></button>
                            </template>
                            <button class="px-3 py-1 border rounded hover:bg-gray-200" @click="nextPage"
                                :disabled="currentPage === totalPages()">Next</button>
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

    const courseFromPHP = <?php echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function courseTable() {
        return {
            search: '',
            currentPage: 1,
            perPage: 5,
            startIndex: 0,
            rows: [],
            filtered: [],
            // modal state
            modalOpen: false,
            isEditing: false,
            modalData: {},


            // helpers
            toISODate(dateStr) {
                // robust ISO yyyy-mm-dd for input[type=date]
                const d = dateStr ? new Date(dateStr) : new Date();
                // avoid timezone offset issues
                const tz = d.getTimezoneOffset() * 60000;
                return new Date(d.getTime() - tz).toISOString().slice(0, 10);
            },
            formatDisplayDate(iso) {
                if (!iso) return '';
                const [y, m, d] = iso.split('-');
                const dt = new Date(`${y}-${m}-${d}T00:00:00`);
                return dt.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            },

            init() {
                this.rows = courseFromPHP.map(course => {
                    return {
                        id: course.id,
                        title: course.title,
                        des: course.des,
                        bg: course.bg,
                        level: course.level,
                        icon: course.icon
                    };
                });
                this.filtered = this.rows;
            },

            filterRows() {
                const keyword = this.search.toLowerCase();
                this.filtered = this.rows.filter(row =>
                    Object.values(row).some(value => String(value).toLowerCase().includes(keyword))
                );
                this.currentPage = 1;
            },
            paginatedRows() {
                this.startIndex = (this.currentPage - 1) * this.perPage;
                return this.filtered.slice(this.startIndex, this.endIndex());
            },
            endIndex() {
                return this.startIndex + this.perPage;
            },
            totalPages() {
                return Math.ceil(this.filtered.length / this.perPage) || 1;
            },
            nextPage() {
                if (this.currentPage < this.totalPages()) this.currentPage++;
            },
            prevPage() {
                if (this.currentPage > 1) this.currentPage--;
            },

            // modal actions
            showModal(row, editMode = false) {
                this.modalData = {
                    ...row
                }; // clone row for editing
                this.isEditing = !!editMode;
                this.modalOpen = true;
            },
            saveEdit() {
                // apply modal changes back to table row
                const i = this.rows.findIndex(r => r.id === this.modalData.id);
                if (i !== -1) {

                    this.rows[i] = {
                        ...this.rows[i],
                        title: this.modalData.fullName,
                        des: this.modalData.title,
                        bg: this.modalData.bg,
                        level: this.modalData.level,
                        icon: this.modalData.icon,

                    };
                    // refresh filtered so table reflects changes immediately
                    this.filterRows();
                }
                this.modalOpen = false;

                // TODO: send AJAX to your PHP endpoint to persist changes server-side
                // fetch('update-order.php', { method:'POST', body: JSON.stringify(this.rows[i]) })
            },

            confirmDelete(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('delete-course.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'id=' + encodeURIComponent(id)
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    this.rows = this.rows.filter(r => r.id !== id); // remove from table
                                    this.filterRows();
                                    Swal.fire("Deleted!", "The order has been deleted.", "success");
                                } else {
                                    Swal.fire("Error", data.message || "Could not delete order.", "error");
                                }
                            })
                            .catch(() => {
                                Swal.fire("Error", "Could not contact server.", "error");
                            });
                    }
                });
            }



        }
    }
    </script>
</body>

</html>