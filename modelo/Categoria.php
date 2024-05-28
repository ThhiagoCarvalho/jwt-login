<?php
require_once ("modelo/Banco.php");

class Categoria implements JsonSerializable
{
    private $idCategoria;
    private $nomeCategoria;
    
    // Método necessário pela interface JsonSerializable para serialização do objeto para JSON
    public function jsonSerialize()
    {
        $objetoResposta = new stdClass();
        $objetoResposta->idCategoria = $this->idCategoria;
        $objetoResposta->nomeCategoria = $this->nomeCategoria;

        return $objetoResposta;
    }
    
    public function create()
    {
        $conexao = Banco::getConexao();
        $SQL = "INSERT INTO categoria (nomeCategoria)VALUES(?);";

        $prepareSQL = $conexao->prepare($SQL);
        $prepareSQL->bind_param("s", $this->nomeCategoria);
        $executou = $prepareSQL->execute();
        $idDate = $conexao->insert_id;
        $this->setIdCategoria($idDate);
        return $executou;
    }
    
    public function delete()
    {
        $conexao = Banco::getConexao();
        $SQL = "delete from categoria where idCategoria=?;";
        $prepareSQL = $conexao->prepare($SQL);
        $prepareSQL->bind_param("i", $this->idCategoria);

        return $prepareSQL->execute();
    }

    public function update()
    {
        $conexao = Banco::getConexao();
        // Define a consulta SQL para atualizar o nome do cargo pelo ID
        $SQL = "update categoria set nomeCategoria= ? where idCategoria=?";
        $prepareSQL = $conexao->prepare($SQL);
        $prepareSQL->bind_param("si", $this->nomeCategoria, $this->idCategoria);
        $executou = $prepareSQL->execute();
        return $executou;
    }
    
    public function isCategoria()
    {
        $conexao = Banco::getConexao();
        $SQL = "SELECT COUNT(*) AS qtd FROM categoria WHERE nomeCategoria =?;";
        $prepareSQL = $conexao->prepare($SQL);
        $prepareSQL->bind_param("s", $this->nomeCategoria);
        $executou = $prepareSQL->execute();

        // Obtém o resultado da consulta
        $matrizTuplas = $prepareSQL->get_result();

        // Extrai o objeto da tupla
        $objTupla = $matrizTuplas->fetch_object();
        // Retorna se a quantidade de cargos encontrados é maior que zero
        return $objTupla->qtd > 0;

    }
    
    public function readAll()
    {
        $conexao = Banco::getConexao();
        $SQL = "Select * from categoria order by nomeCategoria";
        $prepareSQL = $conexao->prepare($SQL);
        $executou = $prepareSQL->execute();

        $matrizTuplas = $prepareSQL->get_result();
       
        $vetorCategorias = array();
        $i = 0;
        // Itera sobre as tuplas do resultado
        while ($tupla = $matrizTuplas->fetch_object()) {

            $vetorCategorias[$i] = new Categoria();
            // Define o ID e o nome do cargo na instância
            $vetorCategorias[$i]->setIdCategoria($tupla->idCategoria);
            $vetorCategorias[$i]->setNomeCategoria($tupla->nomeCategoria);
            $i++;
        }
        return $vetorCategorias;
    }
    
    // Método para ler um cargo do banco de dados com base no ID
    public function readByID()
    {
        $conexao = Banco::getConexao();
        $SQL = "SELECT * FROM categoria WHERE idCategoria=?;";

        $prepareSQL = $conexao->prepare($SQL);

        $prepareSQL->bind_param("i", $this->idCategoria);
        $executou = $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();

        $vetorCategorias = array();
        $i = 0;

        while ($tupla = $matrizTuplas->fetch_object()) {

            $vetorCategorias[$i] = new Categoria();
            // Define o ID e o nome do cargo na instância
            $vetorCategorias[$i]->setIdCategoria($tupla->idCategoria);
            $vetorCategorias[$i]->setNomeCategoria($tupla->nomeCategoria);
            $i++;
        }
        // Retorna o vetor com os cargos encontrados
        return $vetorCategorias;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
        return $this;
    }

    public function getNomeCategoria()
    {
        return $this->nomeCategoria;
    }

    public function setNomeCategoria($nameCategoria)
    {
        $this->nomeCategoria = $nameCategoria;
        return $this;
    }
}

?>
