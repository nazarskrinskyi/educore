# Page Configuration System

## Overview

The Page Configuration system allows administrators to dynamically manage content for various pages in the EduCore application through the Filament admin panel.

## Features

- **Dynamic Content Management**: Edit page content without touching code
- **Visual Editor**: User-friendly interface for common fields
- **JSON Support**: Advanced users can edit raw JSON for complex configurations
- **Multi-Section Support**: Each page can have multiple configurable sections
- **Active/Inactive Toggle**: Control which sections are displayed
- **Ordering**: Control the display order of sections

## Accessing Page Configurations

1. Log in to the Filament admin panel at `/admin`
2. Navigate to **Content Management** → **Page Configurations**
3. You can create, edit, or delete page configurations

## Supported Pages

- **Welcome Page** (`welcome`)
  - Hero Section
  - Features Section
  - Stats Section

- **Dashboard** (`dashboard`)
  - Hero/Carousel Section
  - Platforms Section
  - About Section
  - Features Section
  - Certifications Section

## Configuration Structure

Each page configuration consists of:

- **Page Name**: The page identifier (e.g., 'welcome', 'dashboard')
- **Section Key**: Unique identifier for the section (e.g., 'hero', 'features')
- **Content**: JSON object containing the section data
- **Order**: Display order (lower numbers appear first)
- **Is Active**: Whether the section is currently displayed

## Example: Welcome Page Hero Section

```json
{
  "title": "Welcome to EduCore",
  "subtitle": "Transform Your Educational Institution",
  "description": "The complete educational management system for modern learning institutions.",
  "cta_primary": "Get Started",
  "cta_secondary": "Learn More"
}
```

## Example: Features Section

```json
{
  "title": "Why Choose EduCore?",
  "subtitle": "Comprehensive Features for Modern Education",
  "features": [
    {
      "icon": "dashboard",
      "title": "Unified Dashboard",
      "description": "Centralized control panel for all educational operations"
    },
    {
      "icon": "attendance",
      "title": "Smart Attendance",
      "description": "Automated attendance tracking with real-time notifications"
    }
  ]
}
```

## Example: Stats Section

```json
{
  "title": "Trusted by Institutions Worldwide",
  "stats": [
    {
      "value": "500+",
      "label": "Institutions"
    },
    {
      "value": "100K+",
      "label": "Students"
    }
  ]
}
```

## Available Icons for Features

- `dashboard` - Dashboard/Home icon
- `attendance` - Checklist/Attendance icon
- `analytics` - Chart/Analytics icon
- `security` - Lock/Security icon
- `parent` - Users/Parent icon
- `support` - Support/Help icon

## Seeding Default Data

To populate the database with default page configurations:

```bash
php artisan db:seed --class=PageConfigurationSeeder
```

## Using in Controllers

```php
use App\Models\PageConfiguration;

$pageConfig = PageConfiguration::getPageConfig('welcome');

return Inertia::render('Welcome', [
    'pageConfig' => $pageConfig,
]);
```

## Using in Vue Components

```vue
<script setup>
const props = defineProps({
    pageConfig: {
        type: Object,
        default: () => ({}),
    },
});

const hero = computed(() => props.pageConfig.hero || {
    title: 'Default Title',
    subtitle: 'Default Subtitle',
});
</script>

<template>
    <h1>{{ hero.title }}</h1>
    <p>{{ hero.subtitle }}</p>
</template>
```

## Admin Edit Buttons

For administrators, edit buttons are displayed on the frontend to quickly access the configuration editor:

```vue
<div v-if="$page.props.auth.is_admin" class="mb-4 flex justify-center">
    <Link
        :href="route('filament.admin.resources.page-configurations.edit', { record: 'welcome-hero' })"
        class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-4 py-2 text-sm text-white hover:bg-gray-700 transition-colors"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        Edit Section
    </Link>
</div>
```

## Best Practices

1. **Always provide fallback data** in computed properties to prevent errors if configuration is missing
2. **Use semantic section keys** (e.g., 'hero', 'features', 'stats')
3. **Keep JSON structure consistent** across similar sections
4. **Test changes** in a development environment before deploying
5. **Backup configurations** before making major changes

## Troubleshooting

### Configuration not showing up

1. Check if the section is marked as active (`is_active = true`)
2. Verify the page name and section key match what's used in the controller
3. Clear cache: `php artisan cache:clear`

### JSON validation errors

1. Ensure JSON is properly formatted
2. Use the visual editor for common fields
3. Validate JSON using online tools before saving

## Future Enhancements

- Image upload integration
- Version history for configurations
- Preview mode before publishing
- Import/Export configurations
- Multi-language support
