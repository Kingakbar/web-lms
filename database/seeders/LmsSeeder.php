<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Promo;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LmsSeeder extends Seeder
{
    public function run(): void
    {
        // ===== USERS =====
        $admin = User::create([
            'name' => 'Admin Instruktur',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
        ]);

        $instructor1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@lms.com',
            'password' => Hash::make('password'),
        ]);

        $instructor2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@lms.com',
            'password' => Hash::make('password'),
        ]);

        $student1 = User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@lms.com',
            'password' => Hash::make('password'),
        ]);

        $student2 = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@lms.com',
            'password' => Hash::make('password'),
        ]);

        $student3 = User::create([
            'name' => 'Rizky Maulana',
            'email' => 'rizky@lms.com',
            'password' => Hash::make('password'),
        ]);

        // ===== CATEGORIES =====
        $programming = Category::create(['name' => 'Programming', 'slug' => 'programming']);
        $design      = Category::create(['name' => 'UI/UX Design', 'slug' => 'ui-ux-design']);
        $business    = Category::create(['name' => 'Business Management', 'slug' => 'business-management']);

        // ===== COURSES =====
        $course1 = Course::create([
            'category_id' => $programming->id,
            'user_id'     => $admin->id,
            'title'       => 'Belajar Laravel 11 dari Dasar',
            'slug'        => 'belajar-laravel-11-dari-dasar',
            'description' => 'Kursus lengkap Laravel 11 mulai dari dasar sampai mahir.',
            'price'       => 250000,
            'status'      => 'published',
        ]);

        $course2 = Course::create([
            'category_id' => $design->id,
            'user_id'     => $instructor1->id,
            'title'       => 'Fundamental UI/UX Design untuk Pemula',
            'slug'        => 'fundamental-ui-ux-design-untuk-pemula',
            'description' => 'Pelajari dasar-dasar desain antarmuka dan pengalaman pengguna.',
            'price'       => 150000,
            'status'      => 'published',
        ]);

        $course3 = Course::create([
            'category_id' => $business->id,
            'user_id'     => $instructor2->id,
            'title'       => 'Manajemen Bisnis Modern',
            'slug'        => 'manajemen-bisnis-modern',
            'description' => 'Strategi manajemen bisnis di era digital.',
            'price'       => 300000,
            'status'      => 'published',
        ]);

        // ===== LESSONS =====
        Lesson::insert([
            [
                'course_id' => $course1->id,
                'title'     => 'Pengenalan Laravel',
                'slug'      => 'pengenalan-laravel',
                'content'   => 'Apa itu Laravel dan kenapa banyak digunakan.',
                'video_url' => 'https://youtu.be/vid1',
                'order'     => 1,
            ],
            [
                'course_id' => $course1->id,
                'title'     => 'Instalasi Laravel 11',
                'slug'      => 'instalasi-laravel-11',
                'content'   => 'Langkah instalasi Laravel menggunakan Composer.',
                'video_url' => 'https://youtu.be/vid2',
                'order'     => 2,
            ],
            [
                'course_id' => $course1->id,
                'title'     => 'Routing & Controller',
                'slug'      => 'routing-controller',
                'content'   => 'Dasar routing dan controller di Laravel.',
                'video_url' => 'https://youtu.be/vid3',
                'order'     => 3,
            ],
            [
                'course_id' => $course2->id,
                'title'     => 'Dasar UI Design',
                'slug'      => 'dasar-ui-design',
                'content'   => 'Mengenal elemen dasar desain antarmuka.',
                'video_url' => 'https://youtu.be/vid4',
                'order'     => 1,
            ],
            [
                'course_id' => $course3->id,
                'title'     => 'Konsep Manajemen',
                'slug'      => 'konsep-manajemen',
                'content'   => 'Memahami konsep dasar manajemen modern.',
                'video_url' => 'https://youtu.be/vid5',
                'order'     => 1,
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
        Review::create([
            'user_id'   => $student1->id,
            'course_id' => $course1->id,
            'rating'    => 5,
            'comment'   => 'Materinya jelas dan mudah dipahami.',
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
        Review::create([
            'user_id'   => $student2->id,
            'course_id' => $course2->id,
            'rating'    => 4,
            'comment'   => 'Cukup membantu untuk pemula.',
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
                'discount_amount'     => null,
                'start_date'          => now()->subDays(5),
                'end_date'            => now()->addDays(20),
            ],
            [
                'title'               => 'Promo Kemerdekaan',
                'slug'                => 'promo-kemerdekaan',
                'code'                => 'MERDEKA45',
                'discount_percentage' => 45,
                'discount_amount'     => null,
                'start_date'          => now()->subDays(10),
                'end_date'            => now()->addDays(30),
            ],
        ]);
    }
}
