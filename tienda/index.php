<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Calzado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos Generales */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #121212; /* Fondo oscuro */
            color: #e0e0e0; /* Texto claro */
        }

        /* Encabezado */
        header {
            background-color: #1f1f1f; /* Fondo del encabezado */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ff4757; /* Color del logo */
        }

        .menu {
            display: flex;
            gap: 30px;
        }

        .menu a {
            color: #e0e0e0; /* Texto claro para los enlaces */
            text-decoration: none;
            font-weight: 500;
        }

        .menu a:hover {
            color: #ff6b81; /* Efecto hover en los enlaces */
        }

        /* Banner */
        .banner {
            background-image: url('../tienda/login_admin/productos/img/baner4.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            color: #e0e0e0;
            min-height: 500px;
        }

        .banner .cta-button {
            background-color: #ff4757;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            margin: 0 auto;
        }

        .banner .cta-button:hover {
            background-color: #ff6b81;
        }

        .banner .cta-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Iconos debajo del banner */
        .features {
            display: flex;
            justify-content: space-around;
            padding: 25px 0;
            background-color: #1f1f1f; /* Fondo oscuro */
        }

        .feature-item {
            text-align: center;
            padding: 10px;
        }

        .feature-item i {
            font-size: 30px;
            color: #ff4757;
            margin-bottom: 10px;
        }

        .feature-item p {
            font-size: 16px;
            color: #e0e0e0;
        }

        /* Colección de productos */

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    justify-items: center; /* Centra los elementos dentro de las celdas */
    max-width: 1200px; /* Ancho máximo para mantener la colección centrada */
    width: 100%;
}


.collection {
    padding: 40px 20px;
    display: flex;
    flex-direction: column; /* Alinea el contenido en una columna para que el título esté encima */
    align-items: center; /* Centra los elementos horizontalmente */
}

.collection h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #e0e0e0;
    width: 100%; /* Asegura que el título ocupe todo el ancho disponible */
}


        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .product-card {
            background-color: white; /* Fondo oscuro para las tarjetas de productos */
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .product-card h3 {
    font-size: 18px;
    color: #000; /* Cambiado a negro */
    margin-bottom: 10px;
}

.product-card p {
    font-size: 16px;
    color: #000; /* Cambiado a negro */
    margin-bottom: 10px;
}


        .product-card button {
            background-color: #ff4757;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-card button:hover {
            background-color: #ff6b81;
        }

        /* Sección dedicada a la calidad */
        .dedicated-section {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 40px 20px;
            background-color: #2c2c2c; /* Fondo oscuro */
        }

        .dedicated-section img {
            width: 40%;
            border-radius: 40px;
        }

        .dedicated-content {
            max-width: 500px;
        }

        .dedicated-content h3 {
            font-size: 28px;
            color: #black;
            margin-bottom: 15px;
        }

        .dedicated-content p {
            font-size: 18px;
            color: #bbbbbb;
            margin-bottom: 20px;
        }

        .dedicated-content a {
            background-color: #ff4757;
            color: #fff;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Footer */
        footer {
            background-color: #1f1f1f; /* Fondo oscuro para el pie de página */
            color: #e0e0e0;
            text-align: center;
            padding: 20px;
        }
        .logo {
    font-size: 2rem; /* Ajusta el tamaño de fuente */
    font-weight: bold; /* Texto en negrita */
    color: #ffffff; /* Color del texto */
    text-decoration: none; /* Sin subrayado */
}

    </style>
</head>
<body>

<header>
<a href="acceso.html" class="logo">SPORTLINE</a>

    <nav class="menu">
        <a href="#">Home</a>
        <a href="#">Collection</a>
        <a href="#">Products</a>
        <a href="#">Contact</a>
    </nav>
</header>

<div class="banner">
    <div class="cta-container">
    </div>
</div>

<div class="features">
    <div class="feature-item">
        <i class="fas fa-shield-alt"></i>
        <p>Secure Payment</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-headset"></i>
        <p>24/7 Support</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-truck"></i>
        <p>Fast Delivery</p>
    </div>
</div>

<section class="collection Zapatos">
    <h2>Collection Zapatos</h2>
    <div class="product-grid">
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/2.png" alt="Sneaker 1">
            <h3>Air Griffey Max 1</h3>
            <p>$150</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/1.png" alt="Sneaker 2">
            <h3>Nike Air Max 95</h3>
            <p>$250</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/3.png" alt="Sneaker 1">
            <h3>Air Griffey Max 1</h3>
            <p>$150</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/4.png" alt="Sneaker 2">
            <h3>Nike Air Max 95</h3>
            <p>$300</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/5.png" alt="Sneaker 2">
            <h3>Nike Air Max 95</h3>
            <p>$250</p>
            <button>Add to Cart</button>
        </div>
    </div>
</section>
<section class="collection Accesorios">
    <h2>Collection Tecnologia</h2>
    <div class="product-grid">
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/reloj.png" alt="Sneaker 1">
            <h3>Air Griffey Max 1</h3>
            <p>$150</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/reloj2.jpg" alt="Sneaker 2">
            <h3>Reloj Fz 200</h3>
            <p>$150</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/audifonos.jpg" alt="Sneaker 1">
            <h3>Air Griffey Max 1</h3>
            <p>$10</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/audinos2.jpeg" alt="Sneaker 2">
            <h3>Air Max 95</h3>
            <p>$50</p>
            <button>Add to Cart</button>
        </div>
        <div class="product-card">
            <img src="../tienda/login_admin/productos/img/au.jpg" alt="Sneaker 2">
            <h3>Air Max 92</h3>
            <p>$20</p>
            <button>Add to Cart</button>
        </div>
    </div>
</section>

<section class="dedicated-section">
    <img src="../tienda/login_admin/productos/img/jordan.jpg" alt="Sneaker Image">
    <div class="dedicated-content">
        <h3>Dedicated to Quality and Results</h3>
        <p>Our sneakers are designed with premium quality and utmost comfort for athletes and enthusiasts alike.</p>
        <a href="#">Learn More</a>
    </div>
</section>

<footer>
    <p>&copy; 2024 Dream Sneakers. All rights reserved.</p>
</footer>

</body>
</html>
