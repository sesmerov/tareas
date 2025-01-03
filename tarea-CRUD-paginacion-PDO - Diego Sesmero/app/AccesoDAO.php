<?php
include_once "config.php";
require_once "Cliente.php";

/**
 * Clase AccesoDAO
 * 
 * Clase que se encarga de acceder a la base de datos y obtener los datos de los clientes
 * 
 */

class AccesoDAO
{

    private static $modelo = null;
    private $dbh = null;
    private $stmt_clientes = null;
    private $stmt_numclientes = null;
    private $stmt_cliente = null;
    private $stmt_borcliente  = null;
    private $stmt_altacliente = null;
    private $stmt_modcliente = null;

    public static function getModelo()
    {
        if (self::$modelo == null) {
            self::$modelo = new AccesoDAO();
        }
        return self::$modelo;
    }



    // Constructor privado  Patron singleton     

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . SERVER_DB . ";dbname=" . DATABASE . ";charset=utf8";
            $this->dbh = new PDO($dsn, DB_USER, DB_PASSWD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        } catch (PDOException $e) {
            echo "Error de conexión " . $e->getMessage();
            exit();
        }
        // Construyo las consultas de golpe y no las emulo.
        $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        try {
            $this->stmt_clientes  = $this->dbh->prepare("select * from Clientes limit :primero ,:cuantos");
            $this->stmt_numclientes  = $this->dbh->prepare("SELECT count(*) FROM Clientes ");
            $this->stmt_cliente = $this->dbh->prepare("SELECT * FROM Clientes where id = :id");
            $this->stmt_borcliente  = $this->dbh->prepare("DELETE FROM Clientes where id =:id");
            $this->stmt_altacliente = $this->dbh->prepare("INSERT INTO Clientes (first_name,last_name,email,gender,ip_address,telefono) 
                                                            Values(:first_name,:last_name,:email,:gender,:ip_address,:telefono)");
            $this->stmt_modcliente   = $this->dbh->prepare("update Clientes 
                                    set first_name=:first_name, last_name=:last_name, email=:email, gender=:gender, ip_address=:ip_address, telefono=:telefono
                                    where id=:id");

        } catch (PDOException $e) {
            echo " Error al crear la sentencias " . $e->getMessage();
            exit();
        }
    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo()
    {
        if (self::$modelo != null) {
            $obj = self::$modelo;
            $obj->stmt_clientes = null;
            $obj->dbh = null;
            self::$modelo = null; // Borro el objeto.
        }
    }


    // Devuelvo la lista de Clientes
    public function getClientes(int $primero, int $cuantos): array
    {
        $tuser = [];
        $this->stmt_clientes->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $this->stmt_clientes->bindParam(":primero", $primero);
        $this->stmt_clientes->bindParam(":cuantos", $cuantos);
        if ($this->stmt_clientes->execute()) {
            while ($user = $this->stmt_clientes->fetch()) {
                $tuser[] = $user;
            }
        }
        return $tuser;
    }

    public function getCliente(int $id)
    {
        $cliente = null;
        $this->stmt_cliente->setFetchMode(PDO::FETCH_CLASS, "Cliente");
        $this->stmt_cliente->bindParam(":id", $id);
        if ($this->stmt_cliente->execute()) {
            while ($obj = $this->stmt_cliente->fetch()) {
                $cliente = $obj;
            }
        }
        return $cliente;
    }

    public function totalClientes(): int
    {
        $this->stmt_numclientes->execute();
        $valor = $this->stmt_numclientes->fetch();
        return $valor[0];
    }

    //AÑADIR
    public function altaCliente($cliente): bool
    {
        $this->stmt_altacliente->bindValue(':first_name', $cliente->first_name);
        $this->stmt_altacliente->bindValue(':last_name', $cliente->last_name);
        $this->stmt_altacliente->bindValue(':email', $cliente->email);
        $this->stmt_altacliente->bindValue(':gender', $cliente->gender);
        $this->stmt_altacliente->bindValue(':ip_address', $cliente->ip_address);
        $this->stmt_altacliente->bindValue(':telefono', $cliente->telefono);
        $this->stmt_altacliente->execute();
        $resu = ($this->stmt_altacliente->rowCount() == 1);
        return $resu;
    }

    //Modificar
    public function modCliente($cliente): bool
    {
        $this->stmt_modcliente->bindValue(':first_name', $cliente->first_name);
        $this->stmt_modcliente->bindValue(':last_name', $cliente->last_name);
        $this->stmt_modcliente->bindValue(':email', $cliente->email);
        $this->stmt_modcliente->bindValue(':gender', $cliente->gender);
        $this->stmt_modcliente->bindValue(':ip_address', $cliente->ip_address);
        $this->stmt_modcliente->bindValue(':telefono', $cliente->telefono);
        $this->stmt_modcliente->bindValue(':id', $cliente->id);
        $this->stmt_modcliente->execute();
        $resu = ($this->stmt_altacliente->rowCount() == 1);
        return $resu;
    }

    //DELETE
    public function borrarCliente(String $id): bool
    {
        $this->stmt_borcliente->bindValue(':id', $id);
        $this->stmt_borcliente->execute();
        $resu = ($this->stmt_borcliente->rowCount() == 1);
        return $resu;
    }

    // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    {
        trigger_error('La clonación no permitida', E_USER_ERROR);
    }
}
