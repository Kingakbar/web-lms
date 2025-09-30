
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
