<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Promo;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LmsSeeder extends Seeder
{
    public function run(): void
    {
        // ===== USERS =====
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        $instructor1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor1->assignRole('instructor');

        $instructor2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor2->assignRole('instructor');

        $instructor3 = User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'dedi.kurniawan@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor3->assignRole('instructor');

        $student1 = User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi.pratama@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student1->assignRole('student');

        $student2 = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student2->assignRole('student');

        $student3 = User::create([
            'name' => 'Rizky Maulana',
            'email' => 'rizky.maulana@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student3->assignRole('student');

        $student4 = User::create([
            'name' => 'Putri Wulandari',
            'email' => 'putri.wulandari@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student4->assignRole('student');

        $student5 = User::create([
            'name' => 'Agus Setiawan',
            'email' => 'agus.setiawan@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student5->assignRole('student');

        $student6 = User::create([
            'name' => 'Maya Safitri',
            'email' => 'maya.safitri@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student6->assignRole('student');

        $student7 = User::create([
            'name' => 'Faisal Rahman',
            'email' => 'faisal.rahman@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student7->assignRole('student');

        $student8 = User::create([
            'name' => 'Linda Susanti',
            'email' => 'linda.susanti@lms.com',
            'password' => Hash::make('password123'),
        ]);
        $student8->assignRole('student');

        // ===== CATEGORIES =====
        $programming = Category::create(['name' => 'Programming', 'slug' => 'programming']);
        $design = Category::create(['name' => 'UI/UX Design', 'slug' => 'ui-ux-design']);
        $business = Category::create(['name' => 'Business Management', 'slug' => 'business-management']);
        $marketing = Category::create(['name' => 'Digital Marketing', 'slug' => 'digital-marketing']);
        $data = Category::create(['name' => 'Data Science', 'slug' => 'data-science']);

        // ===== COURSES =====
        $course1 = Course::create([
            'category_id' => $programming->id,
            'user_id' => $instructor1->id,
            'title' => 'Laravel 11 untuk Pemula',
            'slug' => 'laravel-11-untuk-pemula',
            'description' => 'Kuasai Laravel 11 mulai dari instalasi hingga deployment. Pelajari routing, controller, blade templating, database migration, eloquent ORM, authentication, dan masih banyak lagi.',
            'price' => 250000,
            'status' => 'published',
        ]);

        $course2 = Course::create([
            'category_id' => $design->id,
            'user_id' => $instructor2->id,
            'title' => 'UI/UX Design Mastery',
            'slug' => 'ui-ux-design-mastery',
            'description' => 'Belajar desain UI/UX dengan studi kasus nyata. Menguasai Figma, Adobe XD, user research, wireframing, prototyping, dan usability testing.',
            'price' => 175000,
            'status' => 'published',
        ]);

        $course3 = Course::create([
            'category_id' => $business->id,
            'user_id' => $instructor3->id,
            'title' => 'Digital Business Management',
            'slug' => 'digital-business-management',
            'description' => 'Pelajari manajemen bisnis modern di era digital. Strategi transformasi digital, e-commerce, dan inovasi bisnis.',
            'price' => 300000,
            'status' => 'published',
        ]);

        $course4 = Course::create([
            'category_id' => $programming->id,
            'user_id' => $instructor1->id,
            'title' => 'React JS Complete Guide',
            'slug' => 'react-js-complete-guide',
            'description' => 'Menjadi React Developer profesional dengan mempelajari hooks, context API, Redux, dan best practices dalam membangun aplikasi modern.',
            'price' => 275000,
            'status' => 'published',
        ]);

        $course5 = Course::create([
            'category_id' => $marketing->id,
            'user_id' => $instructor2->id,
            'title' => 'Instagram Marketing Masterclass',
            'slug' => 'instagram-marketing-masterclass',
            'description' => 'Strategi lengkap marketing di Instagram dari nol hingga mahir. Content creation, engagement, Instagram Ads, dan analytics.',
            'price' => 150000,
            'status' => 'published',
        ]);

        $course6 = Course::create([
            'category_id' => $data->id,
            'user_id' => $instructor3->id,
            'title' => 'Python Data Analysis',
            'slug' => 'python-data-analysis',
            'description' => 'Analisis data dengan Python menggunakan Pandas, NumPy, Matplotlib, dan Seaborn. Cocok untuk pemula yang ingin masuk ke dunia data science.',
            'price' => 225000,
            'status' => 'published',
        ]);

        $course7 = Course::create([
            'category_id' => $design->id,
            'user_id' => $instructor2->id,
            'title' => 'Graphic Design Fundamentals',
            'slug' => 'graphic-design-fundamentals',
            'description' => 'Dasar-dasar desain grafis profesional menggunakan Adobe Photoshop dan Illustrator. Dari teori warna hingga portfolio design.',
            'price' => 195000,
            'status' => 'published',
        ]);

        $course8 = Course::create([
            'category_id' => $programming->id,
            'user_id' => $instructor1->id,
            'title' => 'Vue.js 3 Bootcamp',
            'slug' => 'vue-js-3-bootcamp',
            'description' => 'Bootcamp intensif Vue.js 3 dengan Composition API, Pinia state management, dan Vue Router untuk membangun single page application.',
            'price' => 260000,
            'status' => 'published',
        ]);

        // ===== LESSONS =====
        Lesson::insert([
            // Course 1 - Laravel
            [
                'course_id' => $course1->id,
                'title' => 'Pengenalan Framework Laravel',
                'slug' => 'pengenalan-framework-laravel',
                'content' => 'Mengapa Laravel menjadi framework PHP paling populer di dunia. Keunggulan dan ekosistem Laravel.',
                'video_url' => 'https://youtu.be/laravel-intro',
                'duration' => 15,
                'order' => 1,
            ],
            [
                'course_id' => $course1->id,
                'title' => 'Instalasi & Setup Laravel 11',
                'slug' => 'instalasi-setup-laravel-11',
                'content' => 'Langkah demi langkah instalasi Laravel menggunakan Composer, konfigurasi environment, dan setup database.',
                'video_url' => 'https://youtu.be/laravel-setup',
                'duration' => 25,
                'order' => 2,
            ],
            [
                'course_id' => $course1->id,
                'title' => 'Routing & Controller',
                'slug' => 'routing-controller',
                'content' => 'Memahami routing di Laravel, membuat controller, dan mengelola request-response cycle.',
                'video_url' => 'https://youtu.be/laravel-routing',
                'duration' => 30,
                'order' => 3,
            ],
            [
                'course_id' => $course1->id,
                'title' => 'Blade Templating Engine',
                'slug' => 'blade-templating-engine',
                'content' => 'Menguasai Blade templating, layout inheritance, components, dan directives.',
                'video_url' => 'https://youtu.be/laravel-blade',
                'duration' => 35,
                'order' => 4,
            ],

            // Course 2 - UI/UX Design
            [
                'course_id' => $course2->id,
                'title' => 'Prinsip Dasar UI Design',
                'slug' => 'prinsip-dasar-ui-design',
                'content' => 'Warna, tipografi, layout, dan hierarchy dalam desain UI yang efektif.',
                'video_url' => 'https://youtu.be/ui-basics',
                'duration' => 20,
                'order' => 1,
            ],
            [
                'course_id' => $course2->id,
                'title' => 'User Research & Persona',
                'slug' => 'user-research-persona',
                'content' => 'Metode riset pengguna, membuat user persona, dan memahami user journey.',
                'video_url' => 'https://youtu.be/user-research',
                'duration' => 28,
                'order' => 2,
            ],
            [
                'course_id' => $course2->id,
                'title' => 'Wireframing & Prototyping',
                'slug' => 'wireframing-prototyping',
                'content' => 'Membuat wireframe dan prototype interaktif menggunakan Figma.',
                'video_url' => 'https://youtu.be/wireframing',
                'duration' => 40,
                'order' => 3,
            ],

            // Course 3 - Business Management
            [
                'course_id' => $course3->id,
                'title' => 'Strategi Bisnis Digital',
                'slug' => 'strategi-bisnis-digital',
                'content' => 'Cara merancang model bisnis yang sukses di era digital dan transformasi digital.',
                'video_url' => 'https://youtu.be/digital-strategy',
                'duration' => 22,
                'order' => 1,
            ],
            [
                'course_id' => $course3->id,
                'title' => 'E-Commerce Business Model',
                'slug' => 'ecommerce-business-model',
                'content' => 'Membangun bisnis e-commerce yang profitable, dari marketplace hingga toko online sendiri.',
                'video_url' => 'https://youtu.be/ecommerce-model',
                'duration' => 32,
                'order' => 2,
            ],

            // Course 4 - React JS
            [
                'course_id' => $course4->id,
                'title' => 'React Fundamentals',
                'slug' => 'react-fundamentals',
                'content' => 'Dasar-dasar React: components, props, state, dan JSX syntax.',
                'video_url' => 'https://youtu.be/react-basics',
                'duration' => 18,
                'order' => 1,
            ],
            [
                'course_id' => $course4->id,
                'title' => 'React Hooks Deep Dive',
                'slug' => 'react-hooks-deep-dive',
                'content' => 'Menguasai useState, useEffect, useContext, dan custom hooks.',
                'video_url' => 'https://youtu.be/react-hooks',
                'duration' => 38,
                'order' => 2,
            ],

            // Course 5 - Instagram Marketing
            [
                'course_id' => $course5->id,
                'title' => 'Instagram Algorithm Mastery',
                'slug' => 'instagram-algorithm-mastery',
                'content' => 'Memahami cara kerja algoritma Instagram untuk meningkatkan reach dan engagement.',
                'video_url' => 'https://youtu.be/ig-algorithm',
                'duration' => 16,
                'order' => 1,
            ],
            [
                'course_id' => $course5->id,
                'title' => 'Content Creation Strategy',
                'slug' => 'content-creation-strategy',
                'content' => 'Strategi membuat konten yang viral dan engaging di Instagram.',
                'video_url' => 'https://youtu.be/ig-content',
                'duration' => 24,
                'order' => 2,
            ],

            // Course 6 - Python Data Analysis
            [
                'course_id' => $course6->id,
                'title' => 'Introduction to Pandas',
                'slug' => 'introduction-to-pandas',
                'content' => 'Memulai analisis data dengan library Pandas: DataFrame, Series, dan basic operations.',
                'video_url' => 'https://youtu.be/pandas-intro',
                'duration' => 27,
                'order' => 1,
            ],
            [
                'course_id' => $course6->id,
                'title' => 'Data Visualization with Matplotlib',
                'slug' => 'data-visualization-matplotlib',
                'content' => 'Membuat visualisasi data yang menarik dan informatif dengan Matplotlib.',
                'video_url' => 'https://youtu.be/matplotlib-viz',
                'duration' => 33,
                'order' => 2,
            ],
        ]);

        // ===== QUIZZES =====
        $quiz1 = Quiz::create([
            'course_id' => $course1->id,
            'user_id' => $instructor1->id,
            'title' => 'Quiz Laravel Pemula',
            'description' => 'Uji pemahaman dasar tentang Laravel framework.',
            'passing_score' => 70,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz1->id,
                'question' => 'Apa itu Laravel?',
                'option_a' => 'Framework PHP',
                'option_b' => 'Framework Java',
                'option_c' => 'Database Management System',
                'option_d' => 'Web Server',
                'correct_answer' => 'a',
            ],
            [
                'quiz_id' => $quiz1->id,
                'question' => 'Perintah untuk membuat controller di Laravel?',
                'option_a' => 'php artisan make:model',
                'option_b' => 'php artisan make:controller',
                'option_c' => 'php artisan new:controller',
                'option_d' => 'php artisan controller:create',
                'correct_answer' => 'b',
            ],
            [
                'quiz_id' => $quiz1->id,
                'question' => 'File konfigurasi environment Laravel adalah?',
                'option_a' => 'config.php',
                'option_b' => '.env',
                'option_c' => 'settings.ini',
                'option_d' => 'app.config',
                'correct_answer' => 'b',
            ],
        ]);

        $quiz2 = Quiz::create([
            'course_id' => $course2->id,
            'user_id' => $instructor2->id,
            'title' => 'Quiz UI/UX Dasar',
            'description' => 'Tes pengetahuan dasar tentang desain UI/UX.',
            'passing_score' => 70,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz2->id,
                'question' => 'Apa kepanjangan dari UI?',
                'option_a' => 'User Internet',
                'option_b' => 'User Interface',
                'option_c' => 'Universal Input',
                'option_d' => 'Unique Idea',
                'correct_answer' => 'b',
            ],
            [
                'quiz_id' => $quiz2->id,
                'question' => 'Prinsip warna dalam UI Design dikenal dengan?',
                'option_a' => 'Typography',
                'option_b' => 'Layouting',
                'option_c' => 'Color Theory',
                'option_d' => 'Grid System',
                'correct_answer' => 'c',
            ],
            [
                'quiz_id' => $quiz2->id,
                'question' => 'Tool yang paling populer untuk UI/UX Design saat ini?',
                'option_a' => 'Microsoft Paint',
                'option_b' => 'Figma',
                'option_c' => 'Notepad',
                'option_d' => 'Excel',
                'correct_answer' => 'b',
            ],
        ]);

        $quiz3 = Quiz::create([
            'course_id' => $course3->id,
            'user_id' => $instructor3->id,
            'title' => 'Quiz Digital Business',
            'description' => 'Tes strategi bisnis digital dan transformasi digital.',
            'passing_score' => 75,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz3->id,
                'question' => 'Apa tujuan utama bisnis digital?',
                'option_a' => 'Menjual produk secara offline',
                'option_b' => 'Menggunakan teknologi untuk menciptakan nilai',
                'option_c' => 'Menghindari penggunaan internet',
                'option_d' => 'Menambah biaya operasional',
                'correct_answer' => 'b',
            ],
            [
                'quiz_id' => $quiz3->id,
                'question' => 'Platform e-commerce terbesar di Indonesia?',
                'option_a' => 'Amazon',
                'option_b' => 'eBay',
                'option_c' => 'Tokopedia',
                'option_d' => 'Alibaba',
                'correct_answer' => 'c',
            ],
        ]);

        $quiz4 = Quiz::create([
            'course_id' => $course4->id,
            'user_id' => $instructor1->id,
            'title' => 'Quiz React Fundamentals',
            'description' => 'Uji pemahaman dasar tentang React JS.',
            'passing_score' => 70,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz4->id,
                'question' => 'Apa itu JSX?',
                'option_a' => 'JavaScript Extension',
                'option_b' => 'JavaScript XML',
                'option_c' => 'Java Syntax',
                'option_d' => 'JSON Extension',
                'correct_answer' => 'b',
            ],
            [
                'quiz_id' => $quiz4->id,
                'question' => 'Hook untuk mengelola state di React?',
                'option_a' => 'useEffect',
                'option_b' => 'useState',
                'option_c' => 'useContext',
                'option_d' => 'useReducer',
                'correct_answer' => 'b',
            ],
        ]);

        // ===== ENROLLMENTS + PAYMENTS =====
        // Student 1 enrollments
        $enroll1 = Enrollment::create([
            'user_id' => $student1->id,
            'course_id' => $course1->id,
            'enrolled_at' => now()->subDays(30),
        ]);
        Payment::create([
            'enrollment_id' => $enroll1->id,
            'amount' => $course1->price,
            'method' => 'qris',
            'status' => 'completed',
            'paid_at' => now()->subDays(30),
        ]);

        $enroll2 = Enrollment::create([
            'user_id' => $student1->id,
            'course_id' => $course4->id,
            'enrolled_at' => now()->subDays(15),
        ]);
        Payment::create([
            'enrollment_id' => $enroll2->id,
            'amount' => $course4->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(15),
        ]);

        // Student 2 enrollments
        $enroll3 = Enrollment::create([
            'user_id' => $student2->id,
            'course_id' => $course2->id,
            'enrolled_at' => now()->subDays(25),
        ]);
        Payment::create([
            'enrollment_id' => $enroll3->id,
            'amount' => $course2->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(25),
        ]);

        $enroll4 = Enrollment::create([
            'user_id' => $student2->id,
            'course_id' => $course5->id,
            'enrolled_at' => now()->subDays(10),
        ]);
        Payment::create([
            'enrollment_id' => $enroll4->id,
            'amount' => $course5->price,
            'method' => 'qris',
            'status' => 'completed',
            'paid_at' => now()->subDays(10),
        ]);

        // Student 3 enrollments
        $enroll5 = Enrollment::create([
            'user_id' => $student3->id,
            'course_id' => $course3->id,
            'enrolled_at' => now()->subDays(5),
        ]);
        Payment::create([
            'enrollment_id' => $enroll5->id,
            'amount' => $course3->price,
            'method' => 'cash',
            'status' => 'pending',
        ]);

        $enroll6 = Enrollment::create([
            'user_id' => $student3->id,
            'course_id' => $course6->id,
            'enrolled_at' => now()->subDays(20),
        ]);
        Payment::create([
            'enrollment_id' => $enroll6->id,
            'amount' => $course6->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(20),
        ]);

        // Student 4 enrollments
        $enroll7 = Enrollment::create([
            'user_id' => $student4->id,
            'course_id' => $course1->id,
            'enrolled_at' => now()->subDays(22),
        ]);
        Payment::create([
            'enrollment_id' => $enroll7->id,
            'amount' => $course1->price,
            'method' => 'qris',
            'status' => 'completed',
            'paid_at' => now()->subDays(22),
        ]);

        $enroll8 = Enrollment::create([
            'user_id' => $student4->id,
            'course_id' => $course7->id,
            'enrolled_at' => now()->subDays(12),
        ]);
        Payment::create([
            'enrollment_id' => $enroll8->id,
            'amount' => $course7->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(12),
        ]);

        // Student 5 enrollments
        $enroll9 = Enrollment::create([
            'user_id' => $student5->id,
            'course_id' => $course2->id,
            'enrolled_at' => now()->subDays(18),
        ]);
        Payment::create([
            'enrollment_id' => $enroll9->id,
            'amount' => $course2->price,
            'method' => 'qris',
            'status' => 'completed',
            'paid_at' => now()->subDays(18),
        ]);

        // Student 6 enrollments
        $enroll10 = Enrollment::create([
            'user_id' => $student6->id,
            'course_id' => $course5->id,
            'enrolled_at' => now()->subDays(14),
        ]);
        Payment::create([
            'enrollment_id' => $enroll10->id,
            'amount' => $course5->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(14),
        ]);

        $enroll11 = Enrollment::create([
            'user_id' => $student6->id,
            'course_id' => $course2->id,
            'enrolled_at' => now()->subDays(8),
        ]);
        Payment::create([
            'enrollment_id' => $enroll11->id,
            'amount' => $course2->price,
            'method' => 'qris',
            'status' => 'completed',
            'paid_at' => now()->subDays(8),
        ]);

        // Student 7 enrollments
        $enroll12 = Enrollment::create([
            'user_id' => $student7->id,
            'course_id' => $course4->id,
            'enrolled_at' => now()->subDays(28),
        ]);
        Payment::create([
            'enrollment_id' => $enroll12->id,
            'amount' => $course4->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(28),
        ]);

        // Student 8 enrollments
        $enroll13 = Enrollment::create([
            'user_id' => $student8->id,
            'course_id' => $course1->id,
            'enrolled_at' => now()->subDays(7),
        ]);
        Payment::create([
            'enrollment_id' => $enroll13->id,
            'amount' => $course1->price,
            'method' => 'qris',
            'status' => 'completed',
            'paid_at' => now()->subDays(7),
        ]);

        $enroll14 = Enrollment::create([
            'user_id' => $student8->id,
            'course_id' => $course8->id,
            'enrolled_at' => now()->subDays(3),
        ]);
        Payment::create([
            'enrollment_id' => $enroll14->id,
            'amount' => $course8->price,
            'method' => 'transfer',
            'status' => 'completed',
            'paid_at' => now()->subDays(3),
        ]);

        // ===== REVIEWS =====
        Review::insert([
            // Reviews untuk Course 1 - Laravel
            [
                'user_id' => $student1->id,
                'course_id' => $course1->id,
                'rating' => 5,
                'comment' => 'Kursus Laravel terbaik yang pernah saya ikuti! Penjelasan Pak Budi sangat detail dan mudah dipahami. Dari yang tadinya nol pengetahuan tentang Laravel, sekarang sudah bisa bikin project sendiri. Highly recommended!',
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'user_id' => $student4->id,
                'course_id' => $course1->id,
                'rating' => 5,
                'comment' => 'Materi sangat lengkap, dari basic sampai advanced. Video tutorialnya jelas, dan ada study case yang real. Worth it banget dengan harga segini!',
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(18),
            ],
            [
                'user_id' => $student8->id,
                'course_id' => $course1->id,
                'rating' => 4,
                'comment' => 'Overall bagus, cuma mungkin perlu update untuk beberapa materi yang sudah outdated. Tapi untuk pemula seperti saya, ini sangat membantu!',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],

            // Reviews untuk Course 2 - UI/UX Design
            [
                'user_id' => $student2->id,
                'course_id' => $course2->id,
                'rating' => 5,
                'comment' => 'Bu Siti mengajar dengan sangat sabar dan detail. Saya yang awalnya gak ngerti apa-apa tentang design, sekarang udah bisa bikin portfolio sendiri. Terima kasih banyak!',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
            [
                'user_id' => $student5->id,
                'course_id' => $course2->id,
                'rating' => 5,
                'comment' => 'Materi UI/UX nya sangat aplikatif. Langsung bisa dipraktekkan ke project pribadi. Bu Siti juga responsif kalau ada pertanyaan di forum diskusi.',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'user_id' => $student6->id,
                'course_id' => $course2->id,
                'rating' => 4,
                'comment' => 'Kursus yang bagus untuk pemula. Cuma kadang agak cepat sih penjelasannya, tapi overall sangat membantu!',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],

            // Reviews untuk Course 3 - Digital Business
            [
                'user_id' => $student3->id,
                'course_id' => $course3->id,
                'rating' => 5,
                'comment' => 'Sangat recommended untuk yang mau mulai bisnis online! Pak Dedi memberikan insight yang sangat berharga dari pengalaman nyata beliau. Materi tentang e-commerce sangat applicable.',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],

            // Reviews untuk Course 4 - React JS
            [
                'user_id' => $student1->id,
                'course_id' => $course4->id,
                'rating' => 5,
                'comment' => 'Setelah selesai kursus Laravel, saya lanjut ke React dan nggak nyesel! Pak Budi menjelaskan konsep hooks dengan sangat jelas. Sekarang saya bisa bikin fullstack app!',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'user_id' => $student7->id,
                'course_id' => $course4->id,
                'rating' => 4,
                'comment' => 'Penjelasan tentang React Hooks sangat detail. Mungkin perlu ditambah materi tentang Redux toolkit. Tapi overall udah bagus banget!',
                'created_at' => now()->subDays(22),
                'updated_at' => now()->subDays(22),
            ],

            // Reviews untuk Course 5 - Instagram Marketing
            [
                'user_id' => $student2->id,
                'course_id' => $course5->id,
                'rating' => 5,
                'comment' => 'Kursus marketing terbaik! Dalam 2 minggu followers Instagram bisnis saya naik 300%. Strateginya benar-benar work! Thank you Bu Siti!',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'user_id' => $student6->id,
                'course_id' => $course5->id,
                'rating' => 5,
                'comment' => 'Materi sangat up to date dengan algoritma Instagram terbaru. Case study nya juga real dan sangat inspiratif. Worth every penny!',
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],

            // Reviews untuk Course 6 - Python Data Analysis
            [
                'user_id' => $student3->id,
                'course_id' => $course6->id,
                'rating' => 5,
                'comment' => 'Sebagai pemula di data science, kursus ini sangat membantu! Pak Dedi mengajar dengan tempo yang pas, tidak terlalu cepat. Visualisasi data jadi lebih mudah dipahami.',
                'created_at' => now()->subDays(16),
                'updated_at' => now()->subDays(16),
            ],

            // Reviews untuk Course 7 - Graphic Design
            [
                'user_id' => $student4->id,
                'course_id' => $course7->id,
                'rating' => 5,
                'comment' => 'Kursus graphic design yang sangat komprehensif! Dari teori sampai praktek, semuanya dijelaskan dengan baik. Portfolio saya sekarang jauh lebih profesional.',
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9),
            ],

            // Reviews untuk Course 8 - Vue.js
            [
                'user_id' => $student8->id,
                'course_id' => $course8->id,
                'rating' => 4,
                'comment' => 'Vue.js 3 dengan Composition API dijelaskan dengan sangat baik. Materinya structured dan mudah diikuti. Recommended!',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ]);

        // ===== PROMOS =====
        Promo::insert([
            [
                'title' => 'Diskon Awal Tahun',
                'slug' => 'diskon-awal-tahun',
                'code' => 'NEWYEAR25',
                'discount_percentage' => 25,
                'start_date' => now()->subWeek(),
                'end_date' => now()->addWeeks(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Promo Kemerdekaan',
                'slug' => 'promo-kemerdekaan',
                'code' => 'MERDEKA45',
                'discount_percentage' => 45,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Flash Sale Weekend',
                'slug' => 'flash-sale-weekend',
                'code' => 'WEEKEND50',
                'discount_percentage' => 50,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ramadan Kareem',
                'slug' => 'ramadan-kareem',
                'code' => 'RAMADAN30',
                'discount_percentage' => 30,
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(35),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
