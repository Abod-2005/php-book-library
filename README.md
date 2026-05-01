# php-book-library
PHP single-file book library with add, edit, delete and Bootstrap 5
# 📚 Personal Book Library

A dynamic single-file PHP web application that manages a personal book library.  
Built with **PHP**, **Sessions**, and **Bootstrap 5**.

---

## 🚀 Features

- **Add** a new book with full validation
- **Edit** an existing book (pre-populated form)
- **Delete** a book with a Bootstrap Modal confirmation
- **Form validation** with field-level error messages
- **Session persistence** — books stay after page refresh
- **Success alerts** after every action
- **Responsive layout** — form on the left, table on the right

---

## 🛠️ Tech Stack

| Technology | Usage |
|------------|-------|
| PHP 8+ | Backend logic, session handling, validation |
| Bootstrap 5 (CDN) | UI layout, alerts, modals, table styling |
| HTML5 | Markup structure |

---

## 📋 Validation Rules

| Field | Rule |
|-------|------|
| Title | Required · 3–120 characters · No duplicates |
| Author | Required · Must contain at least two words |
| Genre | Required · Must be one of the allowed genres |
| Year | Required · 4-digit integer · Between 1000 and current year |
| Pages | Required · Positive integer greater than 0 |

---

## 📁 Project Structure

```
php-book-library/
└── index.php   ← entire application in one file
```

---

## ⚙️ How to Run

1. Make sure you have **XAMPP** (or any PHP server) installed
2. Place `index.php` inside `htdocs/your-folder/`
3. Start **Apache** from the XAMPP Control Panel
4. Open your browser and go to:
   ```
   http://localhost/your-folder/index.php
   ```

---

## 📦 Allowed Genres

`Fiction` · `Non-Fiction` · `Science` · `History` · `Biography` · `Technology`

---

## 👨‍💻 Author

**Abod-2005**  
Islamic University of Gaza — Faculty of Information Technology  
Web 2 Practical · Assignment 2 · Semester 2 · 2024/2025
