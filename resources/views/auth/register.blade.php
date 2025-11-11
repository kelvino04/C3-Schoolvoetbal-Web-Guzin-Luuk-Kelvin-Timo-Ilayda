<x-base-layout>
    <h2>Registreren</h2>

    <form method="post" action="/register-handler.php">
        <input type="text" name="name" placeholder="Naam" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Registreren</button>
    </form>
</x-base-layout>
