<?php
require_once("modelo/Banco.php");

class Disciplina implements JsonSerializable{

    private $idDisciplina;
    private $nomeDisciplina;
    public function jsonSerialize()
    {
        $obj =new stdClass();
        $obj->idDisciplina= $this->getIdDisciplina();
        $obj->nomDisciplina = $this->getNomeDisciplina();
        return $obj;
    }

    public function create (){
        $conexao = Banco ::getConexao();
        $sql = "insert into disciplinas (nomeDisciplina) values (?) " ;
        $prepararsql = $conexao->prepare($sql);
        $prepararsql -> bind_param("s",$this->nomeDisciplina);
        $executou = $prepararsql -> execute();
        $idCadastrado = $conexao->insert_id;
        $this->setIdDisciplina($idCadastrado);
        return $executou;
    }

    public function isDisciplina (){
        $conexao = Banco :: getConexao();
        $sql = "select count(*) as qtd from disciplinas where nomeDisciplina =? ";
        $prepararsql = $conexao->prepare($sql);
        $prepararsql -> bind_param("s",$this->nomeDisciplina);
        $executou = $prepararsql -> execute();

        $matriz = $prepararsql->get_result();

        $objTupla = $matriz->fetch_object();

        return $objTupla->qtd> 0;
    }

    public function delete () {
        $conexao = Banco::getConexao();
        $sql = "delete from disciplinas where idDisciplina = ?";
        $prepararsql = $conexao->prepare($sql);
        $prepararsql -> bind_param("i",$this->idDisciplina);
        return $prepararsql -> execute();
    }

    public function update () {
    $conexao = Banco::getConexao();
    $sql = "update disciplinas set nomeDisciplina = ? where idDisciplina =? ";
    $prepararsql = $conexao->prepare($sql);
    $prepararsql -> bind_param("si", $this->nomeDisciplina, $this->idDisciplina);
    return $prepararsql -> execute();
    }

    public function ReallAll () {
        $conexao = Banco::getConexao();
        $sql = "select * from disciplinas order by idDisciplina";
        $prepararsql = $conexao->prepare($sql);
        $executou =  $prepararsql->execute();
        $matriz = $prepararsql->get_result();
        $vetorDisicplina = array();
        $i = 0;
        while ($tupla = $matriz->fetch_object())   {
            $vetorDisicplina[$i] = new Disciplina();
            $vetorDisicplina[$i]->setIdDisciplina($tupla->idDisciplina);
            $vetorDisicplina[$i]->setNomeDisciplina($tupla->nomeDisciplina);
            $i++;
        }
        return $vetorDisicplina;    
    }

    public function ReadById(){
        $conexao = Banco::getConexao();
        $sql = "select * from disciplinas where idDisciplina = ?";
        $prepararsql = $conexao->prepare($sql);
        $prepararsql->bind_param("i", $this->idDisciplina);
        $executou = $prepararsql->execute();
        $matriz = $prepararsql->get_result();
        $vetorDisicplina = array();
        $i = 0;
        while ($tupla = $matriz->fetch_object())   {
            $vetorDisicplina[$i] = new Disciplina();
            $vetorDisicplina[$i]->setIdDisciplina($tupla->idDisciplina);
            $vetorDisicplina[$i]->setNomeDisciplina($tupla->nomeDisciplina);
            $i++;
        }
        return $vetorDisicplina;  
    }

    
public function getIdDisciplina(){
    return $this->idDisciplina; 
}
public function setIdDisciplina($idDisciplina)
{   
    $this->idDisciplina=$idDisciplina;
}
public function setNomeDisciplina($nomeDisciplina){
    $this->nomeDisciplina=$nomeDisciplina;
}
public function getNomeDisciplina(){
    return $this->nomeDisciplina;
}

}
?>
