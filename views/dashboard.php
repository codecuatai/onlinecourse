<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>OnlineCourse — Admin Dashboard (Demo)</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Simple, clean dashboard styling */
        :root {
            --bg: #f4f7fb;
            --card: #fff;
            --muted: #6b7280;
            --accent: #2563eb
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            margin: 0;
            background: var(--bg);
            color: #0f172a
        }

        .app {
            display: flex;
            min-height: 100vh
        }

        /* sidebar */
        .sidebar {
            width: 260px;
            background: #0f172a;
            color: #fff;
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
            gap: 18px
        }

        .brand {
            font-weight: 700;
            font-size: 20px
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .nav a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 10px;
            border-radius: 8px
        }

        .nav a.active,
        .nav a:hover {
            background: rgba(255, 255, 255, 0.06)
        }

        .content {
            flex: 1;
            padding: 24px
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px
        }

        .search {
            background: var(--card);
            padding: 8px 12px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 280px
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 18px
        }

        .card {
            background: var(--card);
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(2, 6, 23, 0.06);
        }

        .card h3 {
            margin: 0;
            font-size: 13px;
            color: var(--muted)
        }

        .card p {
            margin: 6px 0 0;
            font-weight: 700;
            font-size: 20px
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px
        }

        .panel {
            background: var(--card);
            padding: 14px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eef2f6;
            font-size: 14px
        }

        th {
            font-size: 13px;
            color: var(--muted)
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            background: var(--accent);
            color: #fff;
            text-decoration: none;
            border: none;
            cursor: pointer
        }

        .btn.ghost {
            background: transparent;
            color: var(--accent);
            border: 1px solid rgba(37, 99, 235, 0.14)
        }

        .small {
            font-size: 12px;
            padding: 6px 8px
        }

        .role-toggle {
            display: flex;
            gap: 8px
        }

        .stat-progress {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .progress {
            height: 8px;
            background: #eef2f6;
            border-radius: 8px;
            overflow: hidden;
            width: 100%
        }

        .progress>i {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, #34d399, #60a5fa);
        }

        /* responsive */
        @media (max-width:1000px) {
            .cards {
                grid-template-columns: repeat(2, 1fr)
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width:640px) {
            .sidebar {
                display: none
            }

            .cards {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">OnlineCourse</div>
            <div class="muted">Dashboard quản trị — Demo</div>
            <nav class="nav">
                <a href="#" class="active">Tổng quan</a>
                <a href="#">Khóa học</a>
                <a href="#">Học viên</a>
                <a href="#">Báo cáo</a>
                <a href="#">Cài đặt</a>
            </nav>
            <div style="margin-top:auto;font-size:13px;color:#94a3b8">Nhóm: 4 người • Github workflow • Figma</div>
        </aside>

        <main class="content">
            <div class="topbar">
                <div style="display:flex;gap:12px;align-items:center">
                    <div class="search">
                        <svg height="16" width="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-4.35-4.35" stroke="#9aa7c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <circle cx="11" cy="11" r="6" stroke="#9aa7c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                        </svg>
                        <input id="q" placeholder="Tìm khóa học, học viên..." style="border:0;outline:0;background:transparent;width:100%" />
                    </div>
                    <div class="role-toggle">
                        <button class="btn small" onclick="switchRole('admin')">Giảng viên/Quản trị</button>
                        <button class="btn ghost small" onclick="switchRole('student')">Học viên</button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px">
                    <div style="text-align:right">
                        <div style="font-size:13px">Xin chào, <strong id="currentUser">Admin Demo</strong></div>
                        <div style="font-size:12px;color:var(--muted)" id="currentRole">Vai trò: Giảng viên</div>
                    </div>
                    <button class="btn small" onclick="openCreateCourse()">Tạo khóa học</button>
                </div>
            </div>

            <section class="cards" id="cards">
                <!-- cards injected by JS -->
            </section>

            <section class="grid-2" style="margin-top:18px">
                <div class="panel">
                    <h3 style="margin:0 0 12px">Khóa học gần đây</h3>
                    <table id="coursesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tiêu đề</th>
                                <th>Giảng viên</th>
                                <th>Học viên</th>
                                <th>Tiến độ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="panel">
                    <h3 style="margin:0 0 12px">Thống kê tiến độ</h3>
                    <canvas id="progressChart" height="240"></canvas>
                    <div style="margin-top:12px"><button class="btn ghost small" onclick="downloadReport()">Tải báo cáo (CSV)</button></div>
                </div>
            </section>

            <section style="margin-top:18px" class="panel">
                <h3>Danh sách học viên</h3>
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Đăng ký</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>

        </main>
    </div>

    <!-- Modal (simple) -->
    <div id="modal" style="position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:rgba(2,6,23,0.5)">
        <div style="width:720px;max-width:95%;background:var(--card);border-radius:12px;padding:18px">
            <h3 id="modalTitle">Tạo khóa học</h3>
            <div style="display:grid;grid-template-columns:1fr 160px;gap:12px">
                <div>
                    <label>Tiêu đề</label>
                    <input id="c_title" style="width:100%;padding:8px;margin:6px 0;border:1px solid #e6eef7;border-radius:8px" />
                    <label>Mô tả</label>
                    <textarea id="c_desc" rows="6" style="width:100%;padding:8px;margin:6px 0;border:1px solid #e6eef7;border-radius:8px"></textarea>
                    <label>Giá (USD)</label>
                    <input id="c_price" type="number" style="width:100%;padding:8px;margin:6px 0;border:1px solid #e6eef7;border-radius:8px" />
                </div>
                <div>
                    <label>Hình ảnh (URL)</label>
                    <input id="c_image" style="width:100%;padding:8px;margin:6px 0;border:1px solid #e6eef7;border-radius:8px" />
                    <label>Level</label>
                    <select id="c_level" style="width:100%;padding:8px;margin:6px 0;border:1px solid #e6eef7;border-radius:8px">
                        <option>Beginner</option>
                        <option>Intermediate</option>
                        <option>Advanced</option>
                    </select>
                    <div style="margin-top:18px;display:flex;gap:8px;justify-content:flex-end">
                        <button class="btn ghost" onclick="closeModal()">Hủy</button>
                        <button class="btn" onclick="saveCourse()">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ---------- Mock data (replace by API calls in real app) ----------
        const users = [{
                id: 1,
                username: 'instructor1',
                email: 'giangvien@example.com',
                fullname: 'Nguyen Van A',
                role: 1,
                created_at: '2025-01-10'
            },
            {
                id: 2,
                username: 'student1',
                email: 'sv1@example.com',
                fullname: 'Tran Thi B',
                role: 0,
                created_at: '2025-02-01'
            },
            {
                id: 3,
                username: 'student2',
                email: 'sv2@example.com',
                fullname: 'Le Van C',
                role: 0,
                created_at: '2025-02-15'
            },
            {
                id: 4,
                username: 'admin',
                email: 'admin@example.com',
                fullname: 'Admin Demo',
                role: 2,
                created_at: '2024-12-28'
            },
        ];

        let courses = [{
                id: 1,
                title: 'React cơ bản',
                description: 'Học React từ cơ bản đến nâng cao',
                instructor_id: 1,
                category_id: 1,
                price: 49.99,
                duration_weeks: 6,
                level: 'Beginner',
                image: 'https://picsum.photos/seed/react/300/160',
                created_at: '2025-03-01',
                updated_at: '2025-03-05'
            },
            {
                id: 2,
                title: 'SQL & MySQL',
                description: 'Thiết kế CSDL và truy vấn',
                instructor_id: 1,
                category_id: 2,
                price: 29.99,
                duration_weeks: 4,
                level: 'Intermediate',
                image: 'https://picsum.photos/seed/mysql/300/160',
                created_at: '2025-01-20',
                updated_at: '2025-02-02'
            },
        ];

        const enrollments = [{
                id: 1,
                course_id: 1,
                student_id: 2,
                enrolled_date: '2025-04-01',
                status: 'active',
                progress: 35
            },
            {
                id: 2,
                course_id: 1,
                student_id: 3,
                enrolled_date: '2025-04-02',
                status: 'active',
                progress: 60
            },
            {
                id: 3,
                course_id: 2,
                student_id: 2,
                enrolled_date: '2025-03-10',
                status: 'completed',
                progress: 100
            },
        ];

        const lessons = [{
                id: 1,
                course_id: 1,
                title: 'Intro',
                content: 'Giới thiệu React',
                video_url: '',
                order: 1,
                created_at: '2025-03-01'
            },
            {
                id: 2,
                course_id: 1,
                title: 'JSX & Components',
                content: '...',
                video_url: '',
                order: 2,
                created_at: '2025-03-02'
            }
        ];

        const materials = [{
            id: 1,
            lesson_id: 1,
            filename: 'slides.pdf',
            file_path: '/uploads/slides.pdf',
            file_type: 'pdf',
            uploaded_at: '2025-03-01'
        }];

        // current user simulation
        let currentRole = 'admin'; // or 'student'
        let currentUser = users[3];

        // ---------- Helpers ----------
        function $(s) {
            return document.querySelector(s)
        }

        function renderCards() {
            const totalCourses = courses.length;
            const totalStudents = users.filter(u => u.role === 0).length;
            const totalInstructors = users.filter(u => u.role === 1).length;
            const activeEnrollments = enrollments.filter(e => e.status === 'active').length;

            const cardsEl = $('#cards');
            cardsEl.innerHTML = `
        <div class="card"><h3>Tổng số khóa học</h3><p>${totalCourses}</p></div>
        <div class="card"><h3>Học viên</h3><p>${totalStudents}</p></div>
        <div class="card"><h3>Giảng viên</h3><p>${totalInstructors}</p></div>
        <div class="card"><h3>Đăng ký đang hoạt động</h3><p>${activeEnrollments}</p></div>
      `;
        }

        function renderCoursesTable() {
            const tbody = $('#coursesTable tbody');
            tbody.innerHTML = '';
            courses.forEach((c, i) => {
                const instructor = users.find(u => u.id === c.instructor_id) || {
                    fullname: '---'
                };
                const studentsCount = enrollments.filter(e => e.course_id === c.id).length;
                const avgProgress = Math.round(enrollments.filter(e => e.course_id === c.id).reduce((s, e) => s + e.progress, 0) / Math.max(1, studentsCount));
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${c.id}</td><td>${c.title}</td><td>${instructor.fullname}</td><td>${studentsCount}</td><td><div class="stat-progress"><div style="width:120px" class="progress"><i style="width:${avgProgress}%"></i></div><span style="font-size:12px;color:var(--muted)">${avgProgress}%</span></div></td><td><button class="btn small" onclick="editCourse(${c.id})">Sửa</button> <button class="btn ghost small" onclick="deleteCourse(${c.id})">Xoá</button></td>`;
                tbody.appendChild(tr);
            })
        }

        function renderStudentsTable() {
            const tbody = $('#studentsTable tbody');
            tbody.innerHTML = '';
            users.filter(u => u.role === 0).forEach((s, i) => {
                const regCount = enrollments.filter(e => e.student_id === s.id).length;
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${i+1}</td><td>${s.fullname}</td><td>${s.email}</td><td>Học viên</td><td>${regCount}</td>`;
                tbody.appendChild(tr);
            })
        }

        // ---------- Chart ----------
        let progressChart;

        function drawChart() {
            const labels = courses.map(c => c.title);
            const data = courses.map(c => {
                const en = enrollments.filter(e => e.course_id === c.id);
                if (en.length === 0) return 0;
                return Math.round(en.reduce((s, e) => s + e.progress, 0) / en.length);
            });
            const ctx = document.getElementById('progressChart').getContext('2d');
            if (progressChart) progressChart.destroy();
            progressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Tiến độ trung bình (%)',
                        data
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            })
        }

        // ---------- Course CRUD (front-end) ----------
        let editingId = null;

        function openCreateCourse() {
            editingId = null;
            $('#modalTitle').innerText = 'Tạo khóa học';
            $('#c_title').value = '';
            $('#c_desc').value = '';
            $('#c_price').value = '0';
            $('#c_image').value = '';
            $('#c_level').value = 'Beginner';
            $('#modal').style.display = 'flex'
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none'
        }

        function saveCourse() {
            const title = $('#c_title').value.trim();
            if (!title) {
                alert('Tiêu đề bắt buộc');
                return
            }
            const desc = $('#c_desc').value;
            const price = parseFloat($('#c_price').value) || 0;
            const image = $('#c_image').value;
            const level = $('#c_level').value;
            if (editingId) {
                const idx = courses.findIndex(c => c.id === editingId);
                if (idx > -1) {
                    courses[idx].title = title;
                    courses[idx].description = desc;
                    courses[idx].price = price;
                    courses[idx].image = image;
                    courses[idx].level = level;
                    courses[idx].updated_at = new Date().toISOString()
                }
            } else {
                const newId = courses.reduce((m, c) => Math.max(m, c.id), 0) + 1;
                courses.push({
                    id: newId,
                    title,
                    description: desc,
                    instructor_id: 1,
                    category_id: 1,
                    price,
                    duration_weeks: 4,
                    level,
                    image,
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString()
                })
            }
            closeModal();
            refreshAll();
        }

        function editCourse(id) {
            const c = courses.find(x => x.id === id);
            if (!c) return;
            editingId = id;
            $('#modalTitle').innerText = 'Sửa khóa học';
            $('#c_title').value = c.title;
            $('#c_desc').value = c.description;
            $('#c_price').value = c.price;
            $('#c_image').value = c.image;
            $('#c_level').value = c.level;
            $('#modal').style.display = 'flex';
        }

        function deleteCourse(id) {
            if (!confirm('Bạn có chắc muốn xoá khóa học này?')) return;
            courses = courses.filter(c => c.id !== id); // also remove enrollments
            for (let i = enrollments.length - 1; i >= 0; i--) {
                if (enrollments[i].course_id === id) enrollments.splice(i, 1)
            }
            refreshAll();
        }

        function switchRole(r) {
            currentRole = r;
            $('#currentRole').innerText = 'Vai trò: ' + (r === 'admin' ? 'Giảng viên/Quản trị' : 'Học viên');
            $('#currentUser').innerText = r === 'admin' ? 'Admin Demo' : 'Sinh viên Demo';
        }

        function downloadReport() {
            // CSV of enrollments
            let csv = 'course_id,course_title,student_id,student_name,enrolled_date,status,progress\n';
            enrollments.forEach(e => {
                const c = courses.find(cc => cc.id === e.course_id) || {};
                const s = users.find(u => u.id === e.student_id) || {};
                csv += `${e.course_id},"${c.title||''}",${e.student_id},"${s.fullname||''}",${e.enrolled_date},${e.status},${e.progress}\n`;
            });
            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'enrollments_report.csv';
            a.click();
            URL.revokeObjectURL(url);
        }

        function refreshAll() {
            renderCards();
            renderCoursesTable();
            renderStudentsTable();
            drawChart();
        }

        // initialize
        refreshAll();

        // search filter (simple)
        $('#q').addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase();
            const tbody = $('#coursesTable tbody');
            Array.from(tbody.children).forEach(tr => {
                const title = tr.children[1].innerText.toLowerCase();
                tr.style.display = title.includes(q) ? '' : 'none';
            })
        });

        // small UX: close modal on click outside
        document.getElementById('modal').addEventListener('click', (ev) => {
            if (ev.target.id === 'modal') closeModal();
        })
    </script>
</body>

</html>