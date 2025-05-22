# Modern Landing Page - Laravel with Blade & Tailwind CSS

A clean, modern landing page built with Laravel, Blade templating, and Tailwind CSS.

## Features

-   Responsive design using Tailwind CSS
-   Clean, minimalist UI with soft blue color scheme
-   Animated components with smooth transitions
-   Mobile-first approach
-   Reusable Blade components
-   Modern hero section with gradient background
-   Feature cards with icons
-   Testimonial section
-   Contact form
-   Clean footer with navigation and social links

## Requirements

-   PHP 8.1+
-   Laravel 11+
-   Node.js & NPM
-   Composer

## Installation

1. Clone the repository
2. Install PHP dependencies:
    ```
    composer install
    ```
3. Install NPM dependencies:
    ```
    npm install
    ```
4. Copy the `.env.example` file to `.env` and configure your environment
    ```
    cp .env.example .env
    ```
5. Generate an application key:
    ```
    php artisan key:generate
    ```
6. Compile assets:
    ```
    npm run build
    ```
7. Start the development server:
    ```
    php artisan serve
    ```

## Project Structure

-   `resources/views/landing.blade.php` - Main landing page
-   `resources/views/components/` - Reusable Blade components
    -   `navbar.blade.php` - Navigation bar
    -   `footer.blade.php` - Page footer
    -   `feature-card.blade.php` - Feature card component
    -   `testimonial-card.blade.php` - Testimonial card component
-   `resources/views/layouts/app.blade.php` - Main layout template
-   `resources/css/app.css` - Custom Tailwind CSS styles
-   `resources/js/app.js` - JavaScript functionality

## Customization

### Colors

The main color scheme is based on Tailwind's blue palette with custom modifications in the `tailwind.config.js` file.

### Typography

The site uses Inter font family from Google Fonts. You can modify the font in the `tailwind.config.js` file.

### Components

All components are modular and can be easily modified or extended in the `resources/views/components/` directory.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
