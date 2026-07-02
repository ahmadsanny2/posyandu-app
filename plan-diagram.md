# PERENCANAAN DIAGRAM MVP - WEB POSYANDU

Dokumen ini berisi rancangan perancangan perangkat lunak menggunakan arsitektur **Boundary-Control-Entity (BCE)** untuk modul Minimum Viable Product (MVP) proyek Web Posyandu. 

Agar diagram kelas (Class Diagram) tidak terlalu padat dan tulisan di dalamnya tetap terbaca dengan jelas saat dimasukkan ke dalam **Laporan PKL/Skripsi**, rancangan diagram kelas ini dibagi secara modular per modul fitur.

---

## 1. Lingkup Fitur MVP (Hasil Analisis Codebase)
Berdasarkan hasil pemindaian kode pada struktur Model, Controller, dan Routes, lingkup fitur MVP meliputi:
1. **Autentikasi & Manajemen Profil**: Proses masuk (login) dan pengelolaan data profil pengguna.
2. **Kelola Data Pengguna (Kader & Orang Tua)**: Administrasi akun Kader dan akun Orang Tua (Parent) oleh Admin.
3. **Kelola Data Sasaran (Balita, Ibu Hamil, Lansia)**: Manajemen pendaftaran dan pembaruan data balita, ibu hamil, dan lansia.
4. **Kelola Jadwal & Kehadiran (RSVP)**: Pembuatan jadwal kegiatan posyandu dan pengisian RSVP oleh orang tua.
5. **Pencatatan Layanan/Rekam Medis Bulanan**:
   - Pengukuran & Imunisasi Balita (`toddler_measurements`).
   - Rekam Medis Kehamilan Ibu Hamil (`pregnancy_records`).
   - Rekam Medis Pemeriksaan Lansia (`elderly_records`).

---

## 2. Perencanaan Class Diagram (Modular per Modul)

### A. Class Diagram Modul 1: Autentikasi & Profil Pengguna
Diagram ini memetakan kelas antarmuka login, manajemen profil, controller terkait, dan entitas user.

```mermaid
classDiagram
    class v_login {
        <<boundary>>
        +view_login()
    }
    class v_profile {
        <<boundary>>
        +view_profile_edit()
    }
    class c_auth {
        <<control>>
        +login()
        +logout()
    }
    class c_profile {
        <<control>>
        +edit()
        +update()
        +destroy()
    }
    class m_user {
        <<entity>>
        +id
        +name
        +email
        +password
        +role
        +insert()
        +update()
        +delete()
        +get_all()
        +get_by_id()
    }

    v_login --> c_auth
    v_profile --> c_profile
    c_auth --> m_user
    c_profile --> m_user
```

---

### B. Class Diagram Modul 2: Kelola Pengguna (Kader & Orang Tua)
Diagram ini memetakan kelola data akun petugas posyandu (Kader) dan akun Orang Tua (Parent) oleh Admin.

```mermaid
classDiagram
    class v_tampil_kader {
        <<boundary>>
        +view_tampil_kader()
    }
    class v_tambah_kader {
        <<boundary>>
        +view_tambah_kader()
    }
    class v_edit_kader {
        <<boundary>>
        +view_edit_kader()
    }
    class v_tampil_parent {
        <<boundary>>
        +view_tampil_parent()
    }
    class v_tambah_parent {
        <<boundary>>
        +view_tambah_parent()
    }
    class v_edit_parent {
        <<boundary>>
        +view_edit_parent()
    }
    class c_kader {
        <<control>>
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
    }
    class c_parent {
        <<control>>
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
    }
    class m_user {
        <<entity>>
        +id
        +name
        +email
        +role
        +insert()
        +update()
        +delete()
        +get_all()
        +get_by_id()
    }

    v_tampil_kader --> c_kader
    v_tambah_kader --> c_kader
    v_edit_kader --> c_kader
    v_tampil_parent --> c_parent
    v_tambah_parent --> c_parent
    v_edit_parent --> c_parent
    c_kader --> m_user
    c_parent --> m_user
```

---

### C. Class Diagram Modul 3: Kelola Data Balita & Pencatatan Pengukuran
Diagram ini memetakan antarmuka pendaftaran balita, form rekam medis pengukuran/imunisasi, beserta controller dan model terkait.

```mermaid
classDiagram
    class v_tampil_toddler {
        <<boundary>>
        +view_tampil_toddler()
    }
    class v_tambah_toddler {
        <<boundary>>
        +view_tambah_toddler()
    }
    class v_edit_toddler {
        <<boundary>>
        +view_edit_toddler()
    }
    class v_tambah_toddler_measure {
        <<boundary>>
        +view_tambah_toddler_measure()
    }
    class c_toddler {
        <<control>>
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
    }
    class c_toddler_measurement {
        <<control>>
        +create()
        +store()
    }
    class m_toddler {
        <<entity>>
        +id
        +user_id
        +name
        +birth_date
        +gender
        +insert()
        +update()
        +delete()
    }
    class m_toddler_measurement {
        <<entity>>
        +id
        +toddler_id
        +schedule_id
        +weight_kg
        +height_cm
        +head_circumference_cm
        +immunization_type
        +insert()
    }

    v_tampil_toddler --> c_toddler
    v_tambah_toddler --> c_toddler
    v_edit_toddler --> c_toddler
    v_tambah_toddler_measure --> c_toddler_measurement
    c_toddler --> m_toddler
    c_toddler_measurement --> m_toddler_measurement
    m_toddler "1" -- "0..*" m_toddler_measurement
```

---

### D. Class Diagram Modul 4: Kelola Data Ibu Hamil & Rekam Medis Kehamilan
Diagram ini memetakan pengelolaan data ibu hamil beserta rekam medis kehamilan (tekanan darah, DJJ, dsb).

```mermaid
classDiagram
    class v_tampil_pregnant {
        <<boundary>>
        +view_tampil_pregnant()
    }
    class v_tambah_pregnant {
        <<boundary>>
        +view_tambah_pregnant()
    }
    class v_edit_pregnant {
        <<boundary>>
        +view_edit_pregnant()
    }
    class v_tambah_pregnancy_record {
        <<boundary>>
        +view_tambah_pregnancy_record()
    }
    class c_pregnant {
        <<control>>
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
    }
    class c_pregnancy_record {
        <<control>>
        +create()
        +store()
    }
    class m_pregnant_woman {
        <<entity>>
        +id
        +user_id
        +name
        +pregnancy_age_weeks
        +insert()
        +update()
        +delete()
    }
    class m_pregnancy_record {
        <<entity>>
        +id
        +pregnant_woman_id
        +schedule_id
        +weight_kg
        +blood_pressure
        +upper_arm_circumference_cm
        +gestational_age_weeks
        +fetal_heart_rate
        +insert()
    }

    v_tampil_pregnant --> c_pregnant
    v_tambah_pregnant --> c_pregnant
    v_edit_pregnant --> c_pregnant
    v_tambah_pregnancy_record --> c_pregnancy_record
    c_pregnant --> m_pregnant_woman
    c_pregnancy_record --> m_pregnancy_record
    m_pregnant_woman "1" -- "0..*" m_pregnancy_record
```

---

### E. Class Diagram Modul 5: Kelola Data Lansia & Rekam Medis Lansia
Diagram ini memetakan pengelolaan data pemeriksaan berkala untuk kelompok lanjut usia (Lansia).

```mermaid
classDiagram
    class v_tampil_elderly {
        <<boundary>>
        +view_tampil_elderly()
    }
    class v_tambah_elderly {
        <<boundary>>
        +view_tambah_elderly()
    }
    class v_edit_elderly {
        <<boundary>>
        +view_edit_elderly()
    }
    class v_tambah_elderly_record {
        <<boundary>>
        +view_tambah_elderly_record()
    }
    class c_elderly {
        <<control>>
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
    }
    class c_elderly_record {
        <<control>>
        +create()
        +store()
    }
    class m_elderly {
        <<entity>>
        +id
        +user_id
        +name
        +birth_date
        +insert()
        +update()
        +delete()
    }
    class m_elderly_record {
        <<entity>>
        +id
        +elderly_id
        +schedule_id
        +weight_kg
        +blood_pressure
        +blood_sugar
        +cholesterol
        +uric_acid
        +insert()
    }

    v_tampil_elderly --> c_elderly
    v_tambah_elderly --> c_elderly
    v_edit_elderly --> c_elderly
    v_tambah_elderly_record --> c_elderly_record
    c_elderly --> m_elderly
    c_elderly_record --> m_elderly_record
    m_elderly "1" -- "0..*" m_elderly_record
```

---

### F. Class Diagram Modul 6: Kelola Jadwal & Kehadiran (RSVP)
Diagram ini memetakan pembuatan jadwal posyandu serta pencatatan RSVP/kehadiran oleh orang tua.

```mermaid
classDiagram
    class v_tampil_schedule {
        <<boundary>>
        +view_tampil_schedule()
    }
    class v_tambah_schedule {
        <<boundary>>
        +view_tambah_schedule()
    }
    class v_edit_schedule {
        <<boundary>>
        +view_edit_schedule()
    }
    class c_schedule {
        <<control>>
        +index()
        +create()
        +store()
        +edit()
        +update()
        +destroy()
        +rsvp()
    }
    class m_schedule {
        <<entity>>
        +id
        +title
        +target_type
        +scheduled_at
        +location
        +insert()
        +update()
        +delete()
    }
    class m_attendance {
        <<entity>>
        +id
        +schedule_id
        +user_id
        +is_present
        +notes
        +insert()
        +updateOrCreate()
    }
    class m_user {
        <<entity>>
        +id
        +name
        +role
    }

    v_tampil_schedule --> c_schedule
    v_tambah_schedule --> c_schedule
    v_edit_schedule --> c_schedule
    c_schedule --> m_schedule
    c_schedule --> m_attendance
    m_schedule "1" -- "0..*" m_attendance
    m_user "1" -- "0..*" m_attendance
```

---

## 3. Perencanaan Sequence Diagram (BCE Pattern)

### A. Sequence Diagram Autentikasi: Login Pengguna
Menggambarkan alur masuk pengguna ke dalam sistem posyandu.

```mermaid
sequenceDiagram
    actor User as Pengguna
    participant Boundary as v_login
    participant Control as c_auth
    participant Entity as m_user

    User->>Boundary: Masukkan email & password
    User->>Boundary: klik tombol Login
    Boundary->>Control: login()
    Control->>Entity: get_by_id()
    Entity-->>Control: data user & hash password
    Control->>Control: Verifikasi password
    Control->>Boundary: Redirect ke Dashboard (Success)
```

---

### B. Sequence Diagram Kelola Data Balita: Tambah Data Balita
Menggambarkan alur pendaftaran data balita oleh Kader atau Orang Tua.

```mermaid
sequenceDiagram
    actor Kader as Kader / Parent
    participant Boundary as v_tambah_toddler
    participant Control as c_toddler
    participant Entity as m_toddler

    Kader->>Control: create()
    Control->>Boundary: create()
    Kader->>Boundary: Isi data balita (Nama, Tgl Lahir, dsb)
    Kader->>Boundary: klik tombol Simpan
    Boundary->>Control: store()
    Control->>Entity: insert()
    Entity-->>Control: success
    Control->>Control: index() (Redirect ke daftar balita)
```

---

### C. Sequence Diagram Kelola Data Balita: Edit Data Balita
Menggambarkan alur pembaruan data balita yang sudah terdaftar.

```mermaid
sequenceDiagram
    actor Kader as Kader / Parent
    participant Boundary as v_edit_toddler
    participant Control as c_toddler
    participant Entity as m_toddler

    Kader->>Control: edit()
    Control->>Entity: get_by_id()
    Entity-->>Control: data balita
    Control->>Boundary: edit() (Tampilkan form terisi)
    Kader->>Boundary: Ubah data balita
    Kader->>Boundary: klik tombol Perbarui
    Boundary->>Control: update()
    Control->>Entity: update()
    Entity-->>Control: success
    Control->>Control: index() (Redirect ke daftar balita)
```

---

### D. Sequence Diagram Kelola Data Balita: Hapus Data Balita
Menggambarkan alur penghapusan data balita dari sistem.

```mermaid
sequenceDiagram
    actor Kader as Kader / Parent
    participant Boundary as v_tampil_toddler
    participant Control as c_toddler
    participant Entity as m_toddler

    Kader->>Boundary: klik tombol Hapus
    Boundary->>Control: destroy()
    Control->>Entity: get_by_id()
    Control->>Entity: delete()
    Entity-->>Control: success
    Control->>Control: index() (Redirect ke daftar balita)
```

---

### E. Sequence Diagram Kelola Ibu Hamil: Tambah Data Ibu Hamil
Menggambarkan alur pendaftaran Ibu Hamil baru ke dalam sistem.

```mermaid
sequenceDiagram
    actor Kader as Kader
    participant Boundary as v_tambah_pregnant
    participant Control as c_pregnant
    participant Entity as m_pregnant_woman

    Kader->>Control: create()
    Control->>Boundary: create()
    Kader->>Boundary: Isi data Ibu Hamil
    Kader->>Boundary: klik tombol Simpan
    Boundary->>Control: store()
    Control->>Entity: insert()
    Entity-->>Control: success
    Control->>Control: index() (Redirect)
```

---

### F. Sequence Diagram Kelola Lansia: Tambah Data Lansia
Menggambarkan alur pendaftaran Lansia baru ke dalam sistem.

```mermaid
sequenceDiagram
    actor Kader as Kader
    participant Boundary as v_tambah_elderly
    participant Control as c_elderly
    participant Entity as m_elderly

    Kader->>Control: create()
    Control->>Boundary: create()
    Kader->>Boundary: Isi data Lansia
    Kader->>Boundary: klik tombol Simpan
    Boundary->>Control: store()
    Control->>Entity: insert()
    Entity-->>Control: success
    Control->>Control: index() (Redirect)
```

---

### G. Sequence Diagram RSVP Jadwal Posyandu
Menggambarkan alur Orang Tua melakukan RSVP kehadiran pada jadwal kegiatan.

```mermaid
sequenceDiagram
    actor Parent as Orang Tua (Parent)
    participant Boundary as v_tampil_schedule
    participant Control as c_schedule
    participant Entity as m_attendance

    Parent->>Boundary: Pilih opsi kehadiran (Hadir/Tidak) & Catatan
    Parent->>Boundary: klik tombol RSVP
    Boundary->>Control: rsvp()
    Control->>Entity: updateOrCreate()
    Entity-->>Control: success
    Control->>Boundary: Tampilkan pesan RSVP Berhasil
```

---

### H. Sequence Diagram Rekam Medis: Pencatatan Pengukuran & Imunisasi Balita
Menggambarkan alur pencatatan pengukuran fisik dan imunisasi balita saat kegiatan posyandu.

```mermaid
sequenceDiagram
    actor Kader as Kader / Admin
    participant Boundary as v_tambah_toddler_measure
    participant Control as c_toddler_measurement
    participant Entity as m_toddler_measurement

    Kader->>Control: create()
    Control->>Boundary: create()
    Kader->>Boundary: Isi berat, tinggi, lingkar kepala, jenis imunisasi
    Kader->>Boundary: klik tombol Simpan
    Boundary->>Control: store()
    Control->>Entity: insert()
    Entity-->>Control: success
    Control->>Control: Redirect ke Detail Jadwal
```

---

### I. Sequence Diagram Rekam Medis: Pencatatan Kesehatan Ibu Hamil
Menggambarkan alur pencatatan rekam medis Ibu Hamil saat kegiatan posyandu.

```mermaid
sequenceDiagram
    actor Kader as Kader / Admin
    participant Boundary as v_tambah_pregnancy_record
    participant Control as c_pregnancy_record
    participant Entity as m_pregnancy_record

    Kader->>Control: create()
    Control->>Boundary: create()
    Kader->>Boundary: Isi tensi darah, lingkar lengan, DJJ janin, dsb
    Kader->>Boundary: klik tombol Simpan
    Boundary->>Control: store()
    Control->>Entity: insert()
    Entity-->>Control: success
    Control->>Control: Redirect ke Detail Jadwal
```

---

### J. Sequence Diagram Rekam Medis: Pencatatan Kesehatan Lansia
Menggambarkan alur pemeriksaan dan pencatatan kesehatan lansia saat kegiatan posyandu.

```mermaid
sequenceDiagram
    actor Kader as Kader / Admin
    participant Boundary as v_tambah_elderly_record
    participant Control as c_elderly_record
    participant Entity as m_elderly_record

    Kader->>Control: create()
    Control->>Boundary: create()
    Kader->>Boundary: Isi berat, tensi, gula darah, kolesterol, asam urat
    Kader->>Boundary: klik tombol Simpan
    Boundary->>Control: store()
    Control->>Entity: insert()
    Entity-->>Control: success
    Control->>Control: Redirect ke Detail Jadwal
```
