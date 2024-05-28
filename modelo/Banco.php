<?php
    class Banco{
        private static $HOST='127.0.0.1';
        private static $USER= 'root';
        private static $PWD= '14031965Paulo';
        private static $DB= 'mydb';
        private static $PORT= 3306;
        private static $CONEXAO= null;

        private static function conectar(){
            error_reporting(E_ERROR | E_PARSE);
            if(Banco::$CONEXAO==null){
                Banco::$CONEXAO = new mysqli(Banco::$HOST,Banco::$USER,Banco::$PWD,Banco::$DB,Banco::$PORT);
                if(Banco::$CONEXAO->connect_error) {
                    $objResposta = new stdClass();
                    $objResposta->cod = 1; 
                    $objResposta->msg = "Erro ao conectar no banco"; 
                    $objResposta->erro = Banco::$CONEXAO->connect_error;
                    die(json_encode($objResposta));
                }
            }
        }
        
        public static function getConexao(){
            if(Banco::$CONEXAO==null){
                Banco::conectar();
            }
            return Banco::$CONEXAO;
        }
    }
?> 
