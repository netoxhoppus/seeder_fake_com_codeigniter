<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SistemaHospitalar extends Seeder {


    public function gerarRecepcionistas($quantidade) {// GERA RECEPCIONISTAS

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {

            $genre = $this->genero();
            if ($genre['genre'] == 'male') {
                $genero = 'M';
            } elseif ($genre['genre'] == 'female') {
                $genero = 'F';
            }

            $data = [
                'nome' => $faker->name($genre['genre']),
                'email' => $faker->unique->email(),
                'senha' => $faker->password,
                'cpf' => $faker->numerify("###########"),
                'turno' => $faker->randomElements(["D", "N"])[0],
                'genero' => $genre['genero'],
                'celular' => $faker->phoneNumber()
            ];
            //print_r($data);
            $this->inserir('recepcionistas', $data);
        }

    }

    public function gerarDoutores($quantidade) {// GERA DOUTORES

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {

            $genre = $this->genero();

            $data = [
                'nome' => $faker->name($genre['genre']),
                'email' => $faker->email(),
                'senha' => $faker->password(5,8),
                'cpf' => $faker->numerify("###########"),
                'turno' => $faker->randomElements(["D", "N"])[0],
                'genero' => $genre['genero'],
                'celular' => $faker->phoneNumber(),
                'especialidade' => $faker->randomElements(["Ginecologia", "Obstetrícia", "Pediatria", "Clínico geral"])[0],
                'valorConsulta' => $faker->randomFloat(2, 50, 100),
                'valorExame' => $faker->randomFloat(2, 100, 500),
            ];
           // print_r($data);
            $this->inserir('doutores', $data);
        }
    }

    //gerarConsultas
    public function gerarConsultas($quantidade) {//gera consultas

        $faker = \Faker\Factory::create("pt_BR");

        $query_paci = $this->db->query("SELECT min(id), max(id) FROM pacientes")->getResult('array');
        $query_doc = $this->db->query("SELECT min(id), max(id) FROM doutores")->getResult('array');
        //dd($query_doc);

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'pacienteID' => $faker->numberBetween($query_paci[0]['min(id)'], $query_paci[0]['max(id)']),
                'doutorID' => $faker->numberBetween($query_doc[0]['min(id)'], $query_doc[0]['max(id)']),
                'dataConsulta' => $faker->dateTime('now')->format('Y-m-d\TH:i:s'),
                'preco' => $faker->randomFloat(2, 50, 100),
            ];
            //print_r($data);
            $this->inserir('consultas', $data);
        }
    }

    //gerarConsultas
    public function gerarPacientes($quantidade) {//gera consultas

        $faker = \Faker\Factory::create("pt_BR");

        $query = $this->db->query("SELECT MIN(id), MAX(id) FROM convenios")->getResult('array');
        //dd($query);

        for ($i = 0; $i < $quantidade; $i++) {

            $genre = $this->genero();

            $data = [
                'nome' => $faker->name($genre['genre']),
                'cpf' => $faker->numerify("###########"),
                'celular' => $faker->phoneNumber(),
                'genero' => $genre['genero'],
                'convenioId' => $faker->numberBetween($query[0]['MIN(id)'], $query[0]['MAX(id)'])
            ];
            //print_r($data);
            $this->inserir('pacientes', $data);

        }


    }


    //gerarConvênios
    public function gerarConvenios($quantidade) {//gera consultas

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'nome' => $faker->unique->randomElements(['Unimed', 'Jarapax', 'Uniodonto', 'SUS']),
                'desconto' => $faker->randomFloat(1, 10, 80)
            ];
            //print_r($data);
            $this->inserir('convenios', $data);
        }
    }

    public function gerarQuartos($quantidade) {

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'numeroQuarto' => $faker->unique->randomElement([
                    1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                    11, 12, 13, 14, 15, 16, 17, 18, 19,
                    20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30]),
                'disponivel' => $faker->randomElement([0, 1])
            ];
            //print_r($data);
            $this->inserir('quartos', $data);
        }

    }


    public function gerarInternacao($quantidade) {
        $faker = \Faker\Factory::create("pt_BR");

        $query_paci = $this->db->query("SELECT min(id), max(id) FROM pacientes")->getResult('array');
        $query_doc = $this->db->query("SELECT min(id), max(id) FROM doutores")->getResult('array');
        $query_quarto = $this->db->query("SELECT min(numeroQuarto), max(numeroQuarto) FROM quartos")->getResult('array');

        //dd($query_quarto);

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'pacienteID' => $faker->numberBetween($query_paci[0]['min(id)'], $query_paci[0]['max(id)']),
                'doutorID' => $faker->numberBetween($query_doc[0]['min(id)'], $query_doc[0]['max(id)']),
                'descricao' => $faker->text(200),
                'tipoInternacao' => $faker->randomElement(['compulsória', 'voluntária']),
                'quartoId' => $faker->numberBetween($query_quarto[0]['min(numeroQuarto)'], $query_quarto[0]['max(numeroQuarto)']),
                'dataEntrada' => $faker->dateTime('now')->format('Y-m-d\TH:i:s'),
                'dataSaida' => $faker->dateTime('now')->format('Y-m-d\TH:i:s'),
                'preco' => $faker->randomFloat(2, 50, 900),
                'dataUltimaAtualizacao' => $faker->dateTime('now')->format('Y-m-d\TH:i:s')
            ];
            //print_r($data);
            $this->inserir('internacao', $data);
        }
    }

    public function gerarExames($quantidade) {
        $faker = \Faker\Factory::create("pt_BR");
        $query_consul = $this->db->query("SELECT min(id), max(id) FROM consultas")->getResult('array');

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'consultaID' => $faker->numberBetween($query_consul[0]['min(id)'], $query_consul[0]['max(id)']),
                'dataExame' => $faker->dateTime('now')->format('Y-m-d\TH:i:s'),

                'preco' => $faker->randomFloat(2, 50, 900),
                'tipoExame' => $faker->text(20),
            ];
            //print_r($data);
            $this->inserir('exames', $data);
        }

    }

    public function gerarDiagnosticos($quantidade) {
        $faker = \Faker\Factory::create("pt_BR");
        $query_exame = $this->db->query("SELECT min(id), max(id) FROM exames")->getResult('array');

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'descricao' => $faker->text(200),
                'exameId' => $faker->numberBetween($query_exame[0]['min(id)'], $query_exame[0]['max(id)']),
                'dataDiagnostico' => $faker->dateTime('now')->format('Y-m-d\TH:i:s'),
            ];
            //print_r($data);
            $this->inserir('diagnosticos', $data);
        }

    }

    public function gerarVisitantes($quantidade) {
        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $genre = $this->genero();

            $data = [
                'nome' => $faker->name($genre['genre']),
                'cpf' => $faker->numerify("###########"),
            ];
            //print_r($data);
            $this->inserir('visitantes', $data);
        }

    }

    public function gerarVisitas($quantidade) {
        $faker = \Faker\Factory::create("pt_BR");
        $query_visit = $this->db->query("SELECT min(id), max(id) FROM visitantes")->getResult('array');
        $query_inter = $this->db->query("SELECT min(id), max(id) FROM internacao")->getResult('array');

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'visitanteId' => $faker->numberBetween($query_visit[0]['min(id)'], $query_visit[0]['max(id)']),
                'dataVisita' => $faker->dateTime('now')->format('Y-m-d\TH:i:s'),
                'internacaoId' => $faker->numberBetween($query_inter[0]['min(id)'], $query_inter[0]['max(id)']),
            ];
            //print_r($data);
            $this->inserir('visitas', $data);
        }

    }

    public function gerarAdm($quantidade) {
        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'usuario' => $faker->userName,
                'senha' => $faker->password(5, 10),
                'isAtivo' => $faker->randomElement([0, 1])
            ];
           // print_r($data);
            $this->inserir('adm', $data);
        }
    }

    public function genero() {
        $faker = \Faker\Factory::create("pt_BR");
        $genre = $faker->randomElements(["male", "female"])[0];

        if ($genre == 'male') {
            $genero = 'M';
        } elseif ($genre == 'female') {
            $genero = 'F';
        }

        return $ar = [
            'genre' => $genre,
            'genero' => $genero
        ];

    }


    public function inserir($tabela, $array) {
        $builder = $this->db->table($tabela);
        $builder->insert($array);
    }

}