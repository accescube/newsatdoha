# NEWS @ DOHA (News At Doha Web Portal)

> **Official web portal for [News At Doha (@newsatdoha2018)](https://www.facebook.com/newsatdoha2018) — Connecting 12,200+ Qatar residents & expatriates with verified news, visa updates, currency exchange rates, and community announcements.**

[![Facebook](https://img.shields.io/badge/Facebook-12K%2B%20Followers-1877F2?logo=facebook&logoColor=white)](https://www.facebook.com/newsatdoha2018)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](#license)

---

## 🌟 Highlights & Features

- **Authentic Brand Identity**: Incorporates the official Qatar Maroon (`#8A1538`) serrated "ND" monogram and newspaper emblem.
- **Bilingual Experience**: Seamless instant toggle between **English** and **മലയാളം (Malayalam)**.
- **Doha Live Bar**: Real-time Arabia Standard Time (AST / GMT+3) digital clock and live Doha weather.
- **Breaking News Ticker**: Smooth animated marquee delivering urgent Ministry of Interior (MOI), Ashghal, and airport announcements.
- **Rich Editorial Layout**:
  - Hero lead story with supporting trending news grid.
  - Categorized news sections: *Qatar News*, *Visa & Expat Affairs*, *Business & Gold*, *Community & Culture*, *Sports*, and *Jobs in Doha*.
- **Interactive Expat Utility Suite**:
  - **Live QAR Currency Converter**: Real-time calculator for converting Qatar Riyal to INR, PKR, BDT, PHP, NPR, and USD.
  - **Doha Prayer Times**: Daily timings for Fajr, Sunrise, Dhuhr, Asr, Maghrib, and Isha based on the Ministry of Awqaf & Islamic Affairs Qatar.
  - **Daily Gold & Fuel Prices**: Qatar Energy fuel prices (Premium 91, Super 95, Diesel) and 24K, 22K, 18K retail gold rates.
  - **Qatar Emergency Directory**: Instant one-click phone links for 999, HMC Hospital (`16060`), Labour Ministry (`16008`), and diplomatic missions.
- **Article Reading Experience**:
  - Text zoom buttons ($A^- / A / A^+$) for easy reading.
  - Listen to Article (Audio narration via browser SpeechSynthesis).
  - One-click social sharing to WhatsApp, Facebook, X (Twitter), Telegram, and Copy Link.
- **Zero-Configuration Editorial CMS (`/admin`)**:
  - Passcode-protected management dashboard (`doha2026`).
  - Add, edit, and delete bilingual articles with live previews.
  - Update daily QAR exchange rates, gold rates, and fuel prices directly from the UI.
  - Lightweight file-based JSON storage without complex database setup.

---

## 📂 Project Structure

```
NEWSATDOHA/
├── assets/
│   ├── css/
│   │   └── style.css          # Editorial styles, Qatar maroon theme, dark/light mode
│   ├── js/
│   │   └── main.js            # Live clock, currency converter, TTS audio, dark mode
│   └── img/
│       └── logo.jpg           # Official News @ Doha brand logo
├── data/
│   ├── articles.json          # Pre-populated Qatar news stories (EN & ML)
│   ├── categories.json        # Categories metadata (Qatar, Expat, Business, Community, Sports, Jobs)
│   ├── settings.json          # Site configuration, exchange rates, gold rates, prayer times
│   └── subscribers.json       # Newsletter & WhatsApp alerts subscribers
├── includes/
│   ├── db.php                 # Dynamic URL routing, language switcher, JSON storage functions
│   ├── header.php             # Top utility bar, live Doha time, marquee ticker, navigation
│   ├── footer.php             # Footer with Facebook badge, quick links, newsletter form
│   └── widgets.php            # Currency calculator, prayer times, emergency numbers, trending list
├── admin/
│   ├── index.php              # Editorial management dashboard
│   ├── edit.php               # Article creator & editor
│   ├── settings.php           # Daily exchange rates & social counter editor
│   ├── login.php              # Passcode authentication
│   └── logout.php             # Session logout
├── index.php                  # Master homepage
├── article.php                # Single article reader
├── category.php               # Category archives
├── search.php                 # Search results page
├── expat-guide.php            # Dedicated Qatar Expatriate Living & Legal Guide
├── currency.php               # Qatar Riyal live exchange rate center & calculator
├── prayer-times.php           # Doha daily prayer timings
├── directory.php              # Qatar emergency & diplomatic helpline directory
├── api.php                    # REST API for newsletter subscription & search
└── .htaccess                  # Apache rewrite & UTF-8 character configuration
```

---

## 🚀 Quick Start & Installation

### Option 1: Run with XAMPP (Recommended)
1. Clone or place this repository into your XAMPP `htdocs` directory:
   ```bash
   c:\xampp\htdocs\NEWSATDOHA
   ```
2. Start **Apache** from the XAMPP Control Panel.
3. Open your browser and visit:
   ```
   http://localhost/NEWSATDOHA/
   ```

### Option 2: Run with PHP Built-in Server
Open your terminal inside the project root:
```bash
php -S localhost:8080
```
Then visit `http://localhost:8080/` in your browser.

---

## 🔐 Editorial Admin Panel

Access the built-in management CMS to add and edit articles:
- **URL**: `http://localhost/NEWSATDOHA/admin/`
- **Default Passcode / PIN**: `doha2026`

---

## 📱 Official Social Community

- **Facebook**: [News At Doha (@newsatdoha2018)](https://www.facebook.com/newsatdoha2018)
- **Tagline**: *ഖത്തറിലെ പ്രധാന വാർത്തകൾ കൃത്യമായി അറിയാനുള്ള ഇടം.*

---

## 📄 License
Released under the [MIT License](LICENSE).
