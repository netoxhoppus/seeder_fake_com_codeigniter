<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeds extends Seeder {


    public function gerarRecepcionistas($quantidade) {// GERA RECEPCIONISTAS

        $faker = \Faker\Factory::create("pt_BR");

        $genre = $faker->randomElements(["male", "female"])[0];

        if ($genre == 'male') {
            $genero = 'M';
        } elseif ($genre == 'female') {
            $genero = 'F';
        }

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'nome' => $faker->name($genre),
                'email' => $faker->email(),
                'senha' => $faker->password,
                'cpf' => $faker->numerify("###########"),
                'turno' => $faker->randomElements(["D", "N"])[0],
                'genero' => $genero,
                'celular' => $faker->phoneNumber()
            ];
            //print_r($data);
            $this->inserir('recepcionistas', $data);
        }

    }

    public function gerarDoutores($quantidade) {// GERA DOUTORES

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'nome' => $faker->name(),
                'email' => $faker->email(),
                'senha' => $faker->password(),
                'cpf' => $faker->numerify("###########"),
                'turno' => $faker->randomElements(["D", "N"])[0],
                'genero' => $faker->randomElements(["M", "F"])[0],
                'celular' => $faker->phoneNumber(),
                'especialidade' => $faker->randomElements(["Ginecologia", "Obstetrícia", "Pediatria", "Clínico geral"])[0],
                'valorConsulta' => $faker->randomFloat(2, 50, 100),
                'valorExame' => $faker->randomFloat(2, 100, 500),
            ];
            //print_r($data);
            $this->inserir('doutores', $data);
        }
    }

    //gerarConsultas
    public function gerarConsultas($quantidade) {//gera consultas

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'pacienteID' => $faker->randomNumber(1, 99),
                'doutorID' => $faker->randomNumber(1, 99),
                'dataConsulta' => $faker->date(),
                'preco' => $faker->randomFloat(2, 50, 100),
            ];
            //print_r($data);
            $this->inserir('consultas', $data);
        }
    }

    //gerarConsultas
    public function gerarPacientes($quantidade) {//gera consultas

        $faker = \Faker\Factory::create("pt_BR");
        $genre = $faker->randomElements(["male", "female"])[0];

        if ($genre == 'male') {
            $genero = 'M';
        } elseif ($genre == 'female') {
            $genero = 'F';
        }

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'nome' => $faker->name($genre),
                'cpf' => $faker->numerify("###########"),
                'celular' => $faker->phoneNumber(),
                'genero' => $genero,
                'convenioId' => $faker->unique->randomNumber(1, 1000)
            ];
            //print_r($data);
            $this->inserir('pacientes', $data);
        }
    }

    //gerarConvênios
    public function gerarConvenios($quantidade) {//gera consultas

        $faker = \Faker\Factory::create("pt_BR");
        $genre = $faker->randomElements(["male", "female"])[0];

        if ($genre == 'male') {
            $genero = 'M';
        } elseif ($genre == 'female') {
            $genero = 'F';
        }

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'nome' => $faker->randomElements(['Unimed', 'Jarapax', 'Uniodonto', 'SUS']),
                'desconto' => $faker->randomFloat(1,10,80)
            ];
            //print_r($data);
            $this->inserir('convenios', $data);
        }
    }

    public function gerarQuartos($quantidade) {

        $faker = \Faker\Factory::create("pt_BR");

        for ($i = 0; $i < $quantidade; $i++) {
            $data = [
                'numeroQuarto' => $faker->unique->randomDigit(),
                'disponivel' => $faker->randomElement(['S', 'N'])
            ];
            print_r($data);
            $this->inserir('quartos', $data);
        }

    }


    public function inserir($tabela, $array) {
        $builder = $this->db->table($tabela);
        $builder->insert($array);
    }

}