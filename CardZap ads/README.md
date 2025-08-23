# CardZap - Progressive Web Application for Flashcard Learning

CardZap is a modern, responsive progressive web application designed for creating and studying flashcards from documents and PDFs. It supports multiple user types (Admin, Teacher, Student) with comprehensive features for educational content management.

## 🚀 Features

### For Administrators
- **Dashboard Analytics**: Overview of platform statistics including user counts, subject creation, and student progress
- **User Management**: View, edit, and delete student and teacher accounts
- **Subject Management**: Monitor and manage all created subjects/rooms
- **Search Functionality**: Advanced search capabilities across all user types and subjects

### For Teachers
- **Profile Management**: Complete profile with created subjects overview
- **Flashcard Creation**: Create flashcards from documents or PDF materials
- **Content Editing**: Edit and manage created flashcard decks
- **Game Modes**: Support for classic and quiz game modes
- **Subject Management**: Create and manage subjects/rooms for student enrollment
- **Enrollment Management**: Accept/reject student enrollment requests
- **Student Analytics**: Track student progress and performance in subjects

### For Students
- **Personal Profile**: Profile page with personal info and progress analytics
- **Flashcard Creation**: Create personal flashcards from documents or PDFs
- **Content Management**: Edit and organize personal flashcard decks
- **Game Modes**: Access to classic and quiz study modes
- **Social Features**: Add friends and invite to co-op study sessions
- **Subject Enrollment**: Search and enroll in teacher-created subjects
- **Progress Tracking**: Comprehensive analytics for personal and subject-based progress

### Technical Features
- **Progressive Web App (PWA)**: Installable app with offline functionality
- **Responsive Design**: Optimized for all screen sizes (desktop, tablet, mobile)
- **Modern UI/UX**: Clean, intuitive interface with smooth animations
- **Real-time Updates**: Live scoreboards and progress tracking
- **Offline Support**: Cached content for offline study sessions

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 8.0+
- **PWA Features**: Service Workers, Web App Manifest
- **Styling**: Custom CSS Framework with CSS Variables
- **Fonts**: Inter (Google Fonts)

## 📁 Project Structure

```
CardZap/
├── css/
│   ├── main.css              # Main CSS framework
│   ├── loginpage.css         # Login page styles
│   ├── admin_homepage.css    # Admin dashboard styles
│   └── [other page styles]
├── javascript/
│   ├── main.js              # Main JavaScript framework
│   └── [other page scripts]
├── php/
│   ├── db.php               # Database connection & schema
│   ├── loginpage.php        # Login functionality
│   ├── signinpage.php       # Registration functionality
│   ├── admin_homepage.php   # Admin dashboard
│   ├── student_yourcards.php # Student card management
│   ├── teacher_yourcards.php # Teacher card management
│   └── [other PHP files]
├── manifest.json            # PWA manifest
├── sw.js                   # Service worker
├── offline.html            # Offline page
└── README.md              # This file
```

## 🗄️ Database Schema

### Core Tables
- **user_info**: User accounts (students, teachers, admins)
- **login_logs**: User login tracking
- **friends**: Student friendship relationships
- **friends_requests**: Friend request management
- **subjects**: Teacher-created subjects/rooms
- **enrollments**: Student subject enrollments
- **card_decks**: Flashcard deck metadata
- **cards**: Individual flashcard content
- **study_sessions**: Learning session tracking
- **coop_lobbies**: Multiplayer study sessions
- **coop_participants**: Co-op session participants
- **recent_cards**: Recently accessed decks

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 8.0 or higher
- Web server (Apache/Nginx)
- Modern web browser with PWA support

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd CardZap
   ```

2. **Configure database**
   - Create a MySQL database
   - Update database credentials in `php/db.php`
   - The application will automatically create tables on first run

3. **Web server configuration**
   - Point your web server to the CardZap directory
   - Ensure PHP has write permissions for session management

4. **Access the application**
   - Navigate to `http://your-domain/php/loginpage.php`
   - Default admin credentials:
     - Email: `admin@cardzap.com`
     - Password: `admin123`

### PWA Installation
1. Open the application in a modern browser
2. Look for the install prompt or use browser menu
3. Install the app for offline access

## 🎨 Design System

### Color Palette
- **Primary**: #2563eb (Blue)
- **Success**: #10b981 (Green)
- **Warning**: #f59e0b (Yellow)
- **Danger**: #ef4444 (Red)
- **Neutral**: Gray scale from #f9fafb to #111827

### Typography
- **Font Family**: Inter (Google Fonts)
- **Font Weights**: 400, 500, 600, 700
- **Responsive**: Scales from 0.75rem to 2.25rem

### Components
- **Cards**: Rounded corners with subtle shadows
- **Buttons**: Multiple variants (primary, secondary, success, danger)
- **Forms**: Consistent styling with focus states
- **Modals**: Overlay dialogs with backdrop blur
- **Tables**: Responsive with hover effects

## 📱 Responsive Design

The application is fully responsive with breakpoints:
- **Desktop**: 1024px and above
- **Tablet**: 768px - 1023px
- **Mobile**: Below 768px

### Mobile Features
- Collapsible sidebar navigation
- Touch-friendly interface elements
- Optimized form inputs
- Swipe gestures for card navigation

## 🔧 PWA Features

### Service Worker
- **Caching Strategy**: Network-first for dynamic content, cache-first for static assets
- **Offline Support**: Cached pages and assets available offline
- **Background Sync**: Queued actions sync when connection restored

### Web App Manifest
- **Installable**: Can be installed on desktop and mobile
- **App-like Experience**: Full-screen mode, custom icons
- **Shortcuts**: Quick access to common actions

### Offline Functionality
- **Cached Content**: Previously viewed pages available offline
- **Offline Page**: Custom offline experience
- **Auto-retry**: Automatic reconnection attempts

## 🔒 Security Features

- **Session Management**: Secure PHP sessions
- **Password Hashing**: bcrypt password encryption
- **Input Sanitization**: All user inputs sanitized
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Output escaping
- **CSRF Protection**: Form token validation

## 🚀 Performance Optimizations

- **CSS Optimization**: Efficient selectors and minimal reflows
- **JavaScript Optimization**: Debounced events, efficient DOM queries
- **Image Optimization**: Responsive images with appropriate formats
- **Caching**: Browser and service worker caching
- **Lazy Loading**: Deferred loading of non-critical resources

## 🔄 Recent Improvements

### UI/UX Enhancements
- **Modern Design System**: Consistent color palette and typography
- **Responsive Layout**: Mobile-first approach with breakpoint optimization
- **Interactive Elements**: Hover effects, transitions, and animations
- **Accessibility**: ARIA labels, keyboard navigation, screen reader support

### Code Quality
- **Modular Architecture**: Separated concerns with reusable components
- **CSS Framework**: Custom framework with utility classes
- **JavaScript Framework**: Organized utilities and event handling
- **Database Schema**: Normalized structure with proper relationships

### PWA Implementation
- **Service Worker**: Offline functionality and caching
- **Web App Manifest**: Installable app configuration
- **Offline Page**: Custom offline experience
- **Background Sync**: Offline action queuing

## 🧪 Testing

### Browser Compatibility
- **Chrome**: 88+
- **Firefox**: 85+
- **Safari**: 14+
- **Edge**: 88+

### PWA Testing
- **Lighthouse**: 90+ PWA score
- **Offline Functionality**: Verified offline access
- **Installation**: Tested on multiple platforms

## 📈 Future Enhancements

### Planned Features
- **Document Processing**: AI-powered document to flashcard conversion
- **Advanced Analytics**: Detailed learning insights and recommendations
- **Social Features**: Study groups and collaborative learning
- **Gamification**: Points, badges, and leaderboards
- **API Integration**: Third-party educational content

### Technical Improvements
- **Performance**: Further optimization and lazy loading
- **Security**: Enhanced authentication and authorization
- **Scalability**: Database optimization and caching strategies
- **Accessibility**: WCAG 2.1 AA compliance

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

## 🙏 Acknowledgments

- Inter font family by Google Fonts
- Modern CSS techniques and best practices
- PWA development community
- Educational technology research

---

**CardZap** - Transforming learning through technology 📚✨
