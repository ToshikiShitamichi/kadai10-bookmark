// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, onAuthStateChanged, GoogleAuthProvider, signInWithPopup, signOut, GithubAuthProvider, updateProfile, updateEmail, updatePassword, sendPasswordResetEmail, deleteUser } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-auth.js";
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
import { firebaseConfig } from "./firebaseConfig.js";

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Authentication and get a reference to the service
const auth = getAuth(app);

const googleProvider = new GoogleAuthProvider();
const githubProvider = new GithubAuthProvider();

// PHPへPOST（共通）
function postToPhp(user, provider) {
    $("#firebase_uid").val(user.uid);
    $("#post_email").val(user.email ?? "");
    $("#post_display_name").val(user.displayName ?? "");
    console.log(user.photoURL);

    $("#post_photo_url").val(user.photoURL ?? "");
    $("#post_provider").val(provider);
    $("#postToPhpForm")[0].submit();
}

$(function () {
    // メール/パスワード登録
    $("#mailSignUpForm").on("submit", async function (e) {
        $("#err-mail").css("display", "none");

        e.preventDefault()

        const displayName = $("#displayName").val();
        const email = $("#email").val();
        const password = $("#password").val();

        try {
            const cred = await createUserWithEmailAndPassword(auth, email, password);

            if (displayName) {
                await updateProfile(cred.user, { displayName });
            }

            postToPhp(cred.user, "password");
        } catch (err) {
            if (err?.code === "auth/email-already-in-use") {
                $("#err-mail").css("display", "block");
                return
            }
        }
    });

    // 新規登録(Google)
    $("#btnGoogle").on("click", async function () {
        $("#err-mail").css("display", "none");
        try {
            const cred = await signInWithPopup(auth, googleProvider);
            postToPhp(cred.user, "google");
        } catch (err) {
            $("#err-mail").css("display", "block");
            return
        }
    });

    // 新規登録(GitHub)
    $("#btnGithub").on("click", async function () {
        $("#err-mail").css("display", "none");
        try {
            const cred = await signInWithPopup(auth, githubProvider);
            postToPhp(cred.user, "github");
        } catch (err) {
            $("#err-mail").css("display", "block");
            return
        }
    });
})