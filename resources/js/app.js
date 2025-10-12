import './bootstrap';

        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Counter animation
        let counterAnimated = false;

        function animateCounter(counter) {
            const target = parseInt(counter.getAttribute('data-count'));
            const increment = target / 50;
            let current = 0;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.innerText = Math.floor(current).toLocaleString();
            }, 40);
        }

        const statsSection = document.querySelector('.stats');
        if (statsSection) {
            const observer = new IntersectionObserver(entries => {
                if (entries[0].isIntersecting && !counterAnimated) {
                    counterAnimated = true;
                    document.querySelectorAll('[data-count]').forEach(counter => animateCounter(counter));
                }
            }, {
                threshold: 0.5
            });
            observer.observe(statsSection);
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        window.scrollTo({
                            top: target.offsetTop - navbarHeight - 20,
                            behavior: 'smooth'
                        });
                        const navbarCollapse = document.querySelector('.navbar-collapse');
                        if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                            if (bsCollapse) bsCollapse.hide();
                        }
                        closeMobileBottomSheet();
                    }
                }
            });
        });

        // Mobile Bottom Sheet Controls
        const mobileCoursesBtn = document.getElementById('mobileCoursesBtn');
        const mobileCoursesSheet = document.getElementById('mobileCoursesSheet');
        const bottomSheetOverlay = document.getElementById('bottomSheetOverlay');

        function openMobileBottomSheet() {
            if (mobileCoursesSheet && bottomSheetOverlay) {
                mobileCoursesSheet.classList.add('show');
                bottomSheetOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileBottomSheet() {
            if (mobileCoursesSheet && bottomSheetOverlay) {
                mobileCoursesSheet.classList.remove('show');
                bottomSheetOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        }

        if (mobileCoursesBtn) {
            mobileCoursesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openMobileBottomSheet();
            });
        }

        if (bottomSheetOverlay) {
            bottomSheetOverlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileBottomSheet();
            });
        }

        // Close bottom sheet on swipe down
        let touchStartY = 0;
        let touchEndY = 0;

        if (mobileCoursesSheet) {
            mobileCoursesSheet.addEventListener('touchstart', function(e) {
                touchStartY = e.touches[0].clientY;
            }, {
                passive: true
            });

            mobileCoursesSheet.addEventListener('touchmove', function(e) {
                touchEndY = e.touches[0].clientY;
            }, {
                passive: true
            });

            mobileCoursesSheet.addEventListener('touchend', function() {
                if (touchEndY > touchStartY + 50) {
                    closeMobileBottomSheet();
                }
            });
        }

        // Close bottom sheet when clicking any course item
        document.querySelectorAll('.bottom-sheet-item').forEach(item => {
            item.addEventListener('click', function() {
                setTimeout(() => {
                    closeMobileBottomSheet();
                }, 300);
            });
        });

        console.log('Technest Academy loaded - Mobile bottom sheet active!');
// Course Filter AJAX - Bug Free Version
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.category-filter');
    const courseContainer = document.getElementById('course-container');

    if (!courseContainer) {
        console.error('Course container not found!');
        return;
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const categorySlug = this.dataset.category;
            const url = this.href;

            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');

            // Show loading
            courseContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-3">Memuat kursus...</p>
                </div>
            `;

            // Fetch courses
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server tidak mengembalikan JSON');
                }

                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Request gagal');
                }

                if (data.courses && data.courses.length > 0) {
                    renderCourses(data.courses);
                } else {
                    renderEmpty();
                }

                // Update URL without refresh
                window.history.pushState({category: categorySlug}, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
                courseContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-exclamation-circle display-1 text-danger"></i>
                        <p class="text-muted mt-3">Terjadi kesalahan saat memuat data.</p>
                        <button class="btn btn-primary mt-3" onclick="location.reload()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Muat Ulang
                        </button>
                    </div>
                `;
            });
        });
    });

    function renderCourses(courses) {
        const html = courses.map((course, index) => {
            const rating = parseFloat(course.reviews_avg_rating || 0).toFixed(1);
            const duration = course.lessons_sum_duration || 0;
            const instructorName = course.instructor?.name || 'Instruktur';
            const instructorPicture = course.instructor?.profile_picture;
            const categoryName = course.category?.name || 'Course';

            // Generate initials
            const nameParts = instructorName.trim().split(' ').filter(part => part);
            const initials = nameParts.length > 1
                ? (nameParts[0][0] + nameParts[nameParts.length - 1][0]).toUpperCase()
                : nameParts[0].substring(0, 2).toUpperCase();

            // Format price
            const formattedPrice = new Intl.NumberFormat('id-ID').format(course.price);

            // Truncate description safely
            const description = course.description
                ? (course.description.length > 100 ? course.description.substring(0, 100) + '...' : course.description)
                : 'Tidak ada deskripsi';

            // Escape HTML to prevent XSS
            const escapeHtml = (text) => {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            };

            return `
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                    <div class="course-card shadow-sm rounded overflow-hidden">
                        <div class="position-relative">
                            <div class="course-image">
                                ${course.thumbnail ?
                                    `<img src="/storage/${escapeHtml(course.thumbnail)}"
                                         alt="${escapeHtml(course.title)}"
                                         class="course-thumbnail"
                                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                     <div class="course-placeholder" style="display:none;">
                                        <i class="bi bi-book"></i>
                                        <span>${escapeHtml(categoryName)}</span>
                                     </div>`
                                    :
                                    `<div class="course-placeholder">
                                        <i class="bi bi-book"></i>
                                        <span>${escapeHtml(categoryName)}</span>
                                     </div>`
                                }
                            </div>
                            <div class="course-rating position-absolute top-0 end-0 m-2 px-2 py-1 rounded bg-white shadow-sm d-flex align-items-center">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                <span class="fw-semibold">${rating}</span>
                            </div>
                        </div>

                        <div class="course-content p-3">
                            <div class="course-meta d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    ${instructorPicture ?
                                        `<img src="/storage/${escapeHtml(instructorPicture)}"
                                             alt="${escapeHtml(instructorName)}"
                                             class="rounded-circle me-2"
                                             width="40"
                                             height="40"
                                             style="object-fit: cover; object-position: center;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                         <div class="avatar-fallback rounded-circle me-2 d-none justify-content-center align-items-center" style="width:40px;height:40px;">
                                            <span>${initials}</span>
                                         </div>`
                                        :
                                        `<div class="avatar-fallback rounded-circle me-2 d-flex justify-content-center align-items-center" style="width:40px;height:40px;">
                                            <span>${initials}</span>
                                         </div>`
                                    }
                                    <small class="text-muted">${escapeHtml(instructorName)}</small>
                                </div>
                                <span>
                                    <i class="bi bi-clock me-1"></i>${duration} Jam
                                </span>
                            </div>

                            <h5 class="fw-semibold mb-2">${escapeHtml(course.title)}</h5>
                            <p class="text-muted small">${escapeHtml(description)}</p>

                            <div class="course-footer d-flex justify-content-between align-items-center mt-3">
                                <div class="text-primary fw-bold fs-5">
                                    Rp ${formattedPrice}
                                </div>
                                <a href="/courses/${escapeHtml(course.slug)}" class="btn btn-outline-primary btn-sm rounded-pill">
                                    Join Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        courseContainer.innerHTML = html;

        // Re-initialize AOS animation
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    }

    function renderEmpty() {
        courseContainer.innerHTML = `
            <div class="col-12 text-center" data-aos="fade-up">
                <div class="py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada kursus tersedia untuk kategori ini.</p>
                    <a href="/" class="btn btn-outline-primary mt-3">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Semua Kategori
                    </a>
                </div>
            </div>
        `;

        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    }

    // Handle browser back/forward
    window.addEventListener('popstate', function(e) {
        location.reload();
    });
});


 document.addEventListener('DOMContentLoaded', function() {
        const coursesContainer = document.getElementById('coursesContainer');
        const loadingState = document.getElementById('loadingState');
        const emptyState = document.getElementById('emptyState');
        const paginationContainer = document.getElementById('paginationContainer');
        const resultsCount = document.getElementById('resultsCount');

        // Get all filter inputs
        const categoryInputs = document.querySelectorAll('input[name="category"]');
        const typeInputs = document.querySelectorAll('input[name="type"]');
        const sortInputs = document.querySelectorAll('input[name="sort"]');
        const resetButton = document.getElementById('resetFilters');

        // Add event listeners
        categoryInputs.forEach(input => input.addEventListener('change', applyFilters));
        typeInputs.forEach(input => input.addEventListener('change', applyFilters));
        sortInputs.forEach(input => input.addEventListener('change', applyFilters));
        resetButton.addEventListener('click', resetFilters);

        async function applyFilters() {
            const params = new URLSearchParams();

            // Get selected category
            const selectedCategory = document.querySelector('input[name="category"]:checked');
            if (selectedCategory && selectedCategory.value) {
                params.append('category', selectedCategory.value);
            }

            // Get selected type
            const selectedTypes = Array.from(document.querySelectorAll('input[name="type"]:checked'))
                .map(input => input.value);
            if (selectedTypes.length === 1) {
                params.append('type', selectedTypes[0]);
            }

            // Get selected sort
            const selectedSort = document.querySelector('input[name="sort"]:checked');
            if (selectedSort && selectedSort.value) {
                params.append('sort', selectedSort.value);
            }

            const url = `{{ route('courses.all') }}?${params.toString()}`;

            // Show loading with smooth transition
            coursesContainer.style.opacity = '0';
            setTimeout(() => {
                coursesContainer.style.display = 'none';
                loadingState.style.display = 'block';
                emptyState.style.display = 'none';
                paginationContainer.style.display = 'none';
            }, 300);

            try {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success && data.courses.length > 0) {
                    renderCourses(data.courses);
                    resultsCount.innerHTML =
                        `<i class="bi bi-collection"></i><span>${data.courses.length} kelas</span>`;
                    coursesContainer.style.display = 'grid';
                    setTimeout(() => {
                        coursesContainer.style.opacity = '1';
                    }, 50);
                } else {
                    emptyState.style.display = 'block';
                    resultsCount.innerHTML = `<i class="bi bi-collection"></i><span>0 kelas</span>`;
                }
            } catch (error) {
                console.error('Error:', error);
                emptyState.style.display = 'block';
                resultsCount.innerHTML = `<i class="bi bi-collection"></i><span>0 kelas</span>`;
            } finally {
                loadingState.style.display = 'none';
            }
        }

        function renderCourses(courses) {
            coursesContainer.innerHTML = courses.map((course, index) => `
            <div class="course-card-wrapper" style="animation-delay: ${index * 0.1}s">
                <div class="course-card">
                    <div class="course-thumbnail">
                        ${course.thumbnail
                            ? `<img src="/storage/${course.thumbnail}" alt="${course.title}">`
                            : `<div class="thumbnail-placeholder"><i class="bi bi-image"></i></div>`
                        }
                        ${course.price == 0
                            ? '<span class="course-badge free"><i class="bi bi-stars"></i>GRATIS</span>'
                            : '<span class="course-badge premium"><i class="bi bi-gem"></i>PRO</span>'
                        }
                        <div class="course-overlay">
                            <a href="/purchase/${course.slug}" class="btn-view">
                                <i class="bi bi-eye"></i>
                                <span>Lihat Detail</span>
                            </a>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-tags">
                            <span class="tag">
                                <i class="bi bi-tag-fill"></i>
                                ${course.category ? course.category.name : 'Kursus'}
                            </span>
                        </div>
                        <h5 class="course-title">${course.title.substring(0, 50)}${course.title.length > 50 ? '...' : ''}</h5>
                        <p class="course-description">${course.description.substring(0, 80)}${course.description.length > 80 ? '...' : ''}</p>
                        <div class="course-meta">
                            <div class="meta-item">
                                <i class="bi bi-person-circle"></i>
                                <span>${course.instructor ? course.instructor.name : 'Instruktur'}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-clock-history"></i>
                                <span>${course.lessons_sum_duration || 0}j</span>
                            </div>
                            ${course.reviews_avg_rating > 0 ? `
                                <div class="meta-item">
                                    <i class="bi bi-star-fill"></i>
                                    <span>${Number(course.reviews_avg_rating).toFixed(1)}</span>
                                </div>
                            ` : ''}
                        </div>
                        <div class="course-footer">
                            <div class="course-price">
                                ${course.price == 0
                                    ? '<span class="price-free">Gratis</span>'
                                    : `<div class="price-wrapper">
                                        <span class="price-label">Harga</span>
                                        <span class="price-amount">Rp ${Number(course.price).toLocaleString('id-ID')}</span>
                                       </div>`
                                }
                            </div>
                            <a href="/purchase/${course.slug}" class="btn-buy">
                                <i class="bi bi-cart-plus"></i>
                                <span>Beli</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        }

        function resetFilters() {
            document.querySelector('input[name="category"][value=""]').checked = true;
            typeInputs.forEach(input => input.checked = false);
            document.querySelector('input[name="sort"][value="terbaru"]').checked = true;
            applyFilters();
        }

        // Add smooth scroll to top on filter change
        function smoothScrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Add transition effect to courses grid
        coursesContainer.style.transition = 'opacity 0.3s ease';
        coursesContainer.style.opacity = '1';
    });


    // Tab Switching Function
    function switchTab(event, tabId) {
        // Remove active class from all tabs and panes
        const tabs = document.querySelectorAll('.tab-btn');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => tab.classList.remove('active'));
        panes.forEach(pane => pane.classList.remove('active'));

        // Add active class to clicked tab and corresponding pane
        event.currentTarget.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    }

    // Copy Link Function
    function copyLink() {
        const url = window.location.href;

        // Create temporary input
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Show notification
        const btn = event.currentTarget;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-lg"></i>';
        btn.style.background = '#10b981';

        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.background = '#6b7280';
        }, 2000);
    }

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe benefit items
    document.querySelectorAll('.benefit-item, .curriculum-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.5s, transform 0.5s';
        observer.observe(item);
    });


