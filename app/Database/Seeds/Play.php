<?php


namespace App\Database\Seeds;


class Play extends SistemaHospitalar {
    public $_QTD = 1000;

    public function run() {

        $this->gerarAdm(5);
        $this->gerarRecepcionistas(10);
        $this->gerarQuartos(30);
        $this->gerarConvenios(4);
        $this->gerarPacientes($this->_QTD);
        $this->gerarDoutores(20);
        $this->gerarConsultas($this->_QTD);
        $this->gerarInternacao(20);
        $this->gerarExames(30);
        $this->gerarDiagnosticos(30);
        $this->gerarVisitantes($this->_QTD);
        $this->gerarVisitas($this->_QTD);
    }


}
