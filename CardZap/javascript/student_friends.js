// Global variables
let notifications = [];
let friends = []; // Start with empty friends list
let friendRequests = [];
let searchResults = [];

// Sample user database for search
const userDatabase = [
  { id: 1, name: 'Wendy Alberona', level: 2, section: 'B', avatar: '👤' },
  { id: 2, name: 'John Smith', level: 3, section: 'A', avatar: '👤' },
  { id: 3, name: 'Maria Garcia', level: 1, section: 'C', avatar: '👤' },
  { id: 4, name: 'David Johnson', level: 4, section: 'B', avatar: '👤' },
  { id: 5, name: 'Sarah Wilson', level: 2, section: 'A', avatar: '👤' }
];

// DOM elements
const logoutBtn = document.querySelector('.logout-btn');
const notificationBtn = document.querySelector('.notification-btn');
const notificationPopup = document.querySelector('.notification-popup');
const notificationContent = document.querySelector('.notification-content');
const tabs = document.querySelectorAll('.tab');
const friendSearchInput = document.getElementById('friend-search');
const peopleSearchInput = document.getElementById('people-search');
const searchResultsContainer = document.getElementById('search-results');
const requestsListContainer = document.getElementById('requests-list');
const friendsTableBody = document.getElementById('friends-table-body');

// Initialize the page
function init() {
  setupEventListeners();
  updateNotificationDisplay();
  updateFriendsTable();
  updateRequestsList();
}

// Setup event listeners
function setupEventListeners() {
  // Logout functionality
  if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
      window.location.href = 'visitor_homepage.php';
    });
  }

  // Notification popup
  if (notificationBtn && notificationPopup) {
    notificationBtn.addEventListener('click', () => {
      notificationPopup.classList.toggle('show');
    });
  }

  // Tab switching
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const targetTab = tab.dataset.tab;
      switchTab(targetTab);
    });
  });

  // Search functionality
  if (friendSearchInput) {
    friendSearchInput.addEventListener('input', (e) => {
      searchFriends(e.target.value);
    });
  }

  if (peopleSearchInput) {
    peopleSearchInput.addEventListener('input', (e) => {
      searchPeople(e.target.value);
    });
  }

  // Close notification popup when clicking outside
  document.addEventListener('click', (e) => {
    if (!notificationBtn.contains(e.target) && !notificationPopup.contains(e.target)) {
      notificationPopup.classList.remove('show');
    }
  });
}

// Tab switching functionality
function switchTab(tabName) {
  // Update tab buttons
  tabs.forEach(tab => {
    tab.classList.remove('active');
    if (tab.dataset.tab === tabName) {
      tab.classList.add('active');
    }
  });

  // Show/hide content sections
  const contentSections = document.querySelectorAll('.friends-content');
  contentSections.forEach(section => {
    section.classList.add('hidden');
  });

  const targetSection = document.getElementById(`${tabName}-content`);
  if (targetSection) {
    targetSection.classList.remove('hidden');
  }
}

// Search friends
function searchFriends(query) {
  if (!query.trim()) {
    updateFriendsTable();
    return;
  }

  const filteredFriends = friends.filter(friend => 
    friend.name.toLowerCase().includes(query.toLowerCase())
  );

  updateFriendsTable(filteredFriends);
}

// Search people
function searchPeople(query) {
  if (!query.trim()) {
    searchResultsContainer.innerHTML = '<div class="no-friends-message">Search for people to add as friends.</div>';
    return;
  }

  const results = userDatabase.filter(user => 
    user.name.toLowerCase().includes(query.toLowerCase()) &&
    !friends.some(friend => friend.id === user.id)
  );

  displaySearchResults(results);
}

// Display search results
function displaySearchResults(results) {
  if (results.length === 0) {
    searchResultsContainer.innerHTML = '<div class="no-friends-message">No users found.</div>';
    return;
  }

  searchResultsContainer.innerHTML = results.map(user => `
    <div class="search-result-item">
      <div class="search-result-info">
        <div class="avatar">${user.avatar}</div>
        <div>
          <div class="search-result-name">${user.name}</div>
          <div class="search-result-details">Level ${user.level} • Section ${user.section}</div>
        </div>
      </div>
      <button class="action-btn follow-btn" onclick="sendFriendRequest(${user.id})">Follow</button>
    </div>
  `).join('');
}

// Send friend request
function sendFriendRequest(userId) {
  const user = userDatabase.find(u => u.id === userId);
  if (!user) return;

  // Add to friend requests (simulating sending to another user)
  const request = {
    id: Date.now(),
    fromUserId: 999, // Current user ID
    fromUserName: 'You',
    toUserId: userId,
    toUserName: user.name,
    timestamp: new Date()
  };

  // Add to friend requests list (simulating the other user receiving it)
  friendRequests.push(request);
  
  // Simulate notification to the other user
  addNotification(`${user.name} received your friend request`, 'friend-request');
  
  // Update the button
  const button = event.target;
  button.textContent = 'Request Sent';
  button.disabled = true;
  button.style.background = '#6c757d';
  
  // Update requests list
  updateRequestsList();
}

// Accept friend request
function acceptFriendRequest(requestId) {
  const request = friendRequests.find(r => r.id === requestId);
  if (!request) return;

  // Add to friends list
  const newFriend = userDatabase.find(u => u.id === request.fromUserId);
  if (newFriend) {
    friends.push({
      id: newFriend.id,
      name: newFriend.name,
      level: newFriend.level,
      section: newFriend.section,
      avatar: newFriend.avatar,
      isFollowing: true
    });
  }

  // Remove from requests
  friendRequests = friendRequests.filter(r => r.id !== requestId);
  
  // Add notification
  addNotification(`${request.fromUserName} accepted your friend request!`, 'friend-accepted');
  
  // Update displays
  updateFriendsTable();
  updateRequestsList();
  updateNotificationDisplay();
}

// Decline friend request
function declineFriendRequest(requestId) {
  friendRequests = friendRequests.filter(r => r.id !== requestId);
  updateRequestsList();
}

// View friend profile
function viewProfile(friendId) {
  const friend = friends.find(f => f.id === friendId);
  if (friend) {
    alert(`Viewing ${friend.name}'s profile`);
    // In a real app, this would navigate to the friend's profile page
  }
}

// Invite friend for co-op
function inviteFriend(friendId) {
  const friend = friends.find(f => f.id === friendId);
  if (friend) {
    alert(`Inviting ${friend.name} for co-op study session`);
    // In a real app, this would send a co-op invitation
  }
}

// Add notification
function addNotification(message, type = 'info') {
  const notification = {
    id: Date.now(),
    message,
    type,
    timestamp: new Date(),
    read: false
  };
  
  notifications.unshift(notification);
  updateNotificationDisplay();
  updateNotificationBadge();
}

// Update notification display
function updateNotificationDisplay() {
  if (!notificationContent) return;

  if (notifications.length === 0) {
    notificationContent.innerHTML = 'No new notifications.';
    return;
  }

  notificationContent.innerHTML = notifications.map(notification => `
    <div class="notification-item ${notification.read ? 'read' : 'unread'}">
      <div class="notification-message">${notification.message}</div>
      <div class="notification-time">${formatTime(notification.timestamp)}</div>
    </div>
  `).join('');
}

// Update notification badge
function updateNotificationBadge() {
  const unreadCount = notifications.filter(n => !n.read).length;
  if (unreadCount > 0) {
    notificationBtn.innerHTML = `🔔 <span class="notification-badge">${unreadCount}</span>`;
  } else {
    notificationBtn.innerHTML = '🔔';
  }
}

// Update friends table
function updateFriendsTable(friendsToShow = friends) {
  if (!friendsTableBody) return;

  if (friendsToShow.length === 0) {
    friendsTableBody.innerHTML = '<tr><td colspan="4" class="no-friends-message">No friends found.</td></tr>';
    return;
  }

  friendsTableBody.innerHTML = friendsToShow.map(friend => `
    <tr>
      <td>
        <div class="friend-info">
          <div class="avatar">${friend.avatar}</div>
          <span>${friend.name}</span>
        </div>
      </td>
      <td>${friend.level}</td>
      <td>${friend.section}</td>
      <td>
        <button class="action-btn profile-btn" onclick="viewProfile(${friend.id})">Profile</button>
        <button class="action-btn invite-btn" onclick="inviteFriend(${friend.id})">Invite</button>
      </td>
    </tr>
  `).join('');
}

// Update requests list
function updateRequestsList() {
  if (!requestsListContainer) return;

  if (friendRequests.length === 0) {
    requestsListContainer.innerHTML = '<div class="no-friends-message">No friend requests.</div>';
    return;
  }

  requestsListContainer.innerHTML = friendRequests.map(request => `
    <div class="request-item">
      <div class="request-info">
        <div class="avatar">👤</div>
        <div>
          <div class="search-result-name">${request.fromUserName}</div>
          <div class="search-result-details">Wants to be your friend</div>
        </div>
      </div>
      <div>
        <button class="action-btn accept-btn" onclick="acceptFriendRequest(${request.id})">Accept</button>
        <button class="action-btn decline-btn" onclick="declineFriendRequest(${request.id})">Decline</button>
      </div>
    </div>
  `).join('');
}

// Format time for notifications
function formatTime(date) {
  const now = new Date();
  const diff = now - date;
  const minutes = Math.floor(diff / 60000);
  const hours = Math.floor(diff / 3600000);
  const days = Math.floor(diff / 86400000);

  if (minutes < 1) return 'Just now';
  if (minutes < 60) return `${minutes}m ago`;
  if (hours < 24) return `${hours}h ago`;
  return `${days}d ago`;
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', init);