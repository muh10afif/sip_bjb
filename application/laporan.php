Report 23/07/2019

Nama Project : REI - TRUST
Tahapan : Build
Detail :

1. Memperbaiki view v_detail:
- Menambahkan javascript untuk menampilkan total investasi menggunkan separator
2. Memperbaiki view v_unit:
- Menambahkan button investasi
- Membuat kondisi bila telah investasi
3. Memperbaiki view template, menambahkan session disetiap menu 
4. Memperbaiki query untuk menampilkan data transaksi koperasi

Progress : 78%

Report 24/07/2019

Nama Project : SIP-BJB Interasi 1.1
Tahapan : Build
Detail :

1. Membuat halaman preview bukti kunjungan
2. Memperbaiki fungsi bukti_kunjungan controller monitoring
3. Memperbaiki view monitoring_debitur

Progress : 100%

Nama Project : A - CARE Iterasi 1.1
Tahapan : Build
Detail :

1. Memperbaiki tampilan katalog aset ketika data katalog kosong
2. Memperbaiki tampilan form tambah data aset
3. Memperbaiki tampilan home 
4. Memperbaiki query untuk menampilkan foto favorit:
- memberikan kondisi bila data kosong, data hanya satu maupun banyak foto
5. Memperbaiki tampilan template

Progress : 100%

Report 9/07/2019

Nama Project : SIP-BJB Interasi 1.1
Tahapan : Build
Detail :

1. Membuat bukti kunjungan:
- Membuat view v_word untuk npl dan ao
2. Memperbaiki tampilan template bjb:
- tampilan menu pada template
3. Membuat kondisi jika username sudah ada pada tabel pengguna
4. Memperbaiki fungsi auth untuk login:
- memanggil api untuk mengecek password pada tabel pengguna
5. Menampilkan data unuk kelolaan debitur pada level user
6. Membuat kondisi untuk level user atau level yang lain, menampilkan redirect data

Progress : 100%

Report 10/07/2019

Nama Project : R-CARE Interasi 1.1
Tahapan : Build
Detail :

1. Membuat tampilan dashboard:
- Merubah view v_home
2. Memperbaiki fungsi index pada controller home:
- Membuat kondisi untuk proses data bila cari bank, cari verifikator
- Membuat fungsi get_shs_noa pada model M_ots, untuk menampilkan shs semua noa
- Membuat fungsi get_shs_sudah pada model M_ots, untuk menampilkan shs yang sudah dikunjungi
3. Menampilkan nama verifikator pada dashboard:
- Memproses data bila verifikator dipilih
4. Memproses bila filter bank dipilih, akan merubah semua data 

Progress : 84%

Report 8/07/2019

Nama Project : SIP-BJB Interasi 1.1
Tahapan : Build
Detail :

1. Membuat halaman untuk level user AO:
- Menambahkan menu Monitoring dan kelolaan pada view Template
2. Menampilkan data tr_monitoring pada menu monitoring
a. Memperbaiki fungsi monitoring debitur:
- menambahkan parameter reg_employee
- Membuat kondisi jika reg_employee terisi untuk menampilkan data sesuai reg_employee 
b. Membuat fungsi bukti_kunjugan:
- Menampikan bukti kunjungan berupa file word
- Proses menyelesaikan view V_word untuk bukti kunjungan debitur npl atau wo
3. Memperbaiki fungsi get_data_list_monitoring pada model M_monitoring:
- Menambahkan kondisi jika varible jenis, deal_reff, reg_employee terisi atau tidak

Progress : 95%

Nama Project : R-care Interasi 1.1
Tahapan : Build
Detail :

1. Menambahkan button unduh excel untuk report ots
2. Membuat kondisi jika menekan button unduh excel pada fungsi unduh_pdf controller R_ots
3. Membuat view export_excel untuk tampilan excel, menggunkan phpspreadsheet 

Progress : 80%

Report 5/07/2019

Nama Project : SIP-BJB Interasi 1.1
Tahapan : Build
Detail :

1. Menambahkan icon notifikasi pada header template:
- Untuk menampilkan jumlah debitur yang follow up H-3
- Menampilkan data debitur sesuai dengan tanggal yang ada
2. Membuat fungsi follow up pada controller Monitoring:
- Untuk menampilkan data debitur yang follow up
- Membuat algoritma menampilkan tanggal H-3 dari tanggal sekarang
- Membuat kondisi untuk button unduh excel
- Membuat view monitoring_debitur, menampilkan list debitur
- Membuat view unduh_excel, menampilkan data berupa excel
- Membuat view template_excel_deb, untuk format excel
3. Menambahkan session tgl_skrg dan tgl_min_3 pada fungsi login controller Auth
4. Menambahkan session set_userdata, hitung_deb dan data_debb pada semua construct controller:
- Controller Dasbor, karyawan, kelolaan, monitoring, pengguna, dan report

Progress : 85%