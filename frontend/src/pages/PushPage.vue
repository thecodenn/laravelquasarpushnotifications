<template>
  <p>Hi, you're on page: {{ pageId }}</p>
  <p>channelUrl: {{ channelUrl }}</p>
  <p>channelPort: {{ channelPort }}</p>

  <p><strong>dev:</strong></p>
  <p>quasar clean</p>
  <p>quasar build -m capacitor -T android</p>
  <p>quasar dev -m android</p>

  <p><strong>Release:</strong></p>
  <p>quasar clean</p>
  <p>quasar build -m capacitor -T android</p>

  <p>npm install @capacitor/android</p>

  keytool -genkey -v -keystore my-release-key.keystore -alias my-key-alias -keyalg RSA -keysize 2048 -validity 10000


  1. Configure Signing in Gradle
  Open your project’s android/app/build.gradle file and add a signing configuration for the release build. For example:

  groovy
  Copy
  android {
  signingConfigs {
  release {
  storeFile file('my-release-key.keystore') // Path to your keystore file
  storePassword 'your_store_password'
  keyAlias 'my_key_alias'
  keyPassword 'your_key_password'
  }
  }
  buildTypes {
  release {
  signingConfig signingConfigs.release
  // Other release options (e.g., minification) can go here
  }
  }
  }
  Make sure you have created a keystore file (if you haven’t, use the keytool command to generate one).

  2. Build the Signed APK Using Gradle
  Once the signing configuration is in place, open a terminal in the android folder of your project and run:

  bash
  Copy
  ./gradlew assembleRelease
  This command compiles the release version and applies your signing configuration. Once finished, the signed APK will be
  available at:

  swift
  Copy
  android/app/build/outputs/apk/release/app-release.apk
  3. Alternative: Using Android Studio’s "Build Bundle(s) / APK(s)" Menu
  If you’d prefer to use Android Studio’s interface but don’t see the "Generate Signed Bundle / APK" option, try the
  following:

  Check the Menu:
  Go to Build > Build Bundle(s) / APK(s) > Build APK(s). This option might be available depending on your Android Studio
  version. However, if no signing configuration is applied in Gradle, the resulting APK might be unsigned.

  Sync Gradle:
  Make sure your Gradle files are properly synced. Sometimes the option doesn’t show up if there’s a configuration issue.

  Android Studio Version:
  Ensure you’re using a recent version of Android Studio, as older versions might handle these options differently.

  Using the Gradle command line with a proper signing configuration is a reliable way to generate a signed APK if the IDE
  option isn’t available.






  <hr>
  <Strong>backend</Strong>
  Using Firebase Cloud Messaging (FCM v1 API) Without the Legacy System
  Since you don’t want to use the Legacy API, you'll need to use the FCM v1 API with OAuth2 authentication. Here’s how to
  properly set it up and send push notifications securely.

  ✅ Step 1: Get Your Service Account Credentials
  Go to Google Cloud Console.
  Select your Firebase project.
  In the left menu, go to IAM & Admin → Service Accounts.
  Click Manage Keys under Firebase Admin SDK.
  Click Create Key, and it will download a JSON file (your-service-account.json).
  📌 Keep this file secure! It contains credentials for your Firebase project.

  ✅ Step 2: Generate an OAuth2 Access Token
  The FCM v1 API requires an OAuth2 access token instead of the Server Key.

  You can generate this token using Google Cloud SDK (gcloud) or Python.

  Option 1: Generate OAuth2 Token Using gcloud CLI (Recommended)
  Install the Google Cloud SDK:
  Google Cloud SDK Installation
  Authenticate using the Service Account:
  sh
  Copy
  gcloud auth activate-service-account --key-file=your-service-account.json
  Generate an OAuth2 token:
  sh
  Copy
  gcloud auth print-access-token
  Copy the OAuth2 access token (it’s a long alphanumeric string).
  Option 2: Generate OAuth2 Token Using Python
  If you prefer Python, create a script to generate the access token:

  python
  Copy
  from google.oauth2 import service_account
  import google.auth.transport.requests

  SCOPES = ["https://www.googleapis.com/auth/firebase.messaging"]
  SERVICE_ACCOUNT_FILE = "your-service-account.json"

  credentials = service_account.Credentials.from_service_account_file(
  SERVICE_ACCOUNT_FILE, scopes=SCOPES
  )

  request = google.auth.transport.requests.Request()
  credentials.refresh(request)

  print("OAuth2 Access Token:", credentials.token)
  📌 Run this script, and it will print your OAuth2 access token.

  ✅ Step 3: Send a Push Notification Using the FCM v1 API
  Once you have the OAuth2 access token, you can send a push notification.

  Replace:

  "YOUR_OAUTH2_ACCESS_TOKEN" with the token you generated.
  "YOUR_PROJECT_ID" with your Firebase Project ID.
  "DEVICE_FCM_TOKEN" with the FCM token from your Quasar app.
  sh
  Copy
  curl -X POST "https://fcm.googleapis.com/v1/projects/YOUR_PROJECT_ID/messages:send" \
  -H "Authorization: Bearer YOUR_OAUTH2_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
  "message": {
  "token": "DEVICE_FCM_TOKEN",
  "notification": {
  "title": "New Alert!",
  "body": "You have a new notification"
  }
  }
  }'
  ✅ Step 4: Get the DEVICE_FCM_TOKEN from Your Quasar App
  Modify firebase.ts in your Quasar app to log the token:

  ts
  Copy
  import { getMessaging, getToken } from "firebase/messaging";

  const messaging = getMessaging();

  export async function requestNotificationPermission() {
  try {
  const permission = await Notification.requestPermission();
  if (permission === "granted") {
  const token = await getToken(messaging, {
  vapidKey: "YOUR_VAPID_KEY"
  });
  console.log("FCM Token:", token); // ✅ Copy this for testing
  return token;
  } else {
  console.warn("Notification permission denied");
  }
  } catch (error) {
  console.error("Error getting FCM token:", error);
  }
  }
  🚀 Run your app, open the browser console (F12 → Console), and copy the logged FCM token.

  ✅ Summary
  Value Where to Get It?
  YOUR_PROJECT_ID Firebase Console → Project Settings > General
  YOUR_OAUTH2_ACCESS_TOKEN Generate with gcloud auth print-access-token or Python
  DEVICE_FCM_TOKEN Log it from getToken(messaging) in your Quasar app (firebase.ts)
  Now, you are using the FCM v1 API without the legacy system! 🚀

  Would you like help automating the OAuth2 token process for your backend? 😊


  <p v-html="log"></p>
</template>

<script setup>
import { io } from "socket.io-client";
import { useRoute } from 'vue-router';
import { ref, onMounted } from "vue";
import { useQuasar } from "quasar";

const $q = useQuasar()
const log = ref("");

const route = useRoute();

const channelUrl = import.meta.env.VITE_CHANNEL_URL;
const channelPort = import.meta.env.VITE_CHANNEL_PORT;

const pageId = ref(route.params.pageId);


onMounted(() => {

  log.value += "mounted<br />";
  log.value += "channelUrl: " + channelUrl + "<br />";
  log.value += "channelPort: " + channelPort + "<br />";

  fetch(channelUrl + ":" + channelPort + "/socket.io/?EIO=4&transport=polling")
    .then(response => log.value += "Server reachable:" + response + "<br />")
    .catch(error => log.value += "Fetch error:" + error + "<br />");




  if (channelUrl != "" && channelPort != "") {

    const socket = io(channelUrl + ":" + channelPort, {
      transports: ["websocket"],
      secure: true, // Use secure WebSocket
      reconnectionAttempts: 5,
      timeout: 5000
    });


    function showNotification(event, colour, icon) {
      log.value += "got data:<br />";
      log.value += event + "<br />";

      const data = JSON.parse(event);
      console.log("data: ", data);

      log.value += data + "<br />";
      log.value += data.message + "<br />";

      $q.notify({
        color: colour,
        textColor: null,
        icon: icon,
        message: data.message,
        position: "top",
        avatar: null,
        multiLine: null,

        timeout: Math.random() * 5000 + 3000
      })
    }


    socket.on("connect_error", (err) => {
      log.value += "Socket connection error: " + err.message + "<br />";
      console.error("Socket error:", err);
    });

    socket.on("connected", () => {
      log.value += "connected to node server<br />";
      socket.emit("pushy-page", "Laravel-pushy-" + pageId.value);
      socket.emit("pushy-page", "Laravel-pushy-all");
    });

    socket.on("Laravel-pushy-" + pageId.value, (event) => {
      showNotification(event, "teal", "tag_faces");
    });


    socket.on("Laravel-pushy-all", (event) => {
      showNotification(event, "red", "groups");
    });

  }
});

</script>
