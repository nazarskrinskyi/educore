# Locale/Language Switcher Setup

This document describes the locale functionality implementation for English and Ukrainian languages.

## Features

- **Language Switcher Component**: A dropdown component in the top-right corner of the application
- **Two Languages**: English (en) and Ukrainian (uk)
- **Persistent Selection**: Language preference is stored in the session
- **Seamless Switching**: Language changes without page reload using Inertia.js

## Files Created/Modified

### Backend

1. **LocaleController** (`app/Http/Controllers/LocaleController.php`)
   - Handles language switching requests
   - Validates locale input (en or uk only)
   - Stores locale in session

2. **SetLocale Middleware** (`app/Http/Middleware/SetLocale.php`)
   - Automatically sets the application locale from session
   - Already registered in `bootstrap/app.php` (line 18)

3. **HandleInertiaRequests Middleware** (`app/Http/Middleware/HandleInertiaRequests.php`)
   - Already shares `locale` and `translations` with frontend (lines 48-55)

### Frontend

4. **LocaleSwitcher Component** (`resources/js/Components/LocaleSwitcher.vue`)
   - Dropdown component with flag icons
   - Shows current language
   - Allows switching between English and Ukrainian
   - Uses Inertia.js for seamless switching

5. **AuthenticatedLayout** (`resources/js/Layouts/AuthenticatedLayout.vue`)
   - Language switcher added to desktop navigation (next to profile dropdown)
   - Language switcher added to mobile navigation (next to hamburger menu)

6. **GuestLayout** (`resources/js/Layouts/GuestLayout.vue`)
   - Language switcher positioned in top-right corner

### Translations

7. **English Messages** (`lang/en/messages.php`)
   - Added language section with translation keys

8. **Ukrainian Messages** (`lang/uk/messages.php`)
   - Added language section with translation keys

### Routes

9. **Web Routes** (`routes/web.php`)
   - Route already exists: `POST /locale/switch` (line 22)

## Configuration

The default locale is set to Ukrainian in `config/app.php`:
- `locale` => 'uk'
- `fallback_locale` => 'en'

## Usage

### For Users

1. Click on the language switcher (flag icon) in the top-right corner
2. Select your preferred language from the dropdown
3. The page will update immediately with the new language

### For Developers

To use translations in your Vue components:

```vue
<template>
  <div>
    {{ $page.props.translations.nav.home }}
  </div>
</template>
```

Or access the current locale:

```vue
<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const currentLocale = page.props.locale; // 'en' or 'uk'
</script>
```

## Supported Languages

- **English (en)**: 🇬🇧 English
- **Ukrainian (uk)**: 🇺🇦 Українська

## How It Works

1. User clicks on language switcher
2. Component sends POST request to `/locale/switch` with selected locale
3. LocaleController validates and stores locale in session
4. SetLocale middleware reads locale from session on next request
5. Application locale is set automatically
6. Translations are shared with frontend via HandleInertiaRequests
7. UI updates with new language

## Testing

To test the locale functionality:

1. Visit any page in your application
2. Look for the language switcher in the top-right corner
3. Click on it and select a different language
4. Verify that the language changes (if translations are implemented)
5. Refresh the page - the selected language should persist

## Adding More Languages

To add more languages:

1. Create a new language folder in `lang/` (e.g., `lang/fr/`)
2. Add `messages.php` file with translations
3. Update `LocaleController.php` validation to include new locale
4. Update `SetLocale.php` middleware to support new locale
5. Add new language to `LocaleSwitcher.vue` component in the `locales` array

## Notes

- Language preference is stored in the session (not in database)
- If you want to persist language preference per user, you'll need to add a `locale` column to the users table
- The middleware is already registered in the web middleware group
- All translations are loaded and shared with the frontend automatically
