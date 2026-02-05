// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, onAuthStateChanged, GoogleAuthProvider, signInWithPopup, signOut, GithubAuthProvider, updateProfile, updateEmail, updatePassword, sendPasswordResetEmail, deleteUser, linkWithPopup } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-auth.js";
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
    $("#post_photo_url").val(user.photoURL ?? "");
    $("#post_provider").val(provider);
    $("#postToPhpForm")[0].submit();
}

$(function () {
    // メール/パスワード登録
    $("#mailSignUpForm").on("submit", async function (e) {
        $("#err-mail").css("display", "none");

        e.preventDefault()

        const displayName = $("#display_name").val();
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
                $("#err-mail").text("すでに登録されているか、別の方法でログイン済みです。");
            }
            if (err?.code === "auth/invalid-email") {
                $("#err-mail").text("メールアドレスの形式が正しくありません。");
            }
            if (err?.code === "auth/weak-password") {
                $("#err-mail").text("パスワードが短すぎます（6文字以上）。");
            }
            $("#err-mail").css("display", "block");
            return
        }
    });

    // メール/パスワードサインイン
    $("#mailSignInForm").on("submit", async function (e) {
        $("#err-mail").css("display", "none");

        e.preventDefault()

        const email = $("#email").val();
        const password = $("#password").val();

        try {
            const cred = await signInWithEmailAndPassword(auth, email, password);

            postToPhp(cred.user, "password");
        } catch (err) {
            if (err?.code === "auth/invalid-credential") {
                $("#err-mail").text("メール/パスワードが正しくないか、別の方法でログイン済みです。");
            }
            $("#err-mail").css("display", "block");
            return
        }
    });

    // 新規登録(Google)
    $("#btnGoogle").on("click", async function () {
        $("#err-mail").css("display", "none");
        try {
            const cred = await signInWithPopup(auth, googleProvider);
            postToPhp(cred.user, "google");
        } catch (err) {
            if (err?.code === "auth/email-already-in-use") {
                $("#err-mail").text("すでに登録されているか、別の方法でログイン済みです。");
            }
            if (err?.code === "auth/popup-closed-by-user") {
                $("#err-mail").text("ポップアップが閉じられました。");
            }
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
            console.log(err);
            if (err?.code === "auth/account-exists-with-different-credential") {
                const cred = await signInWithPopup(auth, googleProvider);

            }
            if (err?.code === "auth/email-already-in-use") {
                $("#err-mail").text("すでに登録されているか、別の方法でログイン済みです。");
            }
            if (err?.code === "auth/popup-closed-by-user") {
                $("#err-mail").text("ポップアップが閉じられました。");
            }
            $("#err-mail").css("display", "block");
            return
        }
    });

    // 更新
    $("#accountUpdateForm").on("submit", async function (e) {
        e.preventDefault()

        const display_name = $("#display_name").val();

        await updateProfile(auth.currentUser, { displayName: display_name })

        postToPhp(auth.currentUser, "password");
    });
})