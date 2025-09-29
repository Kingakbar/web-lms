 function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                alert('Logout berhasil! Anda akan diarahkan ke halaman login.');

            }
        }


        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stats-card, .course-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = (index * 0.1) + 's';
                card.classList.add('fade-in-up');
            });
        });

        function confirmLogout(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Sesi Anda akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }




        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('lessonForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetBtn');
            const addLessonBtn = document.getElementById('addLessonBtn');
            const lessonsContainer = document.getElementById('lessons-container');
            let lessonIndex = 1;

            // Add new lesson
            addLessonBtn.addEventListener('click', function() {
                const newLessonHtml = createLessonTemplate(lessonIndex);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newLessonHtml;
                const newLessonElement = tempDiv.firstElementChild;

                // Add animation
                newLessonElement.style.opacity = '0';
                newLessonElement.style.transform = 'translateY(20px)';
                lessonsContainer.appendChild(newLessonElement);

                // Trigger animation
                setTimeout(() => {
                    newLessonElement.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    newLessonElement.style.opacity = '1';
                    newLessonElement.style.transform = 'translateY(0)';
                }, 50);

                updateRemoveButtons();
                lessonIndex++;

                // Scroll to new lesson
                newLessonElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            });

            // Remove lesson functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-lesson')) {
                    const btn = e.target.closest('.btn-remove-lesson');
                    const lessonItem = btn.closest('.lesson-item');

                    // Add remove animation
                    lessonItem.style.transition = 'all 0.5s ease';
                    lessonItem.style.transform = 'translateX(-100%)';
                    lessonItem.style.opacity = '0';

                    setTimeout(() => {
                        lessonItem.remove();
                        updateLessonNumbers();
                        updateRemoveButtons();
                    }, 500);
                }
            });

            // Auto-generate slug and validation for title inputs
            document.addEventListener('input', function(e) {
                if (e.target.name && e.target.name.includes('[title]')) {
                    const title = e.target.value;
                    // You can add slug generation logic here if needed

                    // Visual feedback
                    if (title.trim()) {
                        e.target.classList.remove('input-error');
                        e.target.classList.add('input-success');
                    } else {
                        e.target.classList.remove('input-success');
                    }
                }
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const lessonItems = document.querySelectorAll('.lesson-item');

                lessonItems.forEach((item, index) => {
                    const courseSelect = item.querySelector('select[name*="course_id"]');
                    const titleInput = item.querySelector('input[name*="title"]');

                    if (!courseSelect.value.trim()) {
                        courseSelect.classList.add('input-error');
                        isValid = false;
                    } else {
                        courseSelect.classList.remove('input-error');
                    }

                    if (!titleInput.value.trim()) {
                        titleInput.classList.add('input-error');
                        isValid = false;
                    } else {
                        titleInput.classList.remove('input-error');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    const firstError = form.querySelector('.input-error');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                } else {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Menyimpan...';
                }
            });

            // Reset form
            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    // Keep only the first lesson
                    const allLessons = lessonsContainer.querySelectorAll('.lesson-item');
                    for (let i = 1; i < allLessons.length; i++) {
                        allLessons[i].remove();
                    }

                    // Reset form validation classes
                    document.querySelectorAll('.input-modern').forEach(input => {
                        input.classList.remove('input-error', 'input-success');
                    });

                    lessonIndex = 1;
                    updateRemoveButtons();
                    updateLessonNumbers();
                }, 100);
            });

            // Helper functions
            // === Helper Functions ===

            // Template untuk lesson baru
            function createLessonTemplate(index) {
                return `
        <div class="lesson-item" data-lesson-index="${index}">
            <div class="lesson-header">
                <h5 class="lesson-title">
                    <i class="bi bi-play-circle"></i>
                    Materi #${index + 1}
                </h5>
                <button type="button" class="btn-remove-lesson" data-target="${index}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <!-- Pilih Kursus -->
            <div class="input-group-modern">
                <label for="course_id_${index}" class="input-label">Pilih Kursus</label>
                <div class="input-with-icon">
                    <select name="lessons[${index}][course_id]" id="course_id_${index}" class="input-modern" required>

                        ${getCourseOptions()}
                    </select>
                    <i class="bi bi-book input-icon"></i>
                </div>
            </div>

            <!-- Judul Materi -->
            <div class="input-group-modern">
                <label for="title_${index}" class="input-label">Judul Materi</label>
                <div class="input-with-icon">
                    <input type="text" name="lessons[${index}][title]" id="title_${index}"
                        class="input-modern" placeholder="Masukkan judul materi yang menarik" required autocomplete="off">
                    <i class="bi bi-pencil input-icon"></i>
                </div>
            </div>

            <!-- Konten Materi -->
            <div class="input-group-modern">
                <label for="content_${index}" class="input-label">Konten Materi</label>
                <textarea name="lessons[${index}][content]" id="content_${index}" rows="4"
                    class="input-modern" placeholder="Masukkan deskripsi atau konten materi pembelajaran"></textarea>
            </div>

            <!-- URL Video -->
            <div class="input-group-modern">
                <label for="video_url_${index}" class="input-label">URL Video (Opsional)</label>
                <div class="input-with-icon">
                    <input type="url" name="lessons[${index}][video_url]" id="video_url_${index}"
                        class="input-modern" placeholder="https://youtube.com/watch?v=..." autocomplete="off">
                    <i class="bi bi-camera-video input-icon"></i>
                </div>
            </div>

            <!-- Urutan Materi -->
            <div class="input-group-modern">
                <label for="order_${index}" class="input-label">Urutan Materi</label>
                <div class="input-with-icon">
                    <input type="number" name="lessons[${index}][order]" id="order_${index}" min="1"
                        class="input-modern" placeholder="1" value="${index + 1}" autocomplete="off">
                    <i class="bi bi-sort-numeric-up input-icon"></i>
                </div>
            </div>
        </div>
        `;
            }

            // Ambil opsi kursus dari select pertama
            function getCourseOptions() {
                const firstSelect = document.querySelector('#course_id_0');
                if (!firstSelect) return '';
                return firstSelect.innerHTML;
            }

            // Update nomor materi
            function updateLessonNumbers() {
                const items = document.querySelectorAll('.lesson-item');
                items.forEach((item, i) => {
                    const title = item.querySelector('.lesson-title');
                    if (title) title.innerHTML = `<i class="bi bi-play-circle"></i> Materi #${i + 1}`;
                });
            }

            // Tampilkan tombol hapus hanya kalau ada lebih dari 1 lesson
            function updateRemoveButtons() {
                const items = document.querySelectorAll('.lesson-item');
                items.forEach((item, i) => {
                    const btn = item.querySelector('.btn-remove-lesson');
                    if (btn) {
                        btn.style.display = (items.length > 1) ? 'inline-flex' : 'none';
                    }
                });
            }

            // Inisialisasi awal
            updateRemoveButtons();
            updateLessonNumbers();
        });
