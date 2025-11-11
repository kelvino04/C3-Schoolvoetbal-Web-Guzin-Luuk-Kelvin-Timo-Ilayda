<x-base-layout>
    <h2>Inloggen</h2>

    <form method="post" action="/login-handler.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Inloggen</button>
    </form>
</x-base-layout>
