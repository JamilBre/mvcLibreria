<?php
    class Modelo{

        //Attributos de la clase
        private $Modelo;
        private $db;
        private $datos;

        //Metodos de la clase
        public function __construct()
        {
            $this->Modelo =array();
            $this->db = new PDO('mysql:host=localhost;dbname=BDProductos',"root","");
        }
        public function insertar($tabla, $data)
        {
            $consulta="insert into ".$tabla." values(null,". $data .")";
            $resultado= $this->db->query($consulta);
            if ($resultado){
                return true;
            }else{
                return false;
            }
        }
        public function mostrar($tabla, $condicion)
        {
            $consul="select * from ".$tabla." where ".$condicion.";";
            $resu= $this->db->query($consul);
            while($filas = $resu->FETCHALL(PDO::FETCH_ASSOC)) {
                $this->datos[]=$filas;
            }
            return $this->datos;
        }
        public function actualizar($tabla, $data, $condicion)
        {
            $consulta="update ".$tabla." set ". $data ." where ".$condicion;
            $resultado=$this->db->query($consulta);
            if ($resultado){
                return true;
            } else{
                return false;
            }
        }
        public function eliminar($tabla, $condicion)
        {
            $eli = "delete from ".$tabla." where ".$condicion;
            $res = $this->db->query($eli);
            if ($res){
                return true;
            } else{
                return false;
            }
        }
    }
?>