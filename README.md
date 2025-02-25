# Thai Food Delivery App

A responsive PHP-based web application for food delivery, featuring a clean UI built with Tailwind CSS.
![Screenshot 2025-02-24 215711](https://github.com/user-attachments/assets/7d9cf706-d992-4ba7-84d1-7e6a0bb0f1b4)
![Screenshot 2025-02-24 215742](https://github.com/user-attachments/assets/124f4470-c5ce-4790-bd15-1cbb1c12fb43)
![Screenshot 2025-02-24 215802](https://github.com/user-attachments/assets/681af688-6884-42ab-9f71-2692f704045a)
![phpflutter](https://github.com/user-attachments/assets/6c04c650-b0fb-4d90-943c-87ad269f2826)

## 📋 Overview

This project implements a component-based UI architecture in PHP, creating a modern and responsive food delivery platform. The application includes the following features:

- Food browsing with categories and search functionality
- Shopping cart management
- User profile display
- Responsive design for both mobile and desktop devices

## 🚀 Features

### Component-Based Architecture
The application uses an object-oriented approach with abstract classes and inheritance to create reusable UI components:

- **UIComponent**: Abstract base class for all UI elements
- **UI Elements**: Text, Button, Column components
- **Domain-Specific Components**: FoodItem, CartItems, UserProfile, etc.

### User Interface
- **Home Page**: Browse food items, filter by categories, and search
- **Cart Page**: View and manage cart items, adjust quantities
- **Profile Page**: View user information and settings
- **Mobile-Responsive**: Adaptive layout with mobile navigation

### Styling
- Built with Tailwind CSS for utility-first styling
- Thai language support with the Prompt font
- Smooth animations and transitions

## 🧩 Components

### Core Components
- `UIComponent`: Abstract base class for all components
- `UIText`: Text display component
- `UIButton`: Button component with various styles
- `UIColumn`: Container for vertical layouts

### Specialized Components
- `AppBar`: Top navigation bar with mobile menu
- `CategoryPill`: Category filter buttons
- `FoodItem`: Food card display with image and details
- `CartItems`: Shopping cart item management
- `UserProfile`: User information display
- `SearchBar`: Food search functionality
- `Modal`: Modal dialog component
- `FloatingActionButton`: Fixed position action button

## 🏗️ Architecture

The app follows a simple component-based structure:

```
App (Main controller)
├── startPage() - HTML setup
├── endPage() - JavaScript and closing tags
├── getFoodItems() - Data provider
├── renderApp() - Assembles the UI components
└── run() - Entry point
```

## 🖥️ Technical Details

### Languages and Technologies
- PHP 7+ (OOP)
- HTML5
- CSS3 (Tailwind CSS)
- JavaScript (ES6)

### Key Features
- Session-based cart management
- Dynamic UI rendering
- Real-time filtering and search
- Mobile-responsive design

## 🔧 Setup and Installation

1. Clone the repository
2. Ensure you have a web server with PHP 7+ (Apache, Nginx, etc.)
3. Place the files in your web server's document root
4. Access the application through your web browser

## 🧠 Design Patterns

- **Composite Pattern**: UI components can contain other components
- **Template Method Pattern**: Abstract base class defines rendering methods
- **Factory Method**: Food items creation

## 🎨 Customization

To customize the application:

1. Modify the `getFoodItems()` method to add new food items
2. Adjust the Tailwind CSS classes in components to change styling
3. Add new category filters in the `renderApp()` method

## 📱 Mobile Considerations

The app is fully responsive with:
- Mobile menu for navigation
- Grid layout that adapts to screen size
- Touch-friendly buttons and controls
- Optimized cart view for small screens

## 🔍 Future Enhancements

Potential improvements for future versions:

- Backend integration with a database
- User authentication and account management
- Order history tracking
- Payment gateway integration
- Delivery tracking functionality
- Restaurant partnership system

## 📄 License

[MIT License](LICENSE)

## 🙏 Acknowledgements

- [Tailwind CSS](https://tailwindcss.com/)
- [Google Fonts](https://fonts.google.com/) for Prompt font
- Icon designs inspired by [Heroicons](https://heroicons.com/)
