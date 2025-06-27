# Multi-Step Lead Capture (Laravel + Vue 3)

A full-stack, production-ready multistep lead capture form with a Vue 3 frontend and Laravel backend API. Features robust validation, dynamic platform selection, OneSignal push notification integration, and professional UI/UX.

---

## Table of Contents
- [Requirements](#requirements)
- [Installation & Setup](#installation--setup)
- [Running Locally](#running-locally)
- [API Endpoints](#api-endpoints)
- [Live Deployment](#live-deployment)
- [Assumptions & Decisions](#assumptions--decisions)
- [Architecture Notes](#architecture-notes)
- [Troubleshooting](#troubleshooting)

---

## Requirements

### Backend
- PHP 8.2+
- Composer
- SQLite/MySQL/PostgreSQL
- Node.js & npm (for Laravel Mix, if needed)

### Frontend
- Node.js 20+
- npm 10+

---

## Installation & Setup

### 1. Clone the repository
```sh
git clone https://github.com/hardikt094/multi-step-laravel-vue
cd multi-step-laravel-vue
```

### 2. Backend Setup
```sh
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

#### OneSignal Integration
Add to your `.env`:
```
ONESIGNAL_APP_ID=your-onesignal-app-id
ONESIGNAL_API_KEY=your-onesignal-api-key
```

### 3. Frontend Setup
```sh
cd ../frontend
npm install
```

---

## Running Locally

### Start Backend
```sh
cd backend
php artisan serve
```
API available at: [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api)

### Start Frontend
```sh
cd frontend
npm run dev
```
App available at: [http://localhost:5173](http://localhost:5173)

---

## API Endpoints

### POST `/api/leads`
- Submits lead form data.
- Expects JSON:
```json
{
  "name": "...",
  "email": "...",
  "company_name": "...",
  "website_url": "...",
  "website_type": "...",
  "platform": "..."
}
```
- Returns success, lead data, and OneSignal notification status.

### GET `/api/platform-types/{type}`
- Returns available platforms for the selected website type.
- Example response:
```json
{ "platforms": ["Shopify", "WooCommerce", ...] }
```

---

## Live Deployment
- **Frontend:** [https://statuesque-gingersnap-b0d11d.netlify.app/](https://statuesque-gingersnap-b0d11d.netlify.app/)
- **Backend:** [https://multi-step-laravel-vue.onrender.com/](https://multi-step-laravel-vue.onrender.com/)

---

## Assumptions & Decisions
- All form steps require validation before proceeding.
- Platform options are hardcoded in backend for demo; can be made dynamic.
- OneSignal is used for push notifications on new lead submission.
- CORS is configured for local development and should be updated for production.

---

## Architecture Notes

### Database Structure
- **Leads Table:**
  - `id`, `name`, `email`, `company_name`, `website_url`, `website_type`, `platform`, `timestamps`

### Frontend State Management
- Uses **Pinia** for global state (`src/stores/leadFormStore.js`).
- Each form step is a separate Vue component (`FormStepOne.vue`, etc.), managed by `MultiStepForm.vue`.
- API base URL is set in `src/main.js`.

### OneSignal Integration
- On successful lead submission, backend triggers a OneSignal push notification to all subscribers.
- Requires `ONESIGNAL_APP_ID` and `ONESIGNAL_API_KEY` in backend `.env`.
- See `LeadController.php` for integration logic.

### Deployment Strategy
- **Backend:** Dockerized, deployed on [Render](https://render.com) using `render.yaml`.
- **Frontend:** Deployed on [Netlify](https://statuesque-gingersnap-b0d11d.netlify.app/).
- Environment variables and secrets managed via Render and Netlify dashboards.

### Trade-offs & Improvements
- Platform options are static; could be moved to DB or external API.
- No authentication on lead submission (for demo simplicity).
- No email confirmation or admin dashboard.
- More robust error handling and logging could be added.

---

## Troubleshooting
- **Validation errors:** Each step validates before proceeding; check browser console for details.
- **API errors:** Check backend logs and browser network tab.
