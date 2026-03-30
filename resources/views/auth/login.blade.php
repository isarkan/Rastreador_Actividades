<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<form method="POST" action="/login" class="bg-white p-6 rounded shadow w-96">
    @csrf

    <h1 class="text-2xl font-bold mb-4">Iniciar sesión</h1>

    <input type="email" name="email" placeholder="Correo"
        class="border p-2 w-full mb-3">

    <input type="password" name="password" placeholder="Contraseña"
        class="border p-2 w-full mb-3">

    <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
        Entrar
    </button>

    <a href="/register" class="text-sm text-blue-600 block mt-3">
        Crear cuenta
    </a>
</form>

</body>
</html>