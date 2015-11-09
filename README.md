# silex-perpustakaan

Project sederhana

cara install

1. clone repo ini
2. masuk folder hasil clone, ketik di terminal composer install
3. lakukan setting database di folder src/Db/Db.php
4. rubah settingan database di phinx.yml
5. lakukan migrasi database dengan perintah "vendor/robmorgan/phinx/bin/phinx migrate -e development"
6. lalu masuk ke folder cli , jalankan semua file php yang berada di situ
7. ketik di folder root "php -S localhost:8000 -t public"
8. buka broser http://localhost:8000/home -> untuk frontend , http://localhost:8000/admin/login -> backend 
