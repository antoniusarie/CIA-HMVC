# CIA HMVC
Code Igniter Automation - Modular HMVC - v1.12

## Informasi
PHP Framework CI v3 dengan template AdminLTE v3 + Bootstrap 4 dan ACL module dari Ion Auth serta CRUD Generator.

## Update - 02/06/2020
1. Notifikasi alert menggunakan `Toastr`.
2. Input `file-upload` menggunakan `bs-custom-file-input`.
3. Fix path folder module di controller `Crud`.
4. Tambah `table class w-100` pada `controller generator` di module core `CRUD`.
5. Tambah pilihan `iconpicker` di menu `CRUD`.
6. Tambah fungsi `trim_str` dan `toastr` di `my_helper`.
7. Sidebar set ke tipe `nav-flat`, warna accent, navbar, logo dan sidebar set ke `dark / gray-dark`.
8. Font Family menggunakan Google Font `Oxygen`.
9. `DataTables Buttons` ditambah `colvis` dan `print`, `ExportOption` di set hanya pada kolom yg `visible` saja.

## Initial - 14/5/2020
1. Update latest `CodeIgniter 3 HMVC` support `php v7.2`.
2. Integrasi dengan `ADMIN LTE v3` dan `Bootstrap v4`.
3. Integrasi dengan `Google OAuth2 / Login via Google Account`.
4. `Registrasi` dan `Aktivasi` baik manual dari `admin` atau pada saat `Login via Google`.
5. Integrasi `Notifikasi Email` via `sendmail` atau `PHPMailer`.
6. Generate manual `Kode Aktivasi` atau via `Email`.
7. Sidebar `dinamis` support `active link`.
8. Modul `Profile User` termasuk `Image Upload`.
9. Alert & Modal default dari `Bootstrap 4`.

## Informasi Lain
1. PHP Framework menggunakan `CodeIgniter 3 HMVC`.
2. Dashboard Template menggunakan `AdminLTE 3`.
3. Access Control Login menggunakan `Ion Auth`.
4. Kostumisasi `Ion Auth`:
    * CRUD user
    * CRUD group
    * Identity Login by `username` atau `email`.
5. `CRUD` kostumisasi dari `Harviacode`.
6. Kustomisasi `Harviacode`:
    * Exclude nama tabel `users`, `groups`, `users_groups` dan `menu` pada menu `Select Table`.
    * Set default generator folder pada `./application/modules/`.
    * Tambah variabel `title` dan `description` pada setiap `View` dan `Breadcrumbs`.
    * Default `View` menggunakan `Datatables Bootstrap 4` template.
7. Database dump `cia-hmvc.sql` ada di folder `sql`.
8. Konfigurasi Google `client-id` dan `client-secret` di `google_config.php`.
9. Konfigurasi Email di `email.php`.

## Akses Login
Akses login default :
* Username : `admin` atau `stikom@unbin.ac.id`.
* Password : `password`.

## Instalasi
1. Clone repo di webserver
2. Buat database, sesuaikan konfigurasi-nya pada `database.php` pada folder `application/config/`.
3. Query SQL `cia-hmvc.sql` yang ada di folder `sql`.
4. Agar CRUD berfungsi normal, set recursive `permission` 777 pada folder `application/modules/`.
```
chmod -R 0777 /path-ke-folder-webserver/application/modules/
```
5. Sesuaikan konfigurasi pada folder `application/modules/auth/config/`.
    * Agar pengiriman email berfungsi normal, sesuaikan konfigurasi `username email` dan `password ` di `email.php`.
    * Agar `Google Login OAuth2` berfungsi normal, sesuaikan konfigurasi `client-id` dan `client-secret` di `google_config.php`

## Demo
Demo website di https://hmvc.binaniaga.web.id

## Penutup
Semoga bermanfaat.