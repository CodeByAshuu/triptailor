<div align="center">

# ✈️ TripTailor

**A workspace-based travel itinerary planning platform**

_Plan smarter. Travel better. Think Notion — but for your adventures._

[![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-77C1D2?style=flat-square&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

</div>

---

## 🧭 What is TripTailor?

TripTailor is a modern, **productivity-style travel planning workspace** built with Laravel MVC and Blade templating. It replaces the chaos of planning trips across WhatsApp chats, spreadsheets, screenshots, and notes apps — bringing everything into one clean, structured platform.

Inspired by the design philosophy of **Notion**, **Linear**, **Todoist**, and **Arc Browser**, TripTailor feels less like a travel app and more like a focused creative workspace dedicated entirely to your adventures.

---

## 🚀 Features

| Feature                  | Description                                                                      |
| ------------------------ | -------------------------------------------------------------------------------- |
| **Trip Management**      | Create and manage trips with title, destination, dates, budget, and notes        |
| **Day-wise Itineraries** | Organize activities chronologically by day with times, locations, and categories |
| **Favorites**            | Bookmark trips and access them instantly from the sidebar                        |
| **Explore Templates**    | Pre-built itineraries like _Goa Weekend_, _Kerala Escape_, _Manali Adventure_    |
| **Budget Tracking**      | Estimate and track trip expenses from the dashboard                              |
| **Search & Filters**     | Quickly find and filter trips by labels and categories                           |
| **Weather Integration**  | Preview weather conditions for your travel destination                           |
| **PDF Export**           | Export your itinerary as a printable PDF _(coming soon)_                         |
| **Dark Productivity UI** | A premium dark-themed interface with orange accents                              |

---

## 🖥️ Tech Stack

```
Backend    →  Laravel 10+ (PHP 8.x) — MVC, Eloquent ORM, Routing
Frontend   →  Blade Templating + Tailwind CSS v4 + Alpine.js
Database   →  MySQL 8.x
Auth       →  Laravel Breeze (Blade + Alpine stack, dark mode)
Testing    →  Pest
Version Control  →  GitHub
```

**Typography:** Bricolage Grotesque (headings) · Albert Sans (body)

---

## 📁 Project Structure

```
triptailor/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── TripController.php
│   │   ├── ActivityController.php
│   │   └── ExploreController.php
│   └── Models/
│       ├── User.php
│       ├── Trip.php
│       └── Activity.php
│
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php
│   │   └── dashboard.blade.php
│   ├── components/dashboard/
│   │   ├── sidebar.blade.php
│   │   ├── header.blade.php
│   │   ├── trip-card.blade.php
│   │   └── dropdown.blade.php
│   ├── dashboard/
│   │   ├── home.blade.php
│   │   ├── explore.blade.php
│   │   ├── create-trip.blade.php
│   │   └── get-started.blade.php
│   └── trips/
│       ├── create.blade.php
│       ├── show.blade.php
│       └── edit.blade.php
│
├── database/migrations/
├── routes/web.php
└── public/
```

---

## ⚙️ Local Setup

### Prerequisites

Make sure you have the following installed:

- PHP 8.x
- Composer
- Node.js & npm
- MySQL 8.x
- Git

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/[your-org]/triptailor.git
cd triptailor
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Install Node dependencies**

```bash
npm install
```

**4. Configure environment**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your local database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=triptailor
DB_USERNAME=root
DB_PASSWORD=your_password
```

**5. Run database migrations**

```bash
php artisan migrate
```

**6. (Optional) Seed the database with sample templates**

```bash
php artisan db:seed
```

**7. Start the development servers**

```bash
# In one terminal — compile assets
npm run dev

# In another terminal — serve the app
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 🗄️ Database Schema

```
users
  └── id, name, email, password, timestamps

trips
  └── id, user_id, title, location, start_date, end_date,
      budget, description, notes, is_favorite, timestamps

activities
  └── id, trip_id, day_number, title, description, location,
      start_time, end_time, category, notes, timestamps
```

**Relationships:**

- `User` → hasMany → `Trip`
- `Trip` → belongsTo → `User`
- `Trip` → hasMany → `Activity`
- `Activity` → belongsTo → `Trip`

---

## 🧪 Running Tests

```bash
php artisan test
# or
./vendor/bin/pest
```

---

## 👥 Team

| Name           | Registration No. |
| -------------- | ---------------- |
| Sagar Sahu     | 12326460         |
| Harshit Singh  | 12316515         |
| Soumyosish Pal | 12317736         |

_Developed as part of CA-2 — Web Application Development, Spring 2025._

---

## 🗺️ Roadmap

- [x] Landing page & dark UI system
- [x] Laravel Breeze authentication
- [x] Dashboard workspace shell
- [x] Sidebar with interactions (dropdowns, hover menus, accordions)
- [ ] Trip CRUD & trip detail workspace
- [ ] Day-wise activity management
- [ ] Explore templates page
- [ ] Dynamic partial rendering (HTMX / Alpine AJAX)
- [ ] Weather API integration
- [ ] PDF itinerary export
- [ ] AI itinerary generation _(future)_
- [ ] Collaborative trip planning _(future)_

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

---

<div align="center">

Made with ☕ and too many itineraries · TripTailor © 2025

</div>
