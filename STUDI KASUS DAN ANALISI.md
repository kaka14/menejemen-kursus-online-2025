# 📚 Manajemen Kursus Online – Laravel 12 + Filament

## 🧩 Studi Kasus

**Judul Aplikasi:**  
Sistem Manajemen Kursus Online

**Deskripsi Singkat:**  
Aplikasi ini memungkinkan admin untuk membuat daftar kursus, menambahkan murid, dan mencatat pendaftaran murid ke setiap kursus. Sistem dibangun menggunakan Laravel 12 dan Filament Admin Panel.

---

## 🎯 Tujuan Aplikasi

- Mengelola data **kursus**
- Mengelola data **murid**
- Mengelola data **pendaftaran murid ke kursus**
- Menyediakan dashboard dan laporan jumlah pendaftar

---

## 🧠 Analisis & Struktur Data

| Komponen      | Keterangan          |
|---------------|---------------------|
| **Framework** | Laravel 12          |
| **UI Panel**  | Filament v3         |
| **Database**  | MySQL (bisa lainnya)|
| **Relasi**    | 3 tabel utama dengan relasi `hasMany`, `belongsTo` |

---

## 🗂️ Struktur Tabel (ERD)

Courses
id (PK)
title
description

↓ hasMany

Enrollments
id (PK)
course_id (FK → courses.id)
student_id (FK → students.id)
enrolled_at

↑ belongsTo ↑ belongsTo

Students
id (PK)
name
email


---

## 📦 Fitur CRUD

| Modul     | Fitur                                      |
|-----------|--------------------------------------------|
| Course    | Tambah, edit, hapus, lihat semua kursus    |
| Student   | Tambah, edit, hapus, lihat semua siswa     |
| Enrollment| Tambah pendaftaran (dengan dropdown Select)|

---

## 🔎 Search & Relasi Dropdown

- Filament mendukung `searchable()` untuk input dropdown dan kolom tabel.
- Dropdown `course_id` dan `student_id` diisi otomatis dengan relasi model.
- Kolom `course.title` dan `student.name` muncul di tabel `Enrollment`.

---

## 🔢 Implementasi Struktur Data

| Struktur Data | Implementasi                                                                 |
|---------------|------------------------------------------------------------------------------|
| **Array**     | Ambil seluruh `Enrollment::all()` dan loop data menggunakan array            |
| **Stack**     | Simulasi undo pendaftaran terakhir dengan `pop()` dari array pendaftaran     |
| **Queue**     | Simulasi antrean siswa baru → `queue()->push()` untuk pendaftaran manual     |
| **Tree**      | Struktur modul kursus bisa dikembangkan ke nested tree jika ada sub-materi   |
| **Graph**     | Hubungan antar siswa-kursus bisa divisualisasikan dalam graf jaringan        |
| **MVC**       | Laravel native support: Model, View (Filament), Controller (Pages)           |
| **Search**    | Filament menyediakan fitur `->searchable()` di tabel dan form                |

---

## 📊 Widget Statistik – EnrollmentChart

Menampilkan jumlah murid per kursus dalam bentuk bar chart.

### Contoh Kode:
```php
protected function getData(): array
{
    $data = Enrollment::select('courses.title', DB::raw('count(*) as total'))
        ->join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->groupBy('courses.title')
        ->pluck('total', 'title');

    return [
        'datasets' => [
            [
                'label' => 'Jumlah Enroll',
                'data' => $data->values(),
            ],
        ],
        'labels' => $data->keys(),
    ];
}
