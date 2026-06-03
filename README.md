# DevInsight - Minimalist Laravel Blog

DevInsight is a clean, modern, and minimalist blogging platform built using **Laravel**, **Blade templates**, **Tailwind CSS**, and **SQLite**. It features user authentication, role-based authorization, post view counters, and a toggleable like/dislike rating system.

---

## Features

### 👤 Role-Based Authorization
The platform defines three roles with specific access levels:
- **Admin**: Can view, edit, or delete any post and manage categories.
- **Author**: Can write new posts and edit or delete their own posts.
- **Reader**: Can sign up, log in, view posts, and interact with the feedback system.

### 👍 Reaction System & View Counter
- **Likes & Dislikes**: Authenticated users can toggle a single Like or Dislike per article. If they already liked an article, clicking Like again removes it. Clicking Dislike switches their reaction.
- **View Counter**: Automatically tracks article engagement by incrementing views on every page load.
- **Stats Display**: Meta information is displayed dynamically on both the home feed and article details page.

### 📁 Category Filtering
- Sidebar displays all categories along with post counts.
- Clicking a category filters the homepage feed using clean query parameters (`?category_id=X`).

---

## Installation & Setup

Follow these steps to set up the project locally:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/zakari90/laravel-blog.git
   cd laravel-blog
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Install npm dependencies & build assets:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup:**
   Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
   *(Note: The default connection is set to SQLite, which will automatically create and use `database/database.sqlite`)*

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations and seed the database:**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Start the local server:**
   ```bash
   php artisan serve
   ```
   Now navigate to `http://127.0.0.1:8000` in your web browser.

---

## Seeded Accounts

For testing the role-based behaviors, the database seeder creates three accounts (all using the password **`password`**):

- **Admin Account**:
  - Email: `admin@example.com`
  - Role: `admin`
- **Author Account**:
  - Email: `author@example.com`
  - Role: `author`
- **Reader Account**:
  - Email: `reader@example.com`
  - Role: `reader`
