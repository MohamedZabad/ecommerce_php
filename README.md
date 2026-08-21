# PHP E-Commerce Mini Store

A simple e-commerce web app built with **PHP, MySQL, and PDO** as a learning project. It includes a customer-facing storefront (browse products, add to cart, checkout) and an admin panel (login, manage products, view orders).

This was built as a first hands-on project with PHP, covering database design, sessions, form handling, file uploads, and basic authentication.

## Features

**Storefront**
- Product listing and detail pages
- Session-based shopping cart (add, update, remove items)
- Checkout flow that saves orders to the database

**Admin Panel**
- Secure login (passwords hashed with `password_hash()`)
- Dashboard listing all products with edit/hide controls
- Add and edit products, including image upload
- Soft-delete system — hiding a product removes it from the shop without breaking past orders
- Order history view

## Tech Stack

- PHP (vanilla, no framework)
- MySQL / MariaDB
- PDO for database access (prepared statements throughout, to prevent SQL injection)
- Plain HTML/CSS (no frontend framework)
- Local dev environment: [Laragon](https://laragon.org/) (Apache + MySQL + PHP)

## Database Structure

| Table | Purpose |
|---|---|
| `products` | Product catalog (name, price, description, image, stock, active status) |
| `orders` | Customer orders (name, address, total) |
| `order_items` | Line items linking orders to products |
| `admins` | Admin login accounts (hashed passwords) |

The full schema is in [`ecommerce_proj_db.sql`](./ecommerce_proj_db.sql).

## Setup / Running Locally

1. Install [Laragon](https://laragon.org/) (or XAMPP/MAMP — any Apache + MySQL + PHP stack works)
2. Clone this repo into your `www` folder:
   ```
   git clone https://github.com/yourusername/ecommerce_php.git ecommerce-proj
   ```
3. Start Laragon (Apache + MySQL)
4. Open HeidiSQL (or phpMyAdmin) and create a new database called `ecommerce_proj`
5. Import `ecommerce_proj_db.sql` into that database to create all the tables
6. Create your first admin account by visiting `create_admin.php` once in the browser (edit the username/password inside the file first), then delete that file
7. Visit `http://localhost/ecommerce-proj/` to view the store, or `http://localhost/ecommerce-proj/admin/login.php` for the admin panel

## Project Structure

```
ecommerce-proj/
├── admin/              # Admin panel (login, dashboard, product/order management)
│   └── includes/
├── config/
│   └── db.php          # Database connection (PDO)
├── includes/            # Shared header/footer
├── uploads/              # Uploaded product images
├── index.php             # Product listing (homepage)
├── product.php            # Single product page
├── cart.php                # Shopping cart
├── add_to_cart.php
├── remove_from_cart.php
├── checkout.php
└── style.css
```

## What I Learned

- Structuring a multi-page PHP app with shared includes (header/footer)
- Using PDO with prepared statements to safely query MySQL
- Session-based state (cart) without needing a database table
- Password hashing and basic authentication for the admin panel
- Handling file uploads (`$_FILES`) for product images
- Designing around foreign key constraints — and why soft deletes (an `is_active` flag) are often better than hard deletes once real data depends on a row

## Notes

This is a learning/portfolio project, not production-ready. A few things a real deployment would need: CSRF protection on forms, environment-based config instead of hardcoded DB credentials, input validation beyond the basics, and a proper payment integration at checkout.