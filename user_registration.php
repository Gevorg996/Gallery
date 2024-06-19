<?php
$title = "User Registration";
$css = "views/user_registration.css";
$headerCss = "views/site_header.css";
$footerCss = "views/site_footer.css";
include "site_header.php";
?>
<main>
    <h2>Registration Form</h2>
    <form action="register.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        
        <button type="submit">Register</button>
    </form>
</main>
<?php include "site_footer.php"; ?>