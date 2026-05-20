<div align="center">

# 🎓 EduPath — A Centralized Platform for Global Academic Applications

### Your Path to Global Education Starts Here

A modern full-stack web application for discovering global academic programs, scholarships, and research labs — with smart application tracking, eligibility checking, and a premium dashboard experience.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat&logo=mysql&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-MVC-success?style=flat)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat)

</div>

---

## 📖 About The Project

EduPath helps students discover and apply to academic programs, scholarships, and research labs worldwide. Built with a clean, scalable architecture following industry best practices (MVC, Repository Pattern, Service Layer, Middleware-based security).

### ✨ Features

- **Global Program Search** — Browse programs across universities with advanced filters
- **Scholarship Aggregation** — Find funding with smart eligibility checking
- **Professor & Lab Discovery** — Connect directly with researchers via email
- **Application Tracking** — Visual progress bars and deadline reminders
- **Student Dashboard** — Glassmorphism cards, animated widgets
- **Notification System** — Real-time updates with floating panel
- **Saved Opportunities** — Bookmark programs, scholarships, professors
- **Fully Responsive** — Mobile-first design
- **iOS-Style Animations** — Smooth success popups with shake effect
- **Role-Based Access Control** — Student / Admin / Professor roles

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Backend** | PHP 8 (Laravel-style architecture) |
| **Database** | MySQL (with SQLite fallback for instant setup) |
| **Architecture** | MVC + Repository Pattern + Service Layer |
| **Patterns** | Singleton, Front Controller, Middleware Chain |

---

## 🏗 Architecture

```
edupath/
├── public/              # Web root (entry point, CSS, JS)
│   └── index.php        # Front Controller
├── bootstrap/           # Autoloader + session setup
├── config/              # Configuration files
├── app/
│   ├── Core/            # Framework core (Singleton, Router, Database, View)
│   ├── Http/
│   │   ├── Controllers/ # Request handlers (MVC Controllers)
│   │   └── Middleware/  # Auth, Guest, Admin, CSRF guards
│   ├── Models/          # Data models
│   ├── Repositories/    # Data access layer (all SQL)
│   └── Services/        # Business logic layer
├── resources/views/     # HTML templates
├── routes/web.php       # RESTful routes
├── database/
│   ├── migrations/      # MySQL + SQLite schemas
│   └── seeders/         # Realistic dummy data
└── storage/             # SQLite DB + logs
```

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.0 or higher with `pdo_sqlite` extension
- (Optional) MySQL 5.7+ if not using SQLite fallback

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/edupath.git
   cd edupath
   ```

2. **Run the development server**
   ```bash
   php -S localhost:8000 -t public
   ```

3. **Open in browser**
   ```
   http://localhost:8000
   ```

   The SQLite database auto-creates and seeds on first launch — no setup needed!

### Using MySQL instead (optional)

1. Create the database and run the schema:
   ```bash
   mysql -u root -p < database/migrations/mysql_schema.sql
   ```
2. Update credentials in `config/app.php`
3. Set `'use_sqlite_fallback' => false`

---

## 🔐 Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Student | `nafis@edupath.com` | `password` |
| Admin | `admin@edupath.com` | `admin123` |
| Professor | `sarah.ahmed@mit.edu` | `professor` |

---

## 👥 Team

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/sifat6472">
        <img src="https://github.com/sifat6472.png" width="80" style="border-radius:50%"><br>
        <b>S.M. Sifatul Islam</b>
      </a><br>
      Team Lead / Backend
    </td>
    <td align="center">
      <a href="https://github.com/junayedJ95">
        <img src="https://github.com/junayedJ95.png" width="80" style="border-radius:50%"><br>
        <b>Junayed Hossain</b>
      </a><br>
      Backend
    </td>
    <td align="center">
      <a href="https://github.com/shadik-username">
        <img src="https://github.com/shadik-username.png" width="80" style="border-radius:50%"><br>
        <b>Shadik Hasan</b>
      </a><br>
      Frontend
    </td>
    <td align="center">
      <a href="https://github.com/juhaer-10">
        <img src="https://github.com/juhaer-10.png" width="80" style="border-radius:50%"><br>
        <b>Kazi Md. Juhaer Akhtab</b>
      </a><br>
      Frontend
    </td>
    <td align="center">
      <a href="https://github.com/nirob-username">
        <img src="https://github.com/nirob-username.png" width="80" style="border-radius:50%"><br>
        <b>Nirob Chandra Banik</b>
      </a><br>
      Database
    </td>
  </tr>
</table>

---

## 🤝 Contributing

We follow a **branch-based workflow**. **Direct pushes to `main` are not allowed.**

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for the full workflow.

**Quick version:**
```bash
git checkout -b feature/your-feature-name   # Create your branch
git add .
git commit -m "Add: your feature description"
git push origin feature/your-feature-name   # Push your branch
# Then open a Pull Request on GitHub
```

---

## 📜 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<div align="center">

Built with ❤️ for academic excellence

</div>
