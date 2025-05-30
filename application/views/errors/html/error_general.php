<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error en la aplicación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .error-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }

        .error-code {
            font-size: 72px;
            font-weight: bold;
            color: #e74c3c;
            margin: 0;
        }

        .error-heading {
            font-size: 24px;
            margin: 10px 0;
        }

        .error-message {
            font-size: 16px;
            margin: 20px 0;
            color: #555;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <p class="error-code">😕</p>
        <h1 class="error-heading"><?php echo $heading; ?></h1>
        <p class="error-message"><?php echo $message; ?></p>
        <a href="<?= base_url() ?>" class="back-link">Volver al inicio</a>
    </div>
</body>
</html>
