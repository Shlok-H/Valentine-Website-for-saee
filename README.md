# Valentine's Day Website for Sakshi 💝

A beautiful, romantic website created to propose to Sakshi on Valentine's Day!

## 🎁 What's Included

### Modified Files:
1. **thankyou.html** - Thank you page with diary/card feature
   - "Click Me Hehehe" button goes directly to gifts page
   - Clicking the card opens it with "Go Back, Pretty" button to close

2. **gifts.html** - Gift selection page
   - Added "Last Page" button at the bottom

3. **final.html** - Final gratitude and review page
   - Heartfelt message to Sakshi
   - Cute propose GIF
   - Star rating system (1-5 stars)
   - Feedback form
   - Saves user reviews with location/browser data

4. **save_review.php** - Backend PHP script
   - Handles saving feedback to messages.json
   - Captures IP address, location, browser details
   - Creates/updates messages.json file automatically

## 📋 Setup Instructions

### Option 1: With PHP Backend (Full Functionality)

1. **Requirements:**
   - Web server with PHP support (Apache, Nginx, or local server like XAMPP/WAMP)
   - PHP 7.0 or higher

2. **Installation:**
   ```bash
   # Upload all files to your web server
   - index.html
   - thankyou.html
   - gifts.html
   - final.html
   - save_review.php
   - gift2.html
   - gift3.html
   - intro.html
   - gifticon.png
   ```

3. **Set Permissions:**
   ```bash
   # Make sure save_review.php has write permissions
   chmod 644 save_review.php
   chmod 666 messages.json  # Create this file or let PHP create it
   ```

4. **Access the website:**
   - Open `index.html` in your browser
   - Go through the flow: index → thankyou → gifts → final

### Option 2: Without Backend (Client-side Only)

If you don't have PHP, the website will still work!
- Reviews will be saved to browser's localStorage instead
- All features work except persistent server-side storage

## 🎯 User Flow

1. **index.html** - Valentine proposal page
   - "Will You Be My Valentine?" with Yes/No buttons
   - Yes → redirects to thankyou.html

2. **thankyou.html** - Thank you page
   - Card/diary with special message
   - "Click Me Hehehe" → goes to gifts.html
   - Clicking card → opens diary with "Go Back, Pretty" button

3. **gifts.html** - Choose a gift
   - Two gift boxes to click
   - "Last Page" button → goes to final.html

4. **final.html** - Final gratitude
   - Heartfelt message
   - Propose GIF animation
   - Star rating (1-5)
   - Text feedback
   - Submit button

## 📊 Review Data Saved

The `messages.json` file will contain:
```json
[
  {
    "id": "feedback_unique_id",
    "timestamp": "2026-02-05 12:30:45",
    "rating": 5,
    "message": "I loved it!",
    "visitor": {
      "ip": "192.168.1.1",
      "city": "Mumbai",
      "region": "Maharashtra",
      "country": "India",
      "latitude": "19.0760",
      "longitude": "72.8777",
      "timezone": "Asia/Kolkata"
    },
    "device": {
      "browser": "Chrome",
      "browserVersion": "121.0.0",
      "userAgent": "Mozilla/5.0...",
      "platform": "Win32",
      "language": "en-US",
      "screenResolution": "1920x1080"
    }
  }
]
```

## 🛠️ Troubleshooting

### Reviews not saving to messages.json?
1. Check if save_review.php has correct permissions
2. Verify PHP is enabled on your server
3. Check browser console for errors
4. As fallback, reviews save to browser localStorage

### Can't see the website properly?
1. Make sure all files are in the same directory
2. Check that gifticon.png exists
3. Verify internet connection (for external fonts/GIFs)

## 🎨 Features

- ✨ Beautiful gradient backgrounds
- 💖 Animated floating hearts and falling roses
- 🎁 Interactive gift boxes
- ⭐ Star rating system with hover effects
- 📱 Fully mobile responsive
- 💾 Automatic data collection (IP, location, browser)
- 🎊 Confetti animation on submission
- 🔄 Smooth page transitions

## 💝 Made with Love

This website was created with lots of love and care for Sakshi!
Every detail, animation, and interaction was thoughtfully designed to make her smile. 💕

---

**Need help?** Check the browser console (F12) for any error messages!
