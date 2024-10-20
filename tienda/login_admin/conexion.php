<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/vendor/autoload.php"; // Ajusta la ruta si es necesario

class DatabaseConnection {
    private $server = "127.0.0.1";
    private $user = "rodrigo"; // Cambia esto si es necesario
    private $password = "1234"; // Cambia esto si es necesario
    private $database = "tienda_deportes"; // Cambia esto si es necesario
    private $port = "27017";
    private $client;
    private $db;

    private function getConnectionString() {
        return sprintf("mongodb://%s:%s@%s:%s/%s",
            $this->user,
            $this->password,
            $this->server,
            $this->port,
            $this->database
        );
    }

    public function connect() {
        try {
            $connectionString = $this->getConnectionString();
            $this->client = new MongoDB\Client($connectionString);
            $this->db = $this->client->selectDatabase($this->database);
            return $this->db;
        } catch (\Throwable $exception) {
            die("Error al conectar a la base de datos: " . $exception->getMessage());
        }
    }

    public function getCollection($collectionName) {
        if (!$this->db) {
            $this->connect(); // Asegurarse de que estamos conectados
        }
        return $this->db->selectCollection($collectionName); // Devuelve la colección solicitada
    }

    public function close() {
        $this->client = null; // Cerrar la conexión
    }
}

// Ejemplo de uso
$dbConnection = new DatabaseConnection();

$collectionProductos = $dbConnection->getCollection("productos");
$collectionClientes = $dbConnection->getCollection("clientes");
$collectionEmpleados = $dbConnection->getCollection("empleados");
$collectionCategoria = $dbConnection->getCollection("categoria");
$collectionUsuarios = $dbConnection->getCollection("usuarios"); 
$productos = $collectionProductos->find();

// Ahora puedes trabajar con cada colección por separado
