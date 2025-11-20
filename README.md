# 🏨 DALN Hotel Management System

[![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-2.x-4E56A6?style=flat&logo=livewire)](https://laravel-livewire.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat&logo=php)](https://php.net)

Hệ thống quản lý khách sạn toàn diện được xây dựng trên nền tảng [TALL Stack](https://tallstack.dev/) (Tailwind CSS 3, Alpine.js 3, Laravel Livewire 2, Laravel 9). Dự án phục vụ cho Phenikaa Hotel với tính năng đặt phòng trực tuyến, quản lý vận hành cho nhân viên và chatbot AI hỗ trợ khách hàng được tích hợp Google Gemini.

![Application Overview](https://i.postimg.cc/SKm6ZkSy/Screenshot-1355.png)

---

## 📋 Mục lục

- [Tính năng chính](#-tính-năng-chính)
- [Công nghệ sử dụng](#-công-nghệ-sử-dụng)
- [Cấu trúc dự án](#-cấu-trúc-dự-án)
- [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
- [Cài đặt](#-cài-đặt)
- [Cấu hình](#-cấu-hình)
- [Phân quyền người dùng](#-phân-quyền-người-dùng)
- [Tính năng Chatbot](#-tính-năng-chatbot)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Đóng góp](#-đóng-góp)
- [License](#-license)

---

## ✨ Tính năng chính

### 🎯 Quản lý Phòng & Tiện ích
- ✅ CRUD đầy đủ cho Room (loại phòng), RoomDetail (phòng vật lý), Facility (tiện ích)
- ✅ Quản lý chi tiết phòng theo tầng với trạng thái vệ sinh và bảo trì
- ✅ Upload và quản lý hình ảnh phòng, tiện ích
- ✅ Quản lý giá phòng theo từng loại và theo mùa
- ✅ Kiểm tra phòng trống theo thời gian thực

### 📅 Hệ thống Đặt phòng
- ✅ Đặt phòng trực tuyến với nhiều loại phòng
- ✅ Quản lý trạng thái đặt phòng (pending, confirmed, checked-in, checked-out, cancelled)
- ✅ Tự động tính toán giá phòng theo số đêm
- ✅ Lịch sử đặt phòng của khách hàng
- ✅ Xác nhận đặt phòng qua email

### 👥 Phân quyền & Quản lý người dùng
- ✅ 3 vai trò: Admin, Receptionist, Guest
- ✅ Xác thực email với Laravel Breeze
- ✅ Phân quyền chi tiết với Spatie Laravel Permission
- ✅ Quản lý hồ sơ người dùng

### ⭐ Đánh giá & Review
- ✅ Đánh giá phòng và tiện ích
- ✅ Hệ thống rating 5 sao
- ✅ Kiểm duyệt đánh giá

### 🤖 AI Chatbot (Gemini Integration)
- ✅ Tích hợp Google Gemini 2.0 Flash API
- ✅ Hỗ trợ tư vấn tự động bằng tiếng Việt
- ✅ Trả lời câu hỏi về giá phòng, tiện ích, chính sách
- ✅ Logging và error handling

### 📊 Dashboard & Báo cáo
- ✅ Dashboard cho Admin với thống kê tổng quan
- ✅ Dashboard cho Receptionist quản lý check-in/check-out
- ✅ Dashboard cho Guest theo dõi đặt phòng

### 🎨 Giao diện & Nội dung
- ✅ Quản lý About page
- ✅ Thư viện hình ảnh (Gallery)
- ✅ Responsive design với Tailwind CSS
- ✅ Interactive UI với Alpine.js

---

## 🛠️ Công nghệ sử dụng

### Backend
- **Framework**: Laravel 9.x
- **Authentication**: Laravel Breeze + Laravel Sanctum
- **Authorization**: Spatie Laravel Permission
- **Real-time**: Laravel Livewire 2.x
- **Database ORM**: Eloquent ORM
- **Queue & Jobs**: Laravel Queue
- **API Integration**: Google Gemini 2.0 Flash

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Template Engine**: Blade Components
- **Build Tool**: Laravel Mix / Vite
- **Icons**: Boxicons

### Database
- **Primary**: MySQL 8.0+ / MariaDB 10.3+
- **Migration**: Laravel Migrations
- **Seeding**: Database Seeders & Factories

### Development Tools
- **Dependency Manager**: Composer 2.x, NPM
- **Testing**: PHPUnit, Laravel Dusk
- **Code Quality**: PHP CS Fixer, Laravel Pint

---

## 📁 Cấu trúc dự án

```
DALN/
├── app/
│   ├── Console/
│   │   └── Kernel.php
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ChatbotController.php       # Gemini AI Integration
│   │   │   └── Auth/
│   │   ├── Livewire/                       # Livewire Components
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Room.php                        # Loại phòng
│   │   ├── RoomDetail.php                  # Phòng vật lý
│   │   ├── Reservation.php                 # Đặt phòng
│   │   ├── Facility.php                    # Tiện ích
│   │   ├── FacilityReview.php
│   │   ├── RoomReview.php
│   │   ├── RoomHasFacility.php            # Pivot table
│   │   ├── About.php
│   │   └── Galery.php
│   ├── Providers/
│   ├── Rules/
│   │   └── PhoneNumber.php
│   └── View/
│       └── Components/
├── bootstrap/
├── config/
│   ├── app.php
│   ├── database.php
│   ├── permission.php
│   └── ...
├── database/
│   ├── factories/
│   │   └── ReservationFactory.php
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2022_02_18_031320_create_permission_tables.php
│   │   └── ...
│   └── seeders/
├── public/
│   ├── css/
│   ├── js/
│   ├── img/
│   └── index.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── livewire/
│       ├── components/
│       ├── admin/
│       ├── receptionist/
│       └── guest/
├── routes/
│   ├── web.php
│   ├── api.php
│   ├── auth.php
│   ├── channels.php
│   └── console.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
├── tailwind.config.js
└── webpack.mix.js
```

---

## 💻 Yêu cầu hệ thống

### Môi trường Development
- **PHP**: >= 8.1
- **Composer**: >= 2.0
- **Node.js**: >= 16.x
- **NPM**: >= 8.x
- **Database**: MySQL >= 8.0 hoặc MariaDB >= 10.3

### PHP Extensions (Required)
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- cURL
- GD / Imagick (cho xử lý ảnh)
```

### Khuyến nghị
- **Web Server**: Apache 2.4+ với mod_rewrite hoặc Nginx 1.18+
- **Memory**: >= 512MB RAM
- **Disk**: >= 1GB free space

---

## 🚀 Cài đặt

### 1. Clone Repository

```bash
git clone https://github.com/hoanganh-k2/DALN.git
cd DALN
```

### 2. Cài đặt Dependencies

#### Backend Dependencies (Composer)
```bash
composer install
```

#### Frontend Dependencies (NPM)
```bash
npm install
```

### 3. Cấu hình Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Cấu hình Database

Mở file `.env` và cập nhật thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=daln
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Tạo Database và Migration

```bash
# Tạo database (hoặc tạo thủ công trong MySQL)
mysql -u root -p -e "CREATE DATABASE daln CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Chạy migrations
php artisan migrate

# Seed dữ liệu mẫu (tùy chọn)
php artisan db:seed
```

### 6. Link Storage

```bash
php artisan storage:link
```

### 7. Build Assets

#### Development Mode
```bash
npm run dev
```

#### Production Mode
```bash
npm run build
```

### 8. Chạy Application

#### Sử dụng PHP Built-in Server
```bash
php artisan serve
```

Truy cập: `http://localhost:8000`

#### Sử dụng Laravel Valet (macOS)
```bash
valet link
valet secure daln  # HTTPS (optional)
```

#### Sử dụng Laravel Homestead
Cấu hình trong `Homestead.yaml` và chạy:
```bash
vagrant up
```

### 9. Chạy Queue Worker (Optional)

Nếu sử dụng email queue hoặc background jobs:

```bash
php artisan queue:work
```

### 10. Chạy Scheduler (Optional)

Thêm vào crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## ⚙️ Cấu hình

### Cấu hình Email

Trong file `.env`, cấu hình SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@phenikaahotel.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Cấu hình Google Gemini API

Đăng ký API key tại [Google AI Studio](https://makersuite.google.com/app/apikey) và thêm vào `.env`:

```env
GEMINI_API_KEY=your_gemini_api_key_here
```

### Cấu hình File Storage

```env
FILESYSTEM_DISK=public
```

### Cấu hình Session & Cache

```env
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

Cho production, khuyến nghị sử dụng Redis:

```env
SESSION_DRIVER=redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## 👥 Phân quyền người dùng

### Các vai trò (Roles)

| Vai trò | Route Prefix | Chức năng chính |
|---------|--------------|-----------------|
| **Admin** | `/admin` | Quản lý toàn bộ hệ thống: rooms, facilities, galleries, users, settings |
| **Receptionist** | `/receptionist` | Quản lý đặt phòng, check-in/check-out, cập nhật trạng thái phòng |
| **Guest** | `/dashboard` | Xem phòng, đặt phòng, đánh giá, quản lý hồ sơ cá nhân |

### Tài khoản mặc định (sau khi seed)

```
Admin:
Email: admin@phenikaahotel.com
Password: password

Receptionist:
Email: receptionist@phenikaahotel.com
Password: password

Guest:
Email: guest@example.com
Password: password
```

### Dashboard Screenshots

#### Admin Dashboard
![Admin Dashboard](https://i.postimg.cc/FsZCNWYs/Screenshot-1363.png)

#### Receptionist Dashboard
![Receptionist Dashboard](https://i.postimg.cc/wxs3CZbL/Screenshot-1365.png)

#### Guest Dashboard
![Guest Dashboard](https://i.postimg.cc/PqttNF43/Screenshot-1364.png)

---

## 🤖 Tính năng Chatbot

### Mô tả

Chatbot AI được tích hợp Google Gemini 2.0 Flash để hỗ trợ khách hàng 24/7 bằng tiếng Việt.

### Tính năng Chatbot

- ✅ Tư vấn về loại phòng, giá cả, tiện ích
- ✅ Hướng dẫn đặt phòng, chính sách check-in/check-out
- ✅ Giải đáp về chính sách hủy phòng, hoàn tiền
- ✅ Giới thiệu dịch vụ: nhà hàng, spa, gym, hồ bơi
- ✅ Hỗ trợ nhân viên tra cứu thông tin khách hàng

### Cấu hình

File controller: `app/Http/Controllers/ChatbotController.php`

```php
// Đã được cấu hình với context về Phenikaa Hotel
// Chỉnh sửa biến $context để tùy chỉnh hành vi chatbot
```

### Sử dụng

```javascript
// POST request đến /chatbot/send
{
    "message": "Giá phòng deluxe là bao nhiêu?"
}

// Response
{
    "message": "Phòng Deluxe của khách sạn có giá 1.200.000đ/đêm..."
}
```

### Logging

Tất cả request/response được log tại `storage/logs/laravel.log`

---

## 🧪 Testing

### Chạy Tests

```bash
# Tất cả tests
php artisan test

# Hoặc sử dụng PHPUnit trực tiếp
vendor/bin/phpunit

# Chạy test cụ thể
php artisan test --filter=ReservationTest

# Với coverage
php artisan test --coverage
```

### Test Structure

```
tests/
├── Feature/
│   ├── Auth/
│   ├── ReservationTest.php
│   ├── RoomTest.php
│   └── ChatbotTest.php
└── Unit/
    ├── Models/
    └── Helpers/
```

---

## 📦 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` trong `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate production key: `php artisan key:generate`
- [ ] Cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`
- [ ] Optimize autoloader: `composer install --optimize-autoloader --no-dev`
- [ ] Build assets: `npm run build`
- [ ] Setup SSL certificate
- [ ] Configure queue worker với Supervisor
- [ ] Setup cron cho scheduler
- [ ] Configure backup strategy

### Deploy với Nginx

Cấu hình Nginx mẫu:

```nginx
server {
    listen 80;
    server_name phenikaahotel.com;
    root /var/www/daln/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🤝 Đóng góp

Chúng tôi hoan nghênh mọi đóng góp cho dự án!

### Quy trình đóng góp

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Use Laravel best practices
- Write meaningful commit messages
- Add tests for new features
- Update documentation

### Run Code Style Fixer

```bash
# Laravel Pint
./vendor/bin/pint

# PHP CS Fixer
./vendor/bin/php-cs-fixer fix
```

---

## 📝 License

This project is licensed under the MIT License. See [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**DALN Development Team**

- GitHub: [@hoanganh-k2](https://github.com/hoanganh-k2)
- Repository: [DALN](https://github.com/hoanganh-k2/DALN)

---

## 🙏 Acknowledgments

- Laravel Framework Team
- Livewire Team
- Tailwind CSS Team
- Google Gemini AI Team
- Spatie for Laravel Permission package
- All contributors and supporters

---

## 📞 Support

Nếu bạn gặp vấn đề hoặc có câu hỏi:

- 📧 Email: support@phenikaahotel.com
- 🐛 Issues: [GitHub Issues](https://github.com/hoanganh-k2/DALN/issues)
- 📚 Documentation: [Wiki](https://github.com/hoanganh-k2/DALN/wiki)

---

**Made with ❤️ by DALN Team | Phenikaa Hotel © 2025**
