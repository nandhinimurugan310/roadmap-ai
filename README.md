# 🧠 AI Roadmap Generator – Aryng Project

This is a full-stack Laravel application that collects lead information via a form and initiates a chat with an AI assistant powered by OpenAI (ChatGPT). After logout a full roadmap PDF is generated from the chat and emailed to a predefined address.

---

## 🚀 Features

- ✅ Responsive and modern UI (ChatGPT-like)
- ✅ Lead form with validation
- ✅ Session-based AI chat using OpenAI GPT-3.5
- ✅ Full chat transcript converted to PDF
- ✅ Email roadmap PDF to predefined email address (`nandhiniecesrit@gmail.com`)
- ✅ Smooth logout with overlay loader
- ✅ Built using Laravel 12 + Bootstrap 5 + jQuery

---

## 📦 Tech Stack

| Layer        | Tool/Library                    |
|-------------|---------------------------------|
| Backend      | Laravel 12 (PHP 8.2+)           |
| Frontend     | Blade, Bootstrap 5.3, jQuery    |
| AI API       | OpenAI (gpt-3.5-turbo)          |
| PDF Export   | DomPDF (`barryvdh/laravel-dompdf`) |
| Email        | Laravel Mail (configured for Gmail) |
| Storage      | Laravel Filesystem              |
| Database     | MySQL (via XAMPP)               |

---

## ⚙️ Setup Instructions (Local)

> These steps assume you're using **XAMPP** or similar local setup with MySQL and PHP.

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/nandhinimurugan310/roadmap-ai
cd roadmap-ai

###2️⃣ Install PHP Dependencies
composer install

###3️⃣ Create Environment File
cp .env.example .env

###4️⃣ Set .env Variables

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_roadmap
DB_USERNAME=root
DB_PASSWORD=


MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=nandhinimurugan310@gmail.com
MAIL_PASSWORD=larfnzuatttorxwy
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nandhinimurugan310@gmail.com
MAIL_FROM_NAME="Aryng AI Assistant"



OPENAI_API_KEY=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
OPENAI_ASSISTANT_ID=asst_xQPIgAQbOP5fq1Z2b1nZ88Dm

###5️⃣ Generate Key and Link Storage
php artisan key:generate
php artisan storage:link

###6️⃣ Run Migrations
php artisan migrate

###7️⃣ Start Local Server
php artisan serve
Visit: http://localhost:8000

✍️ Usage Flow
User submits lead form (name, email, job title, etc.)

Redirects to Chat page with ChatGPT UI

User chats with AI assistant

On logout, full chat is turned into a PDF

PDF is emailed to nandhiniecesrit@gmail.com

User is returned to the form page

📂 Folder Structure
css
Copy
Edit
app/
├── Http/
│   ├── Controllers/
│   │   ├── LeadController.php
│   │   └── ChatWebController.php
├── Mail/
│   └── RoadmapMail.php
├── Models/
│   └── Lead.php

resources/
└── views/
    ├── form.blade.php
    └── chat.blade.php


📬 Sample Email Output
PDF file: ai_roadmap_1718329453.pdf

Includes lead details + full chat transcript

Sent from your Gmail account via SMTP
🧑‍💻 Developed By
Nandhini M
Senior Full Stack Developer – Chennai
Email: nandhinimurugan310@gmail.com
