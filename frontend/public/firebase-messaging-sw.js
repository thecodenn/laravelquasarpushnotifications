/* eslint-disable no-undef */
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js')
importScripts('https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging-compat.js')

// Firebase configuration
firebase.initializeApp({
  apiKey: 'AIzaSyBiBHTpxxgwL_01430flizVZNvAoQmuQbc',
  authDomain: 'webworkspushdemo.firebaseapp.com',
  projectId: 'webworkspushdemo',
  storageBucket: 'webworkspushdemo.firebasestorage.app',
  messagingSenderId: '1056702542947',
  appId: '1:1056702542947:android:c0449ba36ae09619a47456',
})

// Initialize Firebase Messaging
const messaging = firebase.messaging()

// Handle background messages
messaging.onBackgroundMessage((payload) => {
  console.log('Received background message:', payload)
  self.registration.showNotification(payload.notification.title, {
    body: payload.notification.body,
    icon: '/icons/icon-192x192.png',
  })
})
