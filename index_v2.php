<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dulara Hettiarachchi</title>

    <link rel="stylesheet" type="text/css" href="/My/CSS/styles_V2.css">
    <link rel="stylesheet" type="text/css" href="/My/CSS/main.css">
    <link rel="stylesheet" type="text/css" href="/My/CSS/signin_V2.css">

    <link rel="icon" href="/My/IMAGE/logo.jpg">

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>

<body>

    <section class="hero">

        <div class="hero-overlay">

            <div class="hero-content">
                <div class="logo">
                    <img src="IMAGE/Dulara.jpg" alt="Dulara Hettiarachchi">
                </div>
                <h1>Dulara Hettiarachchi</h1>
                <p>Discover the latest trends in footwear and elevate your style today.</p>
                <button class="cta-button">Sign In</button>
            </div>


            <div class="container">
                <h2>Sign In</h2>
                <form id="signinForm">
                    <label for="phone">Mobile Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your mobile number">
                    <small id="phoneError" class="error"></small>

                    <div id="passwordField" style="display:none;">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">
                        <button type="submit">Sign In</button>
                    </div>

                    <div id="otpField" style="display:none;">
                        <label for="otp">Enter OTP</label>
                        <input type="text" id="otp" name="otp">
                        <button type="button" id="signupBtn">Sign Up</button>
                    </div>
                </form>
            </div>

            <div class="register-container hidden">
                <h2>Registration Form</h2>
                <form id="registerForm">
                    <div class="name">
                        <input class="fname" type="text" name="fname" placeholder="First Name" required>
                        <input class="lname" type="text" name="lname" placeholder="Last Name" required>
                    </div>
                    <input type="date" name="dob" required>
                    <input type="text" name="school" placeholder="School Name" required>

                    <select name="grade" id="grade" required>
                        <option value="2027">2027 A/L</option>
                        <option value="2026">2026 A/L</option>
                        <option value="2025">2025 A/L</option>
                    </select>
                    
                    <select name="district" id="district" required>
                        <option value="Ampara">Ampara</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Matale">Matale</option>
                        <option value="Matara">Matara</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Vavuniya">Vavuniya</option>
                    </select>

                    <input type="text" name="address" placeholder="Address" required>
                    <input type="text" name="postal" placeholder="Postal Code" required>
                    <input type="text" name="nic" placeholder="NIC Number" required>

                    <div class="password-container">
                        <input type="password" id="regPass" name="password" placeholder="Password" required>
                        <span onclick="enterPass()">👁️</span>
                    </div>
                    <div class="password-container">
                        <input type="password" id="confPass" name="confirmPass" placeholder="Confirm Password" required>
                        <span onclick="confPass()">👁️</span>
                    </div>

                    <button type="submit" class="register-btn">Register</button>
                </form>
            </div>


        </div>

    </section>






    <script>
        let generatedOTP = null; // store OTP temporarily

        document.getElementById("phone").addEventListener("input", function() {
            let phone = this.value.trim();
            let errorEl = document.getElementById("phoneError");
            let passwordField = document.getElementById("passwordField");
            let otpField = document.getElementById("otpField");

            errorEl.textContent = "";
            passwordField.style.display = "none";
            otpField.style.display = "none";

            let pattern10 = /^(07[0,1,2,4,6,7,8][0-9]{7})$/;
            let pattern9 = /^(7[0,1,2,4,6,7,8][0-9]{7})$/;

            if (pattern10.test(phone) || pattern9.test(phone)) {
                // Check if number is in DB
                fetch("check_user.php?phone=" + phone)
                    .then(res => res.json())
                    .then(data => {
                        if (data.exists) {
                            passwordField.style.display = "block"; // user found → show password
                        } else {
                            otpField.style.display = "block"; // new user → OTP flow

                            // 🔹 Generate a temporary OTP (random 6 digits)
                            generatedOTP = Math.floor(100000 + Math.random() * 900000);
                            alert("Your OTP is: " + generatedOTP); // TEMP for testing
                        }
                    });
            } else {
                errorEl.textContent = "Enter valid phone number";
            }
        });

        // 🔹 OTP check when user clicks "Sign Up"
        document.getElementById("signupBtn").addEventListener("click", function() {
            let userOTP = document.getElementById("otp").value.trim();
            if (userOTP == generatedOTP) {
                // OTP success → switch to registration form
                document.querySelector(".container").classList.add("hidden");
                document.querySelector(".register-container").classList.remove("hidden");
                document.querySelector(".register-container").classList.add("show");
            } else {
                alert("Invalid OTP, try again!");
            }
        });
    </script>


    <script>
        document.querySelector(".container").classList.add("hidden");
        document.querySelector(".register-container").classList.remove("hidden");
        document.querySelector(".register-container").classList.add("show");
    </script>

    <script>
        function enterPass() {
            let p = document.getElementById("regPass");
            p.type = (p.type === "password") ? "text" : "password";
        }

        function confPass() {
            let p = document.getElementById("confPass");
            p.type = (p.type === "password") ? "text" : "password";
        }
    </script>


    <?php
    // connect DB
    $conn = new mysqli("localhost", "root", "", "dulara_hettiarachchi");

    // $phone = $_GET['phone'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE phone=?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    // echo json_encode(["exists" => $result->num_rows > 0]);
    ?>

    <script>
        document.getElementById("phone").addEventListener("input", function() {
            let phone = this.value.trim();
            let errorEl = document.getElementById("phoneError");
            let passwordField = document.getElementById("passwordField");
            let otpField = document.getElementById("otpField");

            errorEl.textContent = "";
            passwordField.style.display = "none";
            otpField.style.display = "none";

            // Regex patterns
            let pattern10 = /^(07[0,1,2,4,6,7,8][0-9]{7})$/; // 10 digit
            let pattern9 = /^(7[0,1,2,4,6,7,8][0-9]{7})$/; // 9 digit

            if (pattern10.test(phone) || pattern9.test(phone)) {
                // AJAX call to PHP to check DB
                fetch("check_user.php?phone=" + phone)
                    .then(res => res.json())
                    .then(data => {
                        if (data.exists) {
                            passwordField.style.display = "block"; // user found
                        } else {
                            otpField.style.display = "block"; // new user → signup flow
                        }
                    });
            } else {
                errorEl.textContent = "Enter valid phone number";
            }
        });
    </script>







    <script>
        const signinBtn = document.querySelector('.cta-button');
        const heroContent = document.querySelector('.hero-content');
        const formBox = document.querySelector('.container');

        signinBtn.addEventListener('click', () => {
            // move welcome left and fade out (button disappears with it)
            heroContent.classList.add('move-left');
            //disappear sign in button
            signinBtn.classList.add('disappearBtn')
            // show form in middle at same time
            formBox.classList.add('form-active');

        });
    </script>

    <script src="/My/JS/signin.js"></script>

</body>

</html>
