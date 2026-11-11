# Labaid Clone Hospital — সম্পূর্ণ সিস্টেম ডকুমেন্টেশন

একটি পূর্ণাঙ্গ Laravel-ভিত্তিক হাসপাতাল ম্যানেজমেন্ট ও ওয়েবসাইট সিস্টেম। এই README-তে সাইটের প্রতিটি ফিচার, কোথায় পাবে, এবং কীভাবে ব্যবহার করবে তার বিস্তারিত বর্ণনা আছে।

---

## 📋 সূচিপত্র

1. [প্রাথমিক সেটআপ](#প্রাথমিক-সেটআপ)
2. [লগইন তথ্য (Demo Credentials)](#লগইন-তথ্য)
3. [ফ্রন্ট-এন্ড ফিচার (ভিজিটর/রোগীর জন্য)](#ফ্রন্ট-এন্ড-ফিচার)
4. [Patient Portal](#patient-portal)
5. [Doctor Portal](#doctor-portal)
6. [Admin Panel — সম্পূর্ণ মডিউল তালিকা](#admin-panel)
7. [থার্ড-পার্টি ইন্টিগ্রেশন ও API Key সেটআপ](#থার্ড-পার্টি-ইন্টিগ্রেশন)
8. [Technical Notes](#technical-notes)

---

## প্রাথমিক সেটআপ

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
npm run build
php artisan serve
```

সাইট চালু হবে: `http://127.0.0.1:8000`

---

## লগইন তথ্য

| Portal                   | URL              | Email/Phone                            | Password |
| ------------------------ | ---------------- | -------------------------------------- | -------- |
| **Admin (Super Admin)**  | `/admin/login`   |
| **Admin (Branch Admin)** | `/admin/login`   |
| **Admin (Editor)**       | `/admin/login`   |
| **Patient**              | `/patient/login` | নিজে রেজিস্টার করো                     | —        |
| **Doctor**               | `/doctor/login`  | Admin থেকে email/password সেট করতে হবে | —        |

> Doctor লগইন সক্রিয় করতে: Admin Panel → Doctors → কোনো ডাক্তার Edit করো → "Login Email" ও "Login Password" পূরণ করো।

---

## ফ্রন্ট-এন্ড ফিচার

### মূল পেজসমূহ

| ফিচার                | URL                   | বর্ণনা                                                                                                                                                                                                         |
| -------------------- | --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| হোমপেজ               | `/`                   | Hero Slider (dynamic CTA সহ), Quick Search, Hospital/Diagnostic ট্যাব, Accreditation, About+Stats, Major Departments, Doctor's Talk ভিডিও, Doctors Carousel, Latest News, Sister Concerns, Google Rating badge |
| ডাক্তার তালিকা       | `/doctors`            | Department/Hospital ফিল্টার, নাম সার্চ, pagination                                                                                                                                                             |
| ডাক্তার প্রোফাইল     | `/doctors/{slug}`     | বায়ো, রেটিং ও রিভিউ, Book Appointment, Social Share                                                                                                                                                           |
| বিভাগসমূহ            | `/departments`        | তালিকা ও বিস্তারিত পেজ                                                                                                                                                                                         |
| হাসপাতালসমূহ         | `/hospitals`          | তালিকা, বিস্তারিত পেজ (Interactive Map সহ)                                                                                                                                                                     |
| ডায়াগনস্টিক সেন্টার | `/diagnostics`        | তালিকা ও বিস্তারিত পেজ                                                                                                                                                                                         |
| প্যাকেজ              | `/packages`           | Health Checkup প্যাকেজ, Individual Test লিস্ট সহ                                                                                                                                                               |
| টেস্ট তালিকা         | `/tests`              | আলাদা টেস্ট সার্চ ও মূল্য                                                                                                                                                                                      |
| অ্যাপয়েন্টমেন্ট     | `/book-appointment`   | Time-slot ভিত্তিক বুকিং, ডাক্তার শিডিউল অনুযায়ী available date/time দেখায়                                                                                                                                    |
| Online Report        | `/online-report`      | Report ID + Phone দিয়ে রিপোর্ট ডাউনলোড (Letterhead PDF + QR Code)                                                                                                                                             |
| Video Consultation   | `/video-consultation` | ভিডিও কনসালটেশন রিকোয়েস্ট ফর্ম (Jitsi Meet ভিত্তিক)                                                                                                                                                           |
| Blood Bank           | `/blood-bank`         | Donor খোঁজা, Donor রেজিস্ট্রেশন, Blood Request পোস্ট                                                                                                                                                           |
| Ambulance            | `/ambulance`          | অ্যাম্বুলেন্স রিকোয়েস্ট (Emergency flag সহ)                                                                                                                                                                   |
| Bed Availability     | `/bed-availability`   | Live ward-ভিত্তিক বেড সংখ্যা                                                                                                                                                                                   |
| Live Queue           | `/live-queue`         | পাবলিক ডিসপ্লে স্ক্রিন (TV/মনিটরের জন্য), ৩০s auto-refresh                                                                                                                                                     |
| Pharmacy             | `/pharmacy`           | ওষুধ সার্চ, দাম ও স্টক দেখা                                                                                                                                                                                    |
| Career               | `/career`             | চাকরির বিজ্ঞপ্তি + CV আপলোড আবেদন                                                                                                                                                                              |
| Notice Board         | `/notices`            | Tender/Notice/Circular/Announcement                                                                                                                                                                            |
| FAQ                  | `/faq`                | Category-ভিত্তিক accordion প্রশ্নোত্তর                                                                                                                                                                         |
| Contact              | `/contact-us`         | ফর্ম + Google Map                                                                                                                                                                                              |
| Global Search        | Header সার্চ আইকন     | Doctor, Package, Test, News ইত্যাদি সব একসাথে সার্চ                                                                                                                                                            |
| Custom Pages         | `/page/{slug}`        | Admin থেকে বানানো যেকোনো পেজ (Privacy Policy ইত্যাদি)                                                                                                                                                          |

### About সেকশন

- `/about/md-message` — MD's Message
- `/about/about-us` — About Us
- `/about/accreditation` — NABH/CAP Accreditation
- `/about/sister-concerns` — Sister Concerns
- `/about/corporate-tieup` — Corporate ও Insurance Tie-ups
- `/about/awards` — Awards & Recognition
- `/about/csr` — CSR কার্যক্রম

### Media সেকশন

- `/media/news` — সংবাদ + কমেন্ট সিস্টেম
- `/media/gallery` — ছবি গ্যালারি
- `/media/offers` — অফারসমূহ
- `/media/videos` — ভিডিও তালিকা
- `/media/journal` — PDF জার্নাল

### ইন্টারেক্টিভ ফিচার

- 🌓 **Dark Mode** — টপবারে toggle বাটন, system-এর পছন্দ অনুযায়ী ডিফল্ট
- 🌍 **Bilingual (EN/BN)** — টপবারে ভাষা পরিবর্তন
- ⬆️ **Scroll to Top** বাটন
- 💬 **WhatsApp** floating বাটন (Settings-এ নম্বর বসালে চালু হয়)
- 🗨️ **Live Chat** (Tawk.to) — Settings-এ চালু/বন্ধ করা যায়
- ♿ **Accessibility Widget** — Font size (A/A+/A++), High Contrast mode
- 📱 **PWA** — মোবাইলে "Add to Home Screen" করা যায়
- 📧 **Newsletter** — ফুটারে subscribe ফর্ম
- ⭐ **Doctor Review System** — ৫-স্টার রেটিং + লিখিত রিভিউ (Admin approve করার পর পাবলিক)
- 💬 **News Comment System** — কমেন্ট + রিপ্লাই, Admin থেকে জবাব দেওয়া যায় ("Hospital Reply" ব্যাজ সহ)
- 💳 **Online Payment** — SSLCommerz (bKash/Nagad/Card/Net Banking), Package বা Invoice পে করা যায়

---

## Patient Portal

**লগইন:** `/patient/register` (নতুন অ্যাকাউন্ট) অথবা `/patient/login`

রেজিস্ট্রেশন/লগইনের পর ভিজিটর হোমপেজে ফিরে যায় (ফোর্স redirect হয় না)। Topbar-এ নামের ড্রপডাউন থেকে "My Account"-এ ক্লিক করলে Dashboard-এ যাওয়া যায়।

| পেজ             | URL                     | কাজ                               |
| --------------- | ----------------------- | --------------------------------- |
| Dashboard       | `/patient/dashboard`    | সব কিছুর সংক্ষিপ্ত সারাংশ         |
| My Appointments | `/patient/appointments` | বুক করা অ্যাপয়েন্টমেন্টের তালিকা |
| My Reports      | `/patient/reports`      | নিজের ল্যাব রিপোর্ট ডাউনলোড       |
| My Invoices     | `/patient/invoices`     | বিলিং ইতিহাস                      |
| My Profile      | `/patient/profile`      | প্রোফাইল এডিট, পাসওয়ার্ড বদল     |

**অটো-লিংকিং:** লগইন থাকা অবস্থায় Appointment বুক করলে, অথবা রেজিস্টার করা ইমেইল/ফোন দিয়ে Invoice/Online Report তৈরি হলে — এগুলো অটো Patient অ্যাকাউন্টের সাথে যুক্ত হয়ে যায়।

---

## Doctor Portal

**লগইন:** `/doctor/login` (Admin থেকে email/password সেট করতে হবে)

| পেজ             | URL                    | কাজ                                        |
| --------------- | ---------------------- | ------------------------------------------ |
| Dashboard       | `/doctor/dashboard`    | আজকের অ্যাপয়েন্টমেন্ট, মোট সংখ্যা, Rating |
| My Appointments | `/doctor/appointments` | নিজের সব অ্যাপয়েন্টমেন্ট, Status বদলানো   |
| My Schedule     | `/doctor/schedule`     | নিজের weekly schedule দেখা (view-only)     |

---

## Admin Panel

**লগইন:** `/admin/login`

### Sidebar Groups

#### 📊 Overview

- **Dashboard** — Gradient stats card, Appointment Trend chart, Status Doughnut chart, Monthly Patient Combo chart, Top Doctors/Departments leaderboard, Patient Statistics সারাংশ, Content Overview, Quick Actions

#### 🏥 Medical Content

| মডিউল       | কাজ                                                                                          |
| ----------- | -------------------------------------------------------------------------------------------- |
| Doctors     | CRUD + Image + SEO fields + Login credentials + **Schedule** (weekly time-slot + Leave days) |
| Departments | CRUD + Featured flag (হোমপেজে দেখানোর জন্য)                                                  |
| Hospitals   | CRUD + Interactive Map picker (click করে lat/lng বসানো) + Bed Availability                   |
| Diagnostics | CRUD + Map picker                                                                            |
| Packages    | CRUD + Individual Test attach (checkbox)                                                     |
| Tests       | CRUD (নাম, দাম, sample type, report time, preparation)                                       |

#### 📰 Media

- News, Gallery, Offers, Videos (হোমপেজে Featured করা যায়), Journals, Sliders (Dynamic CTA সহ), Sister Concerns
- **About Content** — MD's Message, About text, Stats (patients/staff/doctors) — একটামাত্র এন্ট্রি, হোমপেজে রিফ্লেক্ট হয়
- **Accreditations** — NABH/CAP লোগো ও বিবরণ
- **Custom Pages** — যেকোনো নতুন পেজ (Privacy Policy ইত্যাদি), Header/Footer মেনুতে auto যোগ হওয়ার অপশন
- **Showcase (Corp/Award/CSR)** — Corporate Tie-up, Awards, CSR তিনটাই একই মডিউল থেকে ম্যানেজ

#### 📅 Management

| মডিউল                                | কাজ                                                                                               |
| ------------------------------------ | ------------------------------------------------------------------------------------------------- |
| Hospital Stats                       | Daily patient admitted/discharged/test-only এন্ট্রি + Reports (Daily/Weekly/Monthly/Yearly চার্ট) |
| Invoices                             | ম্যানুয়াল ইনভয়েস তৈরি, Auto invoice number, PDF + QR Code                                       |
| Online Payments                      | SSLCommerz-এর সব লেনদেনের ইতিহাস                                                                  |
| Appointments                         | সব অ্যাপয়েন্টমেন্ট, Status বদলানো (রোগীকে SMS/Email notification যায়)                           |
| Online Reports                       | রিপোর্ট এন্ট্রি (PDF আপলোড অথবা ম্যানুয়াল টেস্ট রেজাল্ট দিয়ে auto-PDF জেনারেট)                  |
| Messages                             | Contact ফর্মের বার্তা                                                                             |
| Doctor Reviews                       | রিভিউ Approve/Reject/Delete                                                                       |
| Comments                             | News কমেন্ট moderation + Admin reply                                                              |
| Notifications                        | সব নোটিফিকেশনের history                                                                           |
| Video Consultations                  | রিকোয়েস্ট Approve করে Schedule+Meeting link তৈরি                                                 |
| Blood Donors / Blood Requests        | Donor verify, Request fulfill মার্ক করা                                                           |
| Ambulance Requests / Ambulance Fleet | গাড়ি assign, status track                                                                        |
| Bed Availability                     | Ward-ভিত্তিক বেড সংখ্যা আপডেট                                                                     |
| Live Queue                           | ডাক্তারের current serial আপডেট                                                                    |
| Medicines / Pharmacy Sales           | ওষুধ ইনভেন্টরি + POS (বিক্রি করলে স্টক অটো কমে)                                                   |
| Job Postings / Job Applications      | চাকরির বিজ্ঞপ্তি + CV review + status                                                             |
| Notice Board                         | Tender/Notice তৈরি, attachment আপলোড                                                              |
| Newsletter                           | Subscriber তালিকা + CSV export                                                                    |
| FAQ                                  | প্রশ্নোত্তর CRUD, category-ভিত্তিক                                                                |

#### ⚙️ System

| মডিউল                             | কাজ                                                                                                                                                                 |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Settings                          | Logo/Favicon, Contact info, Google Map, Maintenance Mode, SEO defaults, Analytics (GA4/GTM/FB Pixel), SMS/Email toggle, Live Chat, Theme Color+Font, Google Reviews |
| Backups                           | এক ক্লিকে Database+Files backup, Download/Delete                                                                                                                    |
| Branches _(Super Admin only)_     | ব্রাঞ্চ তৈরি, Map picker                                                                                                                                            |
| Admin Users _(Super Admin only)_  | নতুন Admin তৈরি, Role (Super Admin/Branch Admin/Editor), 2FA toggle                                                                                                 |
| Activity Log _(Super Admin only)_ | কে কখন কী Create/Update/Delete করলো                                                                                                                                 |

---

## থার্ড-পার্টি ইন্টিগ্রেশন

| সার্ভিস                          | কোথায় সেটআপ করবে      | প্রয়োজনীয় তথ্য                                                                                 |
| -------------------------------- | ---------------------- | ------------------------------------------------------------------------------------------------ |
| **Google Analytics**             | Settings → Analytics   | GA4 Measurement ID (`G-XXXXXXXXXX`)                                                              |
| **Google Tag Manager**           | Settings → Analytics   | GTM ID (`GTM-XXXXXXX`)                                                                           |
| **Facebook Pixel**               | Settings → Analytics   | Pixel ID                                                                                         |
| **Google Search Console**        | Settings → Analytics   | Verification meta tag-এর ভ্যালু অংশ                                                              |
| **SMS Gateway**                  | Settings → SMS & Email | API URL, API Key, Sender ID (BulkSMSBD/Alpha SMS ইত্যাদি)                                        |
| **Email (SMTP)**                 | `.env` ফাইল            | `MAIL_MAILER=smtp`, Gmail হলে App Password লাগবে                                                 |
| **Live Chat (Tawk.to)**          | Settings → Live Chat   | Property ID + Widget ID (তাদের embed script থেকে, `/` দিয়ে ভাগ করা দুই অংশ)                     |
| **Payment Gateway (SSLCommerz)** | `.env` ফাইল            | `SSLCZ_STORE_ID`, `SSLCZ_STORE_PASSWORD` (Sandbox Dashboard থেকে Regenerate করে নেওয়া password) |
| **Video Call (Jitsi Meet)**      | কিছু লাগে না           | সম্পূর্ণ ফ্রি, কোনো API key দরকার নেই                                                            |

---

## Technical Notes

### Theme Customization

Settings → Typography & Theme Color থেকে brand color (hex picker) ও site font পরিবর্তন করা যায়। পরিবর্তন সাথে সাথে কার্যকর হয় (CSS Variables ব্যবহার করে), কোনো rebuild লাগে না।

### Role-based Access (Branch System)

- **Super Admin** — সব কিছু দেখে/করতে পারে
- **Branch Admin** — শুধু নিজের branch-এর Doctor/Appointment/Stats দেখে, Settings/Backup/User Management দেখতে পারে না
- **Editor** — Content এডিট করতে পারে, কিন্তু Delete/Settings/Branches করতে পারে না

### PDF জেনারেশন

Online Report ও Invoice দুটোই DomPDF দিয়ে Letterhead-স্টাইল PDF জেনারেট করে, QR Code (SVG format, Imagick ছাড়াই কাজ করে) সহ। PDF-এ বাংলা ফন্ট সাপোর্ট নেই (ইংরেজি/সংখ্যা-ভিত্তিক স্ট্যান্ডার্ড মেডিকেল ফরম্যাট ব্যবহার করা হয়েছে)।

### Maintenance Mode

দুই স্তরের সিস্টেম:

1. Settings থেকে টগল করলে কাস্টম ডিজাইন করা মেসেজ পেজ দেখায় (Admin Panel স্বাভাবিক থাকে)
2. `php artisan down` কমান্ড দিলে Laravel-এর নিজস্ব 503 পেজ দেখায় (database-ও down থাকলেও কাজ করে)

### Scheduled Tasks (Cron প্রয়োজন)

`routes/console.php`-এ সেট করা আছে — production সার্ভারে cron job লাগবে:

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

এটা চালায়:

- `backup:clean` ও `backup:run` (প্রতিদিন)
- `model:prune` (পুরোনো notification মুছে ফেলা)

### Time-slot Appointment সিস্টেম

Doctor → Schedule পেজ থেকে সাপ্তাহিক সময়সূচি (কোন দিন, কোন সময়, কত মিনিট স্লট, এক স্লটে কতজন রোগী) সেট করতে হয়। সেট না থাকলে ফ্রন্ট-এন্ডে সাধারণ Date Input ফলব্যাক হিসেবে কাজ করে।

### Network/Timezone

`config/app.php`-এ timezone `Asia/Dhaka` সেট করা আছে — এটা বদলালে আগে থেকে সেভ করা datetime ভ্যালুগুলো (বিশেষ করে Video Consultation-এর `scheduled_at`) আবার এডিট করে সেভ করতে হবে।

---

## ফাইল স্ট্রাকচার সংক্ষেপ

```
app/
├── Http/Controllers/
│   ├── Front/      → ভিজিটর-facing সব কন্ট্রোলার
│   ├── Admin/       → Admin Panel কন্ট্রোলার
│   ├── Patient/     → Patient Portal কন্ট্রোলার
│   └── Doctor/      → Doctor Portal কন্ট্রোলার
├── Models/          → সব Eloquent Model
├── Services/        → NotificationService, SmsService, SslcommerzService, SlotService
└── Traits/          → LogsActivity (Activity Log-এর জন্য)

resources/views/
├── front/           → ভিজিটর-facing ভিউ
├── admin/           → Admin Panel ভিউ
├── patient/         → Patient Portal ভিউ
├── doctor/          → Doctor Portal ভিউ
├── emails/          → ইমেইল টেমপ্লেট
└── partials/        → Header, Footer, Topbar, reusable component
```

---

## সাধারণ সমস্যা ও সমাধান

| সমস্যা                                        | সমাধান                                                                                                       |
| --------------------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| PDF-এ খালি বক্স/bangla ভাঙা দেখাচ্ছে          | DomPDF ডিফল্টভাবে বাংলা ফন্ট সাপোর্ট করে না, ইংরেজি ব্যবহার করো অথবা Noto Sans Bengali ফন্ট রেজিস্টার করো    |
| QR Code জেনারেট হচ্ছে না (Imagick error)      | `format('svg')` ব্যবহার করো, `format('png')` না — SVG কোনো extension ছাড়াই কাজ করে                          |
| SSLCommerz "Store Credential Error"           | Sandbox dashboard-এ গিয়ে Password "Regenerate" করো, placeholder/demo ভ্যালু ব্যবহার করলে এই error আসবে      |
| Email পাঠাচ্ছে না (Gmail)                     | সাধারণ পাসওয়ার্ড কাজ করবে না — Google Account → Security → App Passwords থেকে ১৬-ডিজিটের App Password বানাও |
| Appointment slot দেখাচ্ছে না                  | Admin → Doctors → সেই ডাক্তারের Schedule সেট করা আছে কিনা চেক করো                                            |
| Dropdown মেনু অন্য element-এর নিচে চলে যাচ্ছে | z-index conflict — পাশাপাশি থাকা floating element-গুলোর z-index আলাদা রাখো                                   |

---

_এই ডকুমেন্টেশন প্রজেক্টের সম্পূর্ণ ফিচার সেট কভার করে। নতুন ফিচার যোগ হলে এই ফাইল আপডেট রাখার পরামর্শ দেওয়া হচ্ছে।_
