// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.21.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword ,signOut, onAuthStateChanged} from "https://www.gstatic.com/firebasejs/9.21.0/firebase-auth.js";
import { getDatabase , ref, set, update} from "https://www.gstatic.com/firebasejs/9.21.0/firebase-database.js";
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAhBFouJOfiTlkJa1l7leNbs62X5MzI_EI",
  authDomain: "gainsapp-a6b2b.firebaseapp.com",
  projectId: "gainsapp-a6b2b",
  storageBucket: "gainsapp-a6b2b.appspot.com",
  messagingSenderId: "494044941350",
  appId: "1:494044941350:web:62dea86174ef17b2cbeae7",
  measurementId: "G-BHRZ8ZVPD4",
  databaseURL: "https://gainsapp-a6b2b-default-rtdb.europe-west1.firebasedatabase.app/"
};

//initialize firebase modules
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const firebase = getDatabase(app);


//User Authentication section
let signupButton = document.getElementById("sign-up-button");
let signinButton = document.getElementById("sign-in-button");
let nameField = document.getElementById("name-field");
let loginTitle = document.getElementById("login-title");

if(signupButton){
	signupButton.addEventListener('click',(e) =>{
		if(!signupButton.classList.contains("disable")){
			var name = document.getElementById("username").value;
			var email = document.getElementById("email").value;
			var password = document.getElementById("password").value;

			createUserWithEmailAndPassword(auth, email, password)
			
			.then((userCredential) => {
				// Signed in 
				const user = userCredential.user;
				//firebase.ref("users").child(user.uid).set(name)
				set(ref(firebase,"users/"+ user.uid),{
					username:name,
					email:email
				});

				// ...
				alert('user created successfully')
			})
			.catch((error) => {
				const errorCode = error.code;
				const errorMessage = error.message;
				// ..
				alert(errorMessage)
			});
		}
		else{
			nameField.style.maxHeight = "60px";
			loginTitle.innerHTML = "Sign Up";
			signinButton.classList.add("disable");
			signupButton.classList.remove("disable");
		}
	});
}
if(signinButton){
	signinButton.addEventListener('click',(e)=>{
		if(!signinButton.classList.contains("disable")){
			var email = document.getElementById("email").value;
			var password = document.getElementById("password").value;

			signInWithEmailAndPassword(auth, email, password)
			.then((userCredential) => {
				// Signed in 
				const user = userCredential.user;
				document.cookie = "uid=" + user.uid + ";path=/";
				const dt = new Date();
				update(ref(firebase,"users/"+ user.uid),{
					last_login:dt
				});
				// ...
				alert('signed in successfully')
				window.location.href = "main.html"
			})
			.catch((error) => {
				const errorCode = error.code;
				const errorMessage = error.message;
				alert(errorMessage);
			});
		}
		else{
			nameField.style.maxHeight = "0";
			loginTitle.innerHTML = "Sign In";
			signupButton.classList.add("disable");
			signinButton.classList.remove("disable");
		}
	})
}
const signoutButton = document.getElementById("sign-out-button");
if (signoutButton){
	signoutButton.addEventListener('click',(e)=>{
		signOut(auth).then(() => {
		// Sign-out successful.
		alert("sign out success");
		window.location.href = "index.html";
		}).catch((error) => {
		// An error happened.
		alert(error.message);
		});
	})
}
//Get User Unique data
const user = auth.currentUser;

if (user !== null) {
	// User is signed in, see docs for a list of available properties
	// https://firebase.google.com/docs/reference/js/firebase.User
	const uid = user.uid;
	const displayName = user.displayName;
  	const email = user.email;

	// ...
} else {
// User is signed out
// ...
}
export {app , auth, firebase ,};