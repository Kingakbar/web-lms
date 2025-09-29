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

        // ===== CATEGORIES =====
        $programming = Category::create(['name' => 'Programming', 'slug' => 'programming']);
        $design      = Category::create(['name' => 'UI/UX Design', 'slug' => 'ui-ux-design']);
        $business    = Category::create(['name' => 'Business Management', 'slug' => 'business-management']);

        // ===== COURSES =====
        $course1 = Course::create([
            'category_id' => $programming->id,
            'user_id'     => $instructor1->id,
            'title'       => 'Laravel 11 untuk Pemula',
            'slug'        => 'laravel-11-untuk-pemula',
            'description' => 'Kuasai Laravel 11 mulai dari instalasi hingga deployment.',
            'price'       => 250000,
            'status'      => 'published',
        ]);

        $course2 = Course::create([
            'category_id' => $design->id,
            'user_id'     => $instructor2->id,
            'title'       => 'UI/UX Design Mastery',
            'slug'        => 'ui-ux-design-mastery',
            'description' => 'Belajar desain UI/UX dengan studi kasus nyata.',
            'price'       => 175000,
            'status'      => 'published',
        ]);

        $course3 = Course::create([
            'category_id' => $business->id,
            'user_id'     => $admin->id,
            'title'       => 'Digital Business Management',
            'slug'        => 'digital-business-management',
            'description' => 'Pelajari manajemen bisnis modern di era digital.',
            'price'       => 300000,
            'status'      => 'published',
        ]);

        // ===== LESSONS =====
        Lesson::insert([
            // Course 1
            [
                'course_id' => $course1->id,
                'title'     => 'Pengenalan Framework Laravel',
                'slug'      => 'pengenalan-framework-laravel',
                'content'   => 'Mengapa Laravel menjadi framework PHP paling populer.',
                'video_url' => 'https://youtu.be/vid1',
                'order'     => 1,
            ],
            [
                'course_id' => $course1->id,
                'title'     => 'Instalasi & Setup Laravel 11',
                'slug'      => 'instalasi-setup-laravel-11',
                'content'   => 'Langkah demi langkah instalasi Laravel menggunakan Composer.',
                'video_url' => 'https://youtu.be/vid2',
                'order'     => 2,
            ],

            // Course 2
            [
                'course_id' => $course2->id,
                'title'     => 'Prinsip Dasar UI Design',
                'slug'      => 'prinsip-dasar-ui-design',
                'content'   => 'Warna, tipografi, dan layout dalam desain UI.',
                'video_url' => 'https://youtu.be/vid4',
                'order'     => 1,
            ],

            // Course 3
            [
                'course_id' => $course3->id,
                'title'     => 'Strategi Bisnis Digital',
                'slug'      => 'strategi-bisnis-digital',
                'content'   => 'Cara merancang model bisnis yang sukses di era digital.',
                'video_url' => 'https://youtu.be/vid6',
                'order'     => 1,
            ],
        ]);

        // ===== QUIZZES =====
        $quiz1 = Quiz::create([
            'course_id'     => $course1->id,
            'user_id'       => $instructor1->id, // QUIZ dibuat oleh instruktur course
            'title'         => 'Quiz Laravel Pemula',
            'description'   => 'Uji pemahaman dasar tentang Laravel.',
            'passing_score' => 70,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz1->id,
                'question' => 'Apa itu Laravel?',
                'option_a' => 'Framework PHP',
                'option_b' => 'Framework Java',
                'option_c' => 'Database',
                'option_d' => 'Server',
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
        ]);

        $quiz2 = Quiz::create([
            'course_id'     => $course2->id,
            'user_id'       => $instructor2->id, // QUIZ dibuat oleh instruktur course
            'title'         => 'Quiz UI/UX Dasar',
            'description'   => 'Tes pengetahuan dasar tentang desain UI/UX.',
            'passing_score' => 70,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz2->id,
                'question' => 'Apa itu UI?',
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
        ]);

        // kalau admin bikin quiz untuk course3
        $quiz3 = Quiz::create([
            'course_id'     => $course3->id,
            'user_id'       => $admin->id, // QUIZ dibuat oleh admin
            'title'         => 'Quiz Digital Business',
            'description'   => 'Tes strategi bisnis digital.',
            'passing_score' => 75,
        ]);

        QuizQuestion::insert([
            [
                'quiz_id' => $quiz3->id,
                'question' => 'Apa tujuan utama bisnis digital?',
                'option_a' => 'Menjual produk secara offline',
                'option_b' => 'Menggunakan teknologi untuk menciptakan nilai',
                'option_c' => 'Menghindari internet',
                'option_d' => 'Menambah biaya operasional',
                'correct_answer' => 'b',
            ],
        ]);

        // ===== ENROLLMENTS + PAYMENTS + REVIEWS =====
        $enroll1 = Enrollment::create([
            'user_id'    => $student1->id,
            'course_id'  => $course1->id,
            'enrolled_at' => now(),
        ]);
        Payment::create([
            'enrollment_id' => $enroll1->id,
            'amount'        => $course1->price,
            'method'        => 'qris',
            'status'        => 'completed',
            'paid_at'       => now(),
        ]);

        $enroll2 = Enrollment::create([
            'user_id'    => $student2->id,
            'course_id'  => $course2->id,
            'enrolled_at' => now(),
        ]);
        Payment::create([
            'enrollment_id' => $enroll2->id,
            'amount'        => $course2->price,
            'method'        => 'transfer',
            'status'        => 'completed',
            'paid_at'       => now(),
        ]);

        $enroll3 = Enrollment::create([
            'user_id'    => $student3->id,
            'course_id'  => $course3->id,
            'enrolled_at' => now(),
        ]);
        Payment::create([
            'enrollment_id' => $enroll3->id,
            'amount'        => $course3->price,
            'method'        => 'cash',
            'status'        => 'pending',
        ]);

        // ===== PROMOS =====
        Promo::insert([
            [
                'title'               => 'Diskon Awal Tahun',
                'slug'                => 'diskon-awal-tahun',
                'code'                => 'NEWYEAR25',
                'discount_percentage' => 25,
                'start_date'          => now()->subWeek(),
                'end_date'            => now()->addWeeks(2),
            ],
            [
                'title'               => 'Promo Kemerdekaan',
                'slug'                => 'promo-kemerdekaan',
                'code'                => 'MERDEKA45',
                'discount_percentage' => 45,
                'start_date'          => now()->subDays(10),
                'end_date'            => now()->addDays(20),
            ],
        ]);
    }
}
