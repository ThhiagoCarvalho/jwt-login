<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");

// Definição da classe Funcionario, que implementa a interface JsonSerializable
class Usuario implements JsonSerializable
{
    // Propriedades privadas da classe
    private $idUsuario;
    private $nomeUsuario;
    private $dataDate;
    private $categoriaDate;
    private $localizacaoDate;
    private $categoria;

    // Construtor da classe
    public function __construct()
    {
        $this->categoria = new Categoria();
        $this->objJson = new stdClass();
    }

    public function jsonSerialize()
    {
        // Cria um objeto stdClass para armazenar os dados do funcionário
        $respostaPadrao = new stdClass();
        $respostaPadrao->idUsuario = $this->idUsuario;
        $respostaPadrao->nomeUsuario = $this->nomeUsuario;
        $respostaPadrao->dataDate = $this->dataDate;
        $respostaPadrao->categoriaDate = $this->categoriaDate;
        $respostaPadrao->localizacaoDate = $this->localizacaoDate;

        $respostaPadrao->idCategoria = $this->categoria->getIdCategoria();
        return $respostaPadrao;
    }

    // Método para criar um novo funcionário no banco de dados
    public function create()
    {
        $conexao = Banco::getConexao();
        $SQL = "insert into Usuario (dataDate,categoria_Date,localizacaoDate,Categoria_idCategoria,nomeUsuario) values(?,?,?,?,?)";
        $prepararSQL = $conexao->prepare($SQL);
        $idCategoria = $this->categoria->getIdCategoria();
        $prepararSQL->bind_param("sssis", $this->dataDate, $this->categoriaDate, $this->localizacaoDate, $idCategoria, $this->nomeUsuario);
        $executar = $prepararSQL->execute();
        // Obtém o ID do funcionário cadastrado

        $idData = $conexao->insert_id;
        $this->setIdUsuario($idData);
        $prepararSQL->close();
        return $executar;
    }

    // Método para criar um novo funcionário no banco de dados
    public function createFromCSV()
    {
        $conexao = Banco::getConexao();
        $SQL = "INSERT into Usuario 
        (nomeUsuario, dataDate, categoriaDate, localizacaoDate,Categoria_idCategoria) 
        VALUES(?,?,?,?,(SELECT idCategoria FROM categoria WHERE nomeCategoria = ? ))";
        $prepararSQL = $conexao->prepare($SQL);
        // Obtém o ID do cargo associado ao funcionário
        $nomeCategoria = $this->categoria->getNomeCategoria();
        // Define os parâmetros da consulta com os dados do funcionário e o ID do cargo
        $prepararSQL->bind_param(
            "sssss",
            $this->nomeUsuario,
            $this->dataDate,
            $this->categoriaDate,
            $this->localizacaoDate,
            $this->$nomeCategoria
        );

        $executar = $prepararSQL->execute();
        // Obtém o ID do funcionário cadastrado
        $idData = $conexao->insert_id;
        // Define o ID do funcionário na instância atual da classe
        $this->setIdUsuario($idData);

        $prepararSQL->close();
        return $executar;
    }
    // Método para atualizar os dados de um funcionário no banco de dados
    public function update()
    {
        $conexao = Banco::getConexao();
        $SQL = "update Usuario set dataDate=?, categoria_Date=?,localizacaoDate=?, Categoria_idCategoria=?,nomeUsuario=?  where idUsuario=?";
        $prepararSQL = $conexao->prepare($SQL);
        $idCategoria = $this->getCategoria()->getIdCategoria();
        $prepararSQL->bind_param("sssisi", $this->dataDate, $this->categoriaDate, $this->localizacaoDate, $idCategoria, $this->nomeUsuario, $this->idUsuario);

        $executar = $prepararSQL->execute();
        $prepararSQL->close();
        return $executar;
    }

    public function delete()
    {
        $conexao = Banco::getConexao();
        $SQL = "delete from Usuario where idUsuario = ?";

        $prepararSQL = $conexao->prepare($SQL);
        $prepararSQL->bind_param("i", $this->idUsuario);
        $executou = $prepararSQL->execute();
        $prepararSQL->close();
        return $executou;
    }

    // Método para obter os dados de um funcionário pelo ID
    public function readById()
    {
        $conexao = Banco::getConexao();
        $SQL = "SELECT * FROM usuario JOIN categoria ON usuario.Categoria_idCategoria= categoria.idCategoria WHERE idUsuario=?; ";

        $prepararSQL = $conexao->prepare($SQL);
        $prepararSQL->bind_param("i", $this->idUsuario);
        $executou = $prepararSQL->execute();
        $matrizTuplas = $prepararSQL->get_result();
        // Inicializa um contador
        $i = 0;

        $usuario[0] = new Usuario();

        while ($tupla = $matrizTuplas->fetch_object()) {
            // Define os dados do funcionário na instância atual da classe
            $usuario[0]->setIdUsuario($tupla->idUsuario);
            $usuario[0]->setNomeUsuario($tupla->nomeUsuario);
            $usuario[0]->setDataDate($tupla->dataDate);
            $usuario[0]->setCategoriaDate($tupla->categoria_Date);
            $usuario[0]->setLocalizacaoDate($tupla->localizacaoDate);

            $categoria = new Categoria();
            $categoria->setIdCategoria($tupla->idCategoria);
            $categoria->setNomeCategoria($tupla->nomeCategoria);

            // Define o cargo do funcionário
            $usuario[0]->setCategoria($categoria);
        }
        // Retorna o array contendo os funcionários encontrados
        return $usuario;
    }
    public function isData()
    {
        $conexao = Banco::getConexao();
        $SQL = "SELECT COUNT(*) AS qtd FROM usuario WHERE dataDate =?;";
        $prepareSQL = $conexao->prepare($SQL);
        $prepareSQL->bind_param("s", $this->dataDate);
        $executou = $prepareSQL->execute();

        $matrizTuplas = $prepareSQL->get_result();
        $objTupla = $matrizTuplas->fetch_object();
        // Retorna se a quantidade de cargos encontrados é maior que zero
        return $objTupla->qtd > 0;

    }

    // Método para obter todos os funcionários
    public function readAll()
    {
        $conexao = Banco::getConexao();
        $SQL = "SELECT * FROM usuario JOIN categoria ON usuario.Categoria_idCategoria = categoria.idCategoria  order by nomeUsuario";

        $prepararSQL = $conexao->prepare($SQL);
        $executou = $prepararSQL->execute();
        // Obtém o resultado da consulta
        $matrizTuplas = $prepararSQL->get_result();
        $i = 0;
        $usuarios = array();
        // Itera sobre as tuplas retornadas

        while ($tupla = $matrizTuplas->fetch_object()) {
            // Cria um novo objeto da classe Funcionario e define seus dados
            $usuarios[$i] = new Usuario();
            $usuarios[$i]->setIdUsuario($tupla->idUsuario);
            $usuarios[$i]->setNomeUsuario($tupla->nomeUsuario);
            $usuarios[$i]->setDataDate($tupla->dataDate);
            $usuarios[$i]->setCategoriaDate($tupla->categoria_Date);
            $usuarios[$i]->setLocalizacaoDate($tupla->localizacaoDate);

            // Cria um novo objeto da classe Cargo e define seus dados
            $categoria = new Categoria();
            $categoria->setIdCategoria($tupla->idCategoria);
            $categoria->setNomeCategoria($tupla->nomeCategoria);

            // Define o cargo do funcionário
            $usuarios[$i]->setCategoria($categoria);
            $i++;
        }
        return $usuarios;
    }
    public function getIdCategoria()
    {
        return $this->idUsuario;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
        return $this;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
        return $this;
    }

    // Método getter para nomeFuncionario
    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }

    // Método setter para nomeFuncionario
    public function setNomeUsuario($nomeUsuario)
    {
        $this->nomeUsuario = $nomeUsuario;
        return $this;
    }

    // Método getter para email
    public function getDataDate()
    {
        return $this->dataDate;
    }

    // Método setter para email
    public function setDataDate($dataDate)
    {
        $this->dataDate = $dataDate;
        return $this;
    }

    // Método getter para senha
    public function getCategoriaDate()
    {
        return $this->categoriaDate;
    }

    // Método setter para senha
    public function setCategoriaDate($categoria_Date)
    {
        $this->categoriaDate = $categoria_Date;
        return $this;
    }

    // Método getter para recebeValeTransporte
    public function getLocalizacaoDate()
    {
        return $this->localizacaoDate;
    }

    // Método setter para recebeValeTransporte
    public function setLocalizacaoDate($localizacaoDate)
    {
        $this->localizacaoDate = $localizacaoDate;
        return $this;
    }

    // Método getter para cargo
    public function getCategoria()
    {
        return $this->categoria;
    }

    // Método setter para cargo
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }
}
?>