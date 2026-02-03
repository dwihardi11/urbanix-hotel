# 🏨 Urbanix Hotel

Sistem Booking Hotel Premium dengan Laravel 11 & PHP 8.2

## 📋 Tentang Proyek

Urbanix Hotel adalah aplikasi web booking hotel dengan desain elegan dark theme (navy & gold). Fitur lengkap untuk customer dan admin dengan UI/UX modern dan responsive.

## ✨ Highlights

- 🎨 **Premium Dark Theme** - Navy blue dengan gold accents
- 🌟 **Modern Glassmorphism** - Efek blur dan transparansi elegan
- ✨ **Micro-animations** - Hover effects, transitions, dan floating animations
- 📱 **Fully Responsive** - Optimal di semua ukuran layar
- 🔒 **Secure** - CSRF protection, authentication, dan authorization

## ⚡ Fitur Utama

### 👤 Customer (Frontend)
- ✅ Register & Login dengan validasi
- ✅ Homepage dengan hero section, booking widget, dan testimonials
- ✅ Daftar kamar dengan filter, sorting, dan room type tabs
- ✅ Detail kamar dengan gallery, amenities, dan booking form
- ✅ Cek ketersediaan kamar real-time
- ✅ Booking kamar (wajib login)
- ✅ History booking dengan status tracking
- ✅ Konfirmasi booking dengan kode unik

### 🔧 Admin Panel
- ✅ Dashboard dengan statistik dan charts
- ✅ Kelola kamar (CRUD) dengan status management
- ✅ Kelola booking (confirm, check-in, check-out, cancel)
- ✅ Kelola tipe kamar dengan harga dan kapasitas
- ✅ Kelola data tamu
- ✅ Booking calendar view

## 🎨 Design System

### Warna
| Variabel | Warna | Penggunaan |
|----------|-------|------------|
| `--accent` | #E6C68A | Gold accent, highlights, buttons |
| `--primary` | #112240 | Card backgrounds, sections |
| `--bg-dark` | #020C1B | Main background |
| `--teal` | #64FFDA | Success states, availability |
| `--text-highlight` | #CCD6F6 | Headings, important text |

### Komponen UI
- **Glass Cards** - Backdrop blur dengan border subtle
- **Room Cards** - Image hover zoom, price display, status badges
- **Buttons** - Gradient gold dengan hover glow effect
- **Form Inputs** - Dark background dengan gold focus state
- **Pagination** - Modern rounded style

## 🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8.2
- **Database:** MySQL
- **Frontend:** Bootstrap 5, Custom CSS, Bootstrap Icons
- **Fonts:** Cormorant Garamond (headings), Montserrat (body)
- **Icons:** Bootstrap Icons

## 🚀 Instalasi

```bash
# Clone repository
git clone https://github.com/username/urbanix-hotel.git
cd urbanix-hotel

# Install dependencies
composer install

# Copy .env
cp .env.example .env

# Generate key
php artisan key:generate

# Konfigurasi database di .env
# DB_DATABASE=urbanix_hotel
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migration & seeder
php artisan migrate --seed

# Jalankan server
php artisan serve
```

## 📁 Struktur Proyek

```
app/
├── Http/Controllers/
│   ├── Admin/              # Controller admin panel
│   │   ├── BookingController.php
│   │   ├── DashboardController.php
│   │   ├── GuestController.php
│   │   ├── RoomController.php
│   │   └── RoomTypeController.php
│   ├── Auth/               # Authentication
│   ├── BookingController.php
│   ├── HomeController.php
│   └── RoomController.php
├── Models/                 # Eloquent models
│   ├── Amenity.php
│   ├── Booking.php
│   ├── Guest.php
│   ├── Hotel.php
│   ├── Room.php
│   ├── RoomType.php
│   └── User.php
└── Services/
    └── BookingService.php  # Business logic (date validation, pricing)

resources/views/
├── admin/                  # Admin panel views
│   ├── bookings/          # Booking management
│   ├── dashboard.blade.php
│   ├── guests/            # Guest management
│   ├── rooms/             # Room management
│   └── room-types/        # Room type management
├── auth/                   # Login & register views
├── frontend/               # Customer-facing views
│   ├── home.blade.php     # Homepage dengan hero & booking widget
│   ├── rooms/             # Room listing & detail
│   ├── booking/           # Booking flow
│   └── search.blade.php   # Search results
└── layouts/
    ├── admin.blade.php    # Admin layout
    └── frontend.blade.php # Customer layout dengan CSS system
```

## 👥 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@urbanix.com | password |

## 📱 Responsive Breakpoints

| Breakpoint | Ukuran | Target |
|------------|--------|--------|
| Desktop | 1400px+ | Full layout |
| Laptop | 992px - 1399px | 2 columns grid |
| Tablet | 576px - 991px | Single column |
| Mobile | < 576px | Stack layout |

## 🔄 Recent Updates

### v2.0 - UI/UX Redesign (Feb 2026)
- ✨ Homepage redesign dengan enhanced hero section
- ✨ Modern booking widget dengan styled inputs
- ✨ Room listing dengan room type tabs dan improved cards
- ✨ Feature cards dengan hover animations
- ✨ Stats section dengan gradient numbers
- ✨ Testimonial cards dengan quote styling
- ✨ Admin panel views untuk room types dan guests

### v1.0 - Initial Release
- 🚀 Core booking functionality
- 🎨 Dark theme implementation
- 👤 Customer authentication
- 🔧 Admin panel basics

## 👨‍💻 Developer
Dwi Hardiansyah
