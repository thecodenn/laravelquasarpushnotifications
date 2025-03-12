import { boot } from 'quasar/wrappers'
import { initializeApp } from 'firebase/app'
import { getMessaging, getToken, onMessage } from 'firebase/messaging'
import { Notify } from 'quasar'

// Firebase configuration (Replace with your actual Firebase config)
const firebaseConfig = {
  apiKey: 'AIzaSyBiBHTpxxgwL_01430flizVZNvAoQmuQbc',
  authDomain: 'webworkspushdemo.firebaseapp.com',
  projectId: 'webworkspushdemo',
  storageBucket: 'webworkspushdemo.appspot.com',
  messagingSenderId: '1056702542947',
  appId: '1:1056702542947:android:c0449ba36ae09619a47456',
}

// Initialize Firebase
const app = initializeApp(firebaseConfig)

// Initialize Firebase Messaging
const messaging = getMessaging(app)

// Request permission and get token
export async function requestNotificationPermission() {
  try {
    const permission = await Notification.requestPermission()
    if (permission === 'granted') {
      const token = await getToken(messaging, {
        vapidKey:
          'BBqMGmo-lcDhpN-hPvR0uDLg5j7stSNS3oAG6_lygbcZ2RCJhNFhUJjo1RKhyMQBgATBxHJxb69fztSoP5mOacw',
      })
      console.log('FCM Token:', token)

      return token
    } else {
      console.warn('Notification permission denied')
    }
  } catch (error) {
    console.error('Error getting FCM token:', error)
  }
}

// Handle incoming messages
onMessage(messaging, (payload) => {
  console.log('Push notification received:', payload)

  Notify.create({
    color: 'red',
    textColor: null,
    icon: 'tag_faces',
    message: payload.notification.title + '; ' + payload.notification.body,
    position: 'top',
    avatar: null,
    multiLine: null,

    timeout: Math.random() * 5000 + 3000,
  })
})

// Export the messaging instance
export { messaging }

export default boot(() => {
  requestNotificationPermission()
})
END
END
