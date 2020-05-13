# CIA HMVC
Code Igniter Automation - Modular HMVC

## Informasi
PHP Framework CI v3 dengan template AdminLTE v3 + Bootstrap 4 dan ACL module dari Ion Auth serta CRUD Generator.

## Initial - 14/5/2020
1. Update latest `CodeIgniter 3 HMVC` support `php v7.2`.
2. Integrasi dengan `ADMIN LTE v3` dan `Bootstrap v4`.
2. Integrasi dengan `Google OAuth2 / Login via Google Account`.
4. `Registrasi` dan `Aktivasi` baik manual dari `admin` atau pada saat `Login via Google`.
5. Integrasi `Notifikasi Email` via `sendmail`.
6. Generate manual `Kode Aktivasi` atau via `Email`.
7. Sidebar `dinamis` support `active link`.
8. Modul `Profile User` termasuk `Image Upload`.
10. Alert & Modal default dari `Bootstrap 4`.

## Informasi Lain
1. PHP Framework menggunakan `CodeIgniter 3 HMVC`.
2. Dashboard Template menggunakan `AdminLTE 3`.
3. Access Control Login menggunakan `Ion Auth`.
4. Kostumisasi `Ion Auth`:
    * CRUD user
    * CRUD group
    * Identity Login by `username` atau `email`.
4. `CRUD` kostumisasi dari `Harviacode`.
5. Kustomisasi `Harviacode`:
    * Exclude nama tabel `users`, `groups`, `users_groups` dan `menu` pada menu `Select Table`.
    * Set default generator folder pada `./application/modules/`.
    * Tambah fungsi `Is Admin` pada semua file MVC, limitasi hanya bisa diakses oleh group `admin`.
    * Tambah fungsi `title` dan `description` pada setiap `View` dan `Breadcrumbs`.
    * Default `View` menggunakan `Datatables Bootstrap 4` template.
6. Database dump ada di folder `sql dump`.
7. Konfigurasi Google `api key` dan `secret key` di folder modul `auth\config.php`.
8. Konfigurasi `email` di folder modul `auth\email.php`.

## Akses Login
Akses login default :
* Username : `admin` atau `stikom@unbin.ac.id`.
* Password : `password`.

## Penutup
Semoga bermanfaat.