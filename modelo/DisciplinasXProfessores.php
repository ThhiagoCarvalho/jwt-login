<?php
require_once("modelo/Banco.php");

class DisciplinasXProfessores implements JsonSerializable
{

    private $idDisciplinasXProfessores;
    private $curso;
    private $cargaHoraria;
    private $anoLetivo;
    private $ID_idprofessor;
    private$ID_iddisciplina; 
        public function  jsonSerialize(){
            $obj = new stdClass();
            $obj->idDisciplinasXProfessore = $this->getIdDisciplinasXProfessores();
            $obj->curso = $this->getCurso() ;
            $obj->anoLetivo = $this->getanoLetivo() ;
            $obj->ID_idprofessor = $this->getID_idprofessor();
            $obj->ID_iddisciplina = $this->getID_iddisciplina();
            return $obj;
            
        }


        public function create (){
            $conexao = Banco::getConexao();
            $sql = "insert into disciplinasxprofessores (curso,cargaHoraria,anoLetivo,ID_idprofessor,ID_iddisciplina) values (?,?,?,?,?)";
            $preparsql = $conexao->prepare($sql);
            $preparsql->bind_param("siiii",$this->curso,$this->cargaHoraria,$this->anoLetivo,$this->ID_idprofessor,$this->ID_iddisciplina) ;
            $executou = $preparsql->execute();
            $idCadastrado = $conexao->insert_id;
            $this->setIdDisciplinasXProfessores($idCadastrado) ;
            return $executou;

        }
        public function IsCurso (){
            $conexao = Banco::getConexao();
            $sql = "select count(*) as qtd from disciplinasxprofessores where curso = ?";
            $preparsql = $conexao->prepare($sql);
            $preparsql->bind_param("s",$this->curso);
            $executou = $preparsql->execute();

            $matriz = $preparsql->get_result();
            $tupla = $matriz->fetch_object();
            return $tupla->qtd>0;
        }

        public function ProfessorexXDisciplinas (){
            $conexao = Banco::getConexao();
            $sql = "select count(*) as qtd from disciplinasxprofessores where ID_idprofessor = ? and ID_iddisciplina = ?";
            $preparsql = $conexao->prepare($sql);
            $preparsql->bind_param("ii",$this->ID_idprofessor,$this->ID_iddisciplina);
            $executou = $preparsql->execute();

            $matriz = $preparsql->get_result();
            $tupla = $matriz->fetch_object();
            return $tupla->qtd>0;
        }
        public function delete (){
            $conexao = Banco::getConexao();
            $sql = "delete from disciplinasxprofessores where iddisciplinasxprofessores = ? ";
            $preparsql = $conexao->prepare($sql);
            $preparsql->bind_param("i",$this->idDisciplinasXProfessores);
            return $preparsql->execute();
            
        }
        public function update (){
            $conexao = Banco::getConexao();
            $sql = "update disciplinasxprofessores set  curso=?,cargaHoraria=?,anoLetivo=?,ID_idprofessor=?,ID_iddisciplina=? where iddisciplinasxprofessores = ?";
            $preparsql = $conexao->prepare($sql);
            $preparsql->bind_param("siiiii",$this->curso,$this->cargaHoraria,$this->anoLetivo,$this->ID_idprofessor,$this->ID_iddisciplina,$this->idDisciplinasXProfessores);
            return $ $preparsql->execute();
            
        }
        public function ReadALL (){
                $conexao = Banco::getConexao();
                $sql = "select * from disciplinasxprofessores order by iddisciplinasxprofessores  ";
                $preparesql = $conexao->prepare($sql);
                $executou = $preparesql->execute();
                $matriz = $preparesql->get_result();
                $vetorDXP = array();
                $i = 0;
            while ($tupla = $matriz->fetch_object()){
                $vetorDXP[$i] = new DisciplinasXProfessores();
                $vetorDXP[$i]->setIdDisciplinasXProfessores($tupla->iddisciplinasxprofessores);
                $vetorDXP[$i]->setCurso($tupla->curso);
                $vetorDXP[$i]->setCargahoraria($tupla->cargaHoraria);
                $vetorDXP[$i]->setanoLetivo($tupla->anoLetivo);
                $vetorDXP[$i]->setID_idprofessor($tupla->ID_idprofessor);
                $vetorDXP[$i]->setID_iddisciplina($tupla->ID_iddisciplina);
                $i ++;
            }
            return $vetorDXP;
        }
            
        
        public function ReadById (){
            $conexao = Banco::getConexao();
            $sql = "select * from disciplinasxprofessores where iddisciplinasxprofessores = ?";
            $prepararsql = $conexao->prepare($sql);
            $prepararsql->bind_param("i", $this->idDisciplinasXProfessores) ;
            $executou = $prepararsql->execute();

            $matriz = $prepararsql->get_result();
            $vetorDXP = array();
            $i = 0;
        while ($tupla = $matriz->fetch_object()){
            $vetorDXP[$i] = new DisciplinasXProfessores();
            $vetorDXP[$i]->setIdDisciplinasXProfessores($tupla->iddisciplinasxprofessores);
            $vetorDXP[$i]->setCurso($tupla->curso);
            $vetorDXP[$i]->setCargahoraria($tupla->cargaHoraria);
            $vetorDXP[$i]->setanoLetivo($tupla->anoLetivo);
            $vetorDXP[$i]->setID_idprofessor($tupla->ID_idprofessor);
            $vetorDXP[$i]->setID_iddisciplina($tupla->ID_iddisciplina);

            $i ++;
        }
        return $vetorDXP;
    }


    public function setCargahoraria ($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
    }
    public function getCargaHoraria () {
        reset($this->cargaHoraria);
    }
    
    public function setIdDisciplinasXProfessores ($idDisciplinasXProfessores){
        $this->idDisciplinasXProfessores = $idDisciplinasXProfessores;
    }
    public function getIdDisciplinasXProfessores(){
        return $this->idDisciplinasXProfessores ;
    }

    public function setCurso ($curso){
        $this->curso = $curso;
    }

    public function getCurso(){
        return $this->curso;
    }

    public function setanoLetivo ($anoLetivo){
        $this->anoLetivo = $anoLetivo;
    }
    public function getanoLetivo (){
        return $this->anoLetivo ;
    }
    public function setID_idprofessor ($id_id_professor){
        $this->ID_idprofessor = $id_id_professor;
    }
    public function getID_idprofessor(){
        return $this->ID_idprofessor ;
    }

    public function setID_iddisciplina ($id_id_disciplina){
        $this->ID_iddisciplina = $id_id_disciplina;
    }
    public function getID_iddisciplina(){
        return $this->ID_iddisciplina ;
    }
    





























}



?>