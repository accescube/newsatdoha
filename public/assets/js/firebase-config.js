// assets/js/firebase-config.js - Firebase App & Analytics SDK initialization
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-analytics.js";

// Your web app's Firebase configuration for newsatdoha
export const firebaseConfig = {
  apiKey: "AIzaSyA2Ht_CHBaoxMKtOP21ihRqVWBVPpxO14c",
  authDomain: "accescube-d571b.firebaseapp.com",
  projectId: "accescube-d571b",
  storageBucket: "accescube-d571b.firebasestorage.app",
  messagingSenderId: "896940040254",
  appId: "1:896940040254:web:3e229511971474df19716f",
  measurementId: "G-BEH3Q3XQX5"
};

// Initialize Firebase
export const app = initializeApp(firebaseConfig);
export const analytics = typeof window !== 'undefined' ? getAnalytics(app) : null;

window.firebaseApp = app;
window.firebaseAnalytics = analytics;
console.log('Firebase initialized for NEWS @ DOHA (Project: accescube-d571b, App: newsatdoha)');
