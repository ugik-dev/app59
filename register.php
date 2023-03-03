<form action="register.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="seat">Select a seat:</label>
    <select id="seat" name="seat" required>
        <option value="">Please select a seat</option>

    </select><br><br>
    <input type="submit" value="Register">
</form>