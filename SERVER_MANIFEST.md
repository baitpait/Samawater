# SERVER & TECH STACK MANIFEST
> **WARNING:** Code must align strictly with this Stack.

## 1. CORE STACK
- **Framework:** Laravel 11.31 (PHP 8.2+ Strict Types).
- **Admin Panel:** Backpack CRUD 6.8 (Theme: CoreUI v2 / Tabler).
- **Database:** MySQL/MariaDB (Production) - Strict Mode ON.
  - *Dev Note:* SQLite is allowed for local testing only.

## 2. FRONTEND & BUILD TOOLS
- **Build System:** Vite 6.0.11 (with `laravel-vite-plugin`).
- **CSS Frameworks (HYBRID):**
  - 🛑 **Admin Panel:** MUST use **Bootstrap 4.6** (Backpack standard). Do NOT use Tailwind here.
  - ✅ **User Frontend:** Use **Tailwind CSS 3.4**.
- **JS Libs:** jQuery (for Backpack legacy), Axios 1.7, SweetAlert2.
- **Icons:** Line Awesome 1.3.

## 3. REAL-TIME & WEBSOCKETS
- **Engine:** Laravel Reverb 1.6 (Self-Hosted).
- **Client:** Laravel Echo + Pusher JS 8.4.
- **Port:** Default 8080 (Ensure Firewall allows this).
- **Process:** Requires `php artisan reverb:start` daemon via Supervisor.

## 4. PDF GENERATION (ARABIC SUPPORT)
- **Engines:** mPDF 8.2 (Primary) / DomPDF 3.1 (Secondary).
- **Font:** Cairo Font MUST be configured for Arabic text rendering in PDFs.

## 5. INFRASTRUCTURE & DEPLOYMENT
- **OS:** Ubuntu 22.04 LTS (Case-Sensitive).
- **Web Server:** Nginx (Configuration must handle WebSocket upgrades for Reverb).
- **Queue:** Redis (Required for Broadcasting).