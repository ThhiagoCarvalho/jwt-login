<?php
require_once("modelo/Banco.php");
class Professor implements JsonSerializable
{
    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj ->idProfessor = $this->getIdProfessor();
        $obj ->nomeProfessor = $this->getNomeProfessor();
        return $obj;
    }
    private $idProfessor;
    private $nomeProfessor;
    private $salarioProfessor;
    private $telefoneProfessor;
    private $idadeProfessor;

   

    public function create (){
        $conexao = Banco::getConexao();
        $sql = "insert into professores (nomeProfessor,telefoneProfessor,salarioProfessor,idadeProfessor) values (?,?,?,?)";
        $prepararsql = $conexao->prepare($sql);
        $prepararsql->bind_param("ssii",$this->nomeProfessor,$this->telefoneProfessor,$this->salarioProfessor,$this->idadeProfessor);
        $executou = $prepararsql ->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setIdProfessor($idCadastrado);   
        return $executou;
    }
    public function isProfessor () {
    $conexao = Banco::getConexao();
    $sql = "select count(*) as qtd from professores where nomeProfessor = ?";
    $preparesql = $conexao->prepare($sql);
    $preparesql->bind_param("s", $this->nomeProfessor);
    $executou = $preparesql->execute();

    $matriz = $preparesql->get_result();

    $objTupla = $matriz->fetch_object();

    return $objTupla->qtd>0;
    }

    public function delete(){
        $conexao = Banco::getConexao();
        $sql = "delete from professores where idProfessor = ?";
        $prepararql = $conexao->prepare($sql);
        $prepararql->bind_param("i",$this->idProfessor);
        return $prepararql->execute();

    }

    public function update ()   {
    $conexao = Banco::getConexao();
    $sql = "update professores set nomeProfessor=?,telefoneProfessor=?,salarioProfessor=?,idadeProfessor=? where idProfessor = ?";
    $preparesql = $conexao->prepare($sql);
    $preparesql->bind_param("ssiii",$this->nomeProfessor,$this->telefoneProfessor,$this->salarioProfessor,$this->idadeProfessor, $this->idProfessor);
    $executou = $preparesql->execute();
    return $executou;
 
    }

    public function ReadALL (){
        $conexao = Banco::getConexao();
        $sql = "select * from professores order by idProfessor";
        $preparesql = $conexao->prepare($sql);
        $executou = $preparesql->execute();
        $matriz = $preparesql->get_result();
        $vetorProfessor = array();
        $i = 0;
        while ($tupla = $matriz->fetch_object()){
            $vetorProfessor[$i] = new Professor();
            $vetorProfessor[$i]->setIdProfessor($tupla->idProfessor);
            $vetorProfessor[$i]->setNomeProfessor($tupla->nomeProfessor);
            $i ++;
        }
        return $vetorProfessor;
    }

    public function ReadByid (){
        $conexao = Banco::getConexao();
        $sql = "select * from professores where idProfessor = ?";
        $preparesql = $conexao->prepare($sql);
        $preparesql->bind_param("i", $this->idProfessor);
        $executou = $preparesql->execute();
        $matriz = $preparesql->get_result();
        $vetorProfessor = array();
        $i = 0;
        while ($tupla = $matriz->fetch_object()){
            $vetorProfessor[$i] = new Professor();
            $vetorProfessor[$i]->setIdProfessor($tupla->idProfessor);
            $vetorProfessor[$i]->setNomeProfessor($tupla->nomeProfessor);
            $vetorProfessor[$i]->setTelefoneProfessor($tupla->telefoneProfessor);
            $vetorProfessor[$i]->setSalarioProfessor($tupla->salarioProfessor);
            $vetorProfessor[$i]->setIdadeProfessor($tupla->idadeProfessor);

            $i ++;
        }
        return $vetorProfessor;
    }
    public function getIdProfessor(){
        return $this->idProfessor;
    }
    public function setIdProfessor($idProfessor){
        $this->idProfessor = $idProfessor;
    }
    public function setNomeProfessor($nomeProfessor){
        $this->nomeProfessor = $nomeProfessor;
    }
    public function getNomeProfessor(){
        return $this->nomeProfessor;
    }

    public function setSalarioProfessor($salarioProfessor){

    }
    public function getSalarioProfessor(){
        return $this->salarioProfessor;
    }

    public function setTelefoneProfessor($telefoneProfessor ){
        $this->telefoneProfessor = $telefoneProfessor;
    }
    public function getTelefoneProfessor(){
     return $this->telefoneProfessor;   
    }

    public function setIdadeProfessor ( $idadeProfessor ){
     $this->idadeProfessor = $idadeProfessor;
    }
    public function getIdadeProfessor (){
        return $this->idadeProfessor;
    }
}
