// assets/js/firebase-config.js - Firebase App & Analytics SDK initialization
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-analytics.js";

// Your web app's Firebase configuration
export const firebaseConfig = {
  apiKey: "AIzaSyBZ2Iuyl6yBf_Ut0rFhs59XufTYqiRo2Ko",
  authDomain: "newsatdoha.firebaseapp.com",
  projectId: "newsatdoha",
  storageBucket: "newsatdoha.firebasestorage.app",
  messagingSenderId: "551571600416",
  appId: "1:551571600416:web:92b6a2e6d5ee7773d53845",
  measurementId: "G-YLY5FNJ70W"
};

// Initialize Firebase
export const app = initializeApp(firebaseConfig);
export const analytics = typeof window !== 'undefined' ? getAnalytics(app) : null;

window.firebaseApp = app;
window.firebaseAnalytics = analytics;
console.log('Firebase initialized for NEWS @ DOHA (Project: newsatdoha)');
