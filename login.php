<?php
$title = "User Login";
$css = "views/login.css";
$headerCss = "views/site_header.css";
$footerCss = "views/site_footer.css";
include "site_header.php";
?>
<main>
    <h2>Login Form</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
    
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
    
        <button type="submit">Login</button>
    </form>
</main>
<?php include "site_footer.php"; ?>