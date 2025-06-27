# Vue 3 Multistep Lead Capture Form

This project is a professional, production-ready multistep lead capture form built with Vue 3 (Composition API), Pinia for state management, Axios for API integration, and custom CSS (no Tailwind). It is designed to work with a Laravel backend API.

## Features
- Vue 3 Composition API
- Pinia global state management
- Axios for API requests
- Multistep form with validation on each step
- Custom, responsive CSS (no Tailwind)
- Professional UI/UX
- API integration for POST and dynamic GET

## Steps
1. **Your Details**: Name, Email, Company Name, Website URL (all required, validated)
2. **Website Details**: Website type selection (required)
3. **Platform Selection**: Platform options fetched dynamically from API based on website type (required)
4. **Review & Submit**: Review all info, go back to edit, submit to backend

## Setup

### Prerequisites
- Node.js 20+
- npm 10+
- Backend API running at `http://127.0.0.1:8000/api`

### Install dependencies
```sh
npm install
```

### Run the development server
```sh
npm run dev
```

The app will be available at [http://localhost:5173](http://localhost:5173).

## API Endpoints
- **POST** `/leads` — Submits the form data. Expects:
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
- **GET** `/platform-types/{type}` — Returns available platforms for the selected website type. Expects a response like:
  ```json
  { "platforms": ["Shopify", "WooCommerce", ...] }
  ```

## Customization
- All styles are in `src/index.css`.
- Steps are in `src/components/` as `FormStepOne.vue`, `FormStepTwo.vue`, etc.
- State is managed in `src/stores/leadFormStore.js`.
- API base URL is set in `src/main.js`.

## Troubleshooting
- **CORS errors:**
  - Make sure your backend allows `http://localhost:5173` and `http://127.0.0.1:5173` in its CORS config.
- **Validation not working:**
  - Each step handles its own validation. The "Next" button is only enabled if the current step is valid.
- **API errors:**
  - Check your browser console and network tab for error details.

## License
MIT
