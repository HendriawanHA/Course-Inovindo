# Blackbox Testing Admin dan Instruktur

## Tujuan Pengujian

Pengujian blackbox dilakukan untuk memastikan fitur pada role Admin dan Instruktur berjalan sesuai kebutuhan, hak akses sesuai dengan role pengguna, validasi form berjalan dengan benar, serta tidak terjadi akses data yang tidak sah antar role.

## Lingkungan Pengujian

| Item | Keterangan |
|---|---|
| Aplikasi | Inovindo Academy |
| Jenis Pengujian | Blackbox Testing |
| Role yang Diuji | Admin dan Instruktur |
| Browser | Google Chrome / Microsoft Edge |
| Metode | Manual Testing |
| Status | Pass / Fail |

## Data Akun Pengujian

| Role | Email | Password | Keterangan |
|---|---|---|---|
| Admin | admin@example.com | password | Akun admin |
| Instruktur A | instructor-a@example.com | password | Instruktur pemilik course A |
| Instruktur B | instructor-b@example.com | password | Instruktur pemilik course B |
| Student | student@example.com | password | Akun siswa |
| Guest | - | - | Pengguna belum login |

## Tabel Blackbox Testing Admin

| ID | Fitur | Skenario Pengujian | Langkah Pengujian | Expected Result | Actual Result | Status |
|---|---|---|---|---|---|---|
| ADM-001 | Login | Admin login dengan akun valid | Buka halaman login, masukkan email dan password admin, klik login | Admin berhasil login dan diarahkan ke `/admin` |  |  |
| ADM-002 | Login | Admin login dengan password salah | Masukkan email admin dan password salah | Sistem menolak login dan menampilkan pesan error |  |  |
| ADM-003 | Dashboard Admin | Admin membuka dashboard admin | Login sebagai admin lalu buka `/admin` | Dashboard admin berhasil ditampilkan |  |  |
| ADM-004 | Course | Admin membuka daftar course | Buka menu Courses di panel admin | Daftar course berhasil ditampilkan |  |  |
| ADM-005 | Course | Admin menambah course baru | Klik Create Course, isi data course, pilih instructor, simpan | Course berhasil dibuat |  |  |
| ADM-006 | Course | Admin menambah course tanpa instructor | Isi form course tanpa memilih instructor, lalu simpan | Sistem menolak penyimpanan dan menampilkan validasi instructor wajib diisi |  |  |
| ADM-007 | Course | Admin mengedit course | Pilih course, ubah judul/deskripsi/harga, lalu simpan | Data course berhasil diperbarui |  |  |
| ADM-008 | Course | Admin menghapus course | Pilih course, klik delete, konfirmasi | Course berhasil dihapus |  |  |
| ADM-009 | Course | Admin upload thumbnail valid | Upload file JPG/PNG/WebP pada form course | Thumbnail berhasil diupload |  |  |
| ADM-010 | Course | Admin upload thumbnail tidak valid | Upload file selain gambar | Sistem menolak file dan menampilkan pesan validasi |  |  |
| ADM-011 | Course | Admin mengubah status publish | Aktifkan/nonaktifkan publish course lalu simpan | Status publish course berhasil berubah |  |  |
| ADM-012 | Instructor | Admin membuka daftar instructor | Buka menu Instructors | Daftar instructor berhasil ditampilkan |  |  |
| ADM-013 | Instructor | Admin menambah instructor | Isi nama, email, password instructor, lalu simpan | Instructor baru berhasil dibuat |  |  |
| ADM-014 | Instructor | Admin menambah instructor dengan email duplikat | Gunakan email yang sudah terdaftar | Sistem menolak dan menampilkan validasi email sudah digunakan |  |  |
| ADM-015 | Instructor | Admin mengedit instructor | Ubah data instructor lalu simpan | Data instructor berhasil diperbarui |  |  |
| ADM-016 | Student | Admin membuka daftar student | Buka menu Students | Daftar student berhasil ditampilkan |  |  |
| ADM-017 | Student | Admin menambah student | Isi nama, email, password student, lalu simpan | Student baru berhasil dibuat |  |  |
| ADM-018 | Student | Admin mengedit student | Ubah data student lalu simpan | Data student berhasil diperbarui |  |  |
| ADM-019 | Transaction | Admin membuka daftar transaksi | Buka menu Transactions | Daftar transaksi berhasil ditampilkan |  |  |
| ADM-020 | Transaction | Admin membuat transaksi | Isi student, course, invoice, amount, status, lalu simpan | Transaksi berhasil dibuat |  |  |
| ADM-021 | Transaction | Admin menandai transaksi pending menjadi paid | Klik action Mark as Paid pada transaksi pending | Status transaksi berubah menjadi paid dan student ter-enroll ke course |  |  |
| ADM-022 | Transaction | Admin mengedit status transaksi | Ubah status transaksi lalu simpan | Status transaksi berhasil diperbarui |  |  |
| ADM-023 | Event | Admin membuka daftar event | Buka menu Events | Daftar event berhasil ditampilkan |  |  |
| ADM-024 | Event | Admin menambah event | Isi data event lalu simpan | Event berhasil dibuat |  |  |
| ADM-025 | Event | Admin mengedit event | Ubah data event lalu simpan | Event berhasil diperbarui |  |  |
| ADM-026 | Event | Admin menghapus event | Pilih event lalu hapus | Event berhasil dihapus |  |  |
| ADM-027 | Logout | Admin logout | Klik logout | Admin berhasil logout dan diarahkan ke halaman login |  |  |

## Tabel Blackbox Testing Instruktur

| ID | Fitur | Skenario Pengujian | Langkah Pengujian | Expected Result | Actual Result | Status |
|---|---|---|---|---|---|---|
| INS-001 | Login | Instruktur login dengan akun valid | Buka halaman login, masukkan email dan password instructor | Instruktur berhasil login dan diarahkan ke `/instructor` |  |  |
| INS-002 | Login | Instruktur login dengan password salah | Masukkan email instructor dan password salah | Sistem menolak login dan menampilkan pesan error |  |  |
| INS-003 | Dashboard | Instruktur membuka dashboard | Login sebagai instructor lalu buka `/instructor` | Dashboard instructor berhasil ditampilkan |  |  |
| INS-004 | Dashboard | Menampilkan statistik course | Buka dashboard instructor | Jumlah course sesuai dengan course milik instructor tersebut |  |  |
| INS-005 | Dashboard | Menampilkan jumlah student | Pastikan ada enrollment aktif/completed pada course instructor | Jumlah student tampil sesuai data enrollment |  |  |
| INS-006 | Dashboard | Menampilkan jumlah lesson | Pastikan course memiliki module dan lesson | Jumlah lesson tampil sesuai data |  |  |
| INS-007 | Dashboard | Menampilkan diskusi belum dibalas | Student membuat diskusi pada course instructor | Dashboard menampilkan jumlah diskusi belum dibalas |  |  |
| INS-008 | Course | Instruktur membuka daftar course | Buka menu Courses | Hanya course milik instructor tersebut yang tampil |  |  |
| INS-009 | Course | Instruktur membuat course baru | Klik New Course, isi data course, lalu simpan | Course berhasil dibuat sebagai draft |  |  |
| INS-010 | Course | Instruktur membuat course tanpa judul | Kosongkan judul course lalu simpan | Sistem menolak dan menampilkan validasi judul wajib diisi |  |  |
| INS-011 | Course | Instruktur mengedit course miliknya | Pilih course milik sendiri, ubah data, lalu simpan | Course berhasil diperbarui |  |  |
| INS-012 | Course | Instruktur upload thumbnail valid | Upload file gambar JPG/PNG/WebP | Thumbnail berhasil diupload |  |  |
| INS-013 | Course | Instruktur upload thumbnail tidak valid | Upload file selain gambar | Sistem menolak file upload |  |  |
| INS-014 | Course | Instruktur publish course tanpa thumbnail | Aktifkan publish pada course tanpa thumbnail | Sistem menolak publish dan menampilkan validasi thumbnail wajib diisi |  |  |
| INS-015 | Course | Instruktur publish course tanpa lesson | Aktifkan publish pada course tanpa lesson | Sistem menolak publish dan menampilkan validasi minimal 1 lesson |  |  |
| INS-016 | Course | Instruktur publish course valid | Course memiliki thumbnail dan minimal 1 lesson, aktifkan publish | Course berhasil dipublish |  |  |
| INS-017 | Module | Instruktur menambah module | Buka edit course, tambah module, isi judul module | Module berhasil ditambahkan |  |  |
| INS-018 | Module | Instruktur menambah module tanpa judul | Kosongkan judul module lalu simpan | Sistem menolak dan menampilkan validasi |  |  |
| INS-019 | Module | Instruktur menghapus module | Klik hapus pada module | Module dan lesson terkait berhasil dihapus |  |  |
| INS-020 | Lesson | Instruktur menambah lesson | Buka module, tambah lesson, isi judul dan video URL | Lesson berhasil ditambahkan |  |  |
| INS-021 | Lesson | Instruktur menambah lesson tanpa judul | Kosongkan judul lesson lalu simpan | Sistem menolak dan menampilkan validasi judul lesson wajib diisi |  |  |
| INS-022 | Lesson | Instruktur menghapus lesson | Klik hapus pada lesson | Lesson berhasil dihapus |  |  |
| INS-023 | Preview | Instruktur preview course miliknya | Klik preview pada course milik sendiri | Preview course berhasil ditampilkan |  |  |
| INS-024 | Student | Instruktur membuka daftar student | Buka menu Students | Daftar student yang enroll pada course instructor tampil |  |  |
| INS-025 | Student | Instruktur melihat student course sendiri | Pastikan student enroll pada course instructor | Student tampil pada daftar student |  |  |
| INS-026 | Discussion | Instruktur membuka daftar diskusi | Buka menu Discussions | Diskusi pada course instructor tampil |  |  |
| INS-027 | Discussion | Instruktur membuka diskusi per course | Pilih course pada halaman diskusi | Diskusi untuk course tersebut berhasil ditampilkan |  |  |
| INS-028 | Discussion | Instruktur membalas diskusi | Isi balasan diskusi lalu kirim | Balasan berhasil dikirim |  |  |
| INS-029 | Discussion | Instruktur mengirim balasan kosong | Kosongkan isi balasan lalu kirim | Sistem menolak dan menampilkan validasi isi wajib diisi |  |  |
| INS-030 | Profile | Instruktur membuka halaman profile | Buka menu Profile | Halaman profile berhasil ditampilkan |  |  |
| INS-031 | Profile | Instruktur mengubah profile | Ubah nama/headline/bio lalu simpan | Data profile berhasil diperbarui |  |  |
| INS-032 | Logout | Instruktur logout | Klik logout | Instruktur berhasil logout dan diarahkan ke halaman login |  |  |

## Tabel Blackbox Testing Akses dan Keamanan

| ID | Role | Skenario Pengujian | Langkah Pengujian | Expected Result | Actual Result | Status |
|---|---|---|---|---|---|---|
| SEC-001 | Guest | Guest membuka `/admin` | Buka `/admin` tanpa login | Sistem mengarahkan ke halaman login |  |  |
| SEC-002 | Guest | Guest membuka `/instructor` | Buka `/instructor` tanpa login | Sistem mengarahkan ke halaman login |  |  |
| SEC-003 | Student | Student membuka `/admin` | Login sebagai student lalu buka `/admin` | Akses ditolak |  |  |
| SEC-004 | Student | Student membuka `/instructor` | Login sebagai student lalu buka `/instructor` | Akses ditolak |  |  |
| SEC-005 | Instruktur | Instruktur membuka `/admin` | Login sebagai instructor lalu buka `/admin` | Akses ditolak / 403 |  |  |
| SEC-006 | Admin | Admin membuka `/admin` | Login sebagai admin lalu buka `/admin` | Admin panel berhasil ditampilkan |  |  |
| SEC-007 | Admin | Admin membuka `/instructor` | Login sebagai admin lalu buka `/instructor` | Akses ditolak jika route instructor hanya untuk instructor |  |  |
| SEC-008 | Instruktur A | Instruktur A membuka edit course milik Instruktur B | Login sebagai Instruktur A, akses URL edit course milik Instruktur B | Akses ditolak / 403 |  |  |
| SEC-009 | Instruktur A | Instruktur A preview course milik Instruktur B | Login sebagai Instruktur A, akses URL preview course milik Instruktur B | Akses ditolak / 403 |  |  |
| SEC-010 | Instruktur A | Instruktur A membuka diskusi course milik Instruktur B | Akses URL diskusi course milik Instruktur B | Akses ditolak / 403 |  |  |
| SEC-011 | Instruktur A | Instruktur A membalas diskusi course milik Instruktur B | Kirim reply ke discussion milik course Instruktur B | Akses ditolak / 403 |  |  |
| SEC-012 | Instruktur B | Instruktur B tidak melihat course Instruktur A | Login sebagai Instruktur B, buka daftar course | Course Instruktur A tidak tampil |  |  |
| SEC-013 | Instruktur B | Instruktur B tidak melihat student course Instruktur A | Login sebagai Instruktur B, buka daftar student | Student dari course Instruktur A tidak tampil |  |  |
| SEC-014 | Instruktur B | Instruktur B tidak melihat diskusi course Instruktur A | Login sebagai Instruktur B, buka diskusi | Diskusi course Instruktur A tidak tampil |  |  |

## Kriteria Kelulusan

| No | Kriteria |
|---|---|
| 1 | Admin dapat mengakses panel admin dan mengelola data sesuai hak aksesnya |
| 2 | Instruktur hanya dapat mengakses dashboard instructor |
| 3 | Instruktur tidak dapat mengakses panel admin |
| 4 | Instruktur hanya dapat melihat dan mengelola course miliknya sendiri |
| 5 | Validasi form berjalan pada input kosong atau tidak valid |
| 6 | Statistik dashboard instructor sesuai dengan data course, lesson, enrollment, dan diskusi |
| 7 | Tidak ada error 500 selama pengujian |
| 8 | Guest dan role yang tidak berhak tidak dapat mengakses halaman terbatas |
| 9 | Admin tetap dapat menambah course melalui panel admin sebagai backup |
| 10 | Proses logout berhasil untuk admin dan instruktur |

## Kesimpulan Pengujian

Berdasarkan hasil blackbox testing, fitur Admin dan Instruktur dinyatakan berjalan dengan baik apabila seluruh skenario utama mendapatkan status Pass, tidak terdapat pelanggaran akses antar role, serta seluruh validasi form berjalan sesuai expected result.
