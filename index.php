<?php

require "config.php";

$rota= $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "autoescola" : "teste");

function teste(){
    echo "API respondendo com sucesso!";
}

function createAlunos($con){
    $nome_aluno = $_POST["nome_aluno"];
    $email_aluno = $_POST["email_aluno"];
    $telefone_aluno = $_POST["telefone_aluno"];
    $data_nascimento_aluno = $_POST["data_nascimento_aluno"];
    try {
        $stmt = $con->prepare("INSERT INTO alunos (nome, email, telefone, data_nascimento) VALUES (?, ?, ?, ?)");
        $stmt ->execute([$nome_aluno, $email_aluno, $telefone_aluno, $data_nascimento_aluno]);
        header("Location: ../front/index.html");
    }catch (PDOException $e){
        echo json_encode(["mensagem" => $e]);
        header("Location: ../front/erro.html");
    }
}
function readAlunos($con){
    $stmt = $con->query("SELECT * FROM Alunos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createInstrutor($con){
    $id_instrutor = $_POST["id_instrutor"];
    $nome_instrutor = $_POST["nome_instrutor"];
    $email_instrutor = $_POST["email_instrutor"];
    $telefone_instrutor = $_POST["telefone_instrutor"];
    $categoria_cnh = $_POST["categoria_cnh"];
    $data_cadastro_instrutor = $_POST["data_cadastro_instrutor"];
    try {
        $stmt = $con->prepare("INSERT INTO instrutores (nome_instrutor, email_instrutor, telefone_instrutor, categoria_cnh) VALUES (?, ?, ?, ?)");
        $stmt ->execute([$nome_instrutor, $email_instrutor, $telefone_instrutor, $categoria_cnh, ]);
        header("Location: ../front/index.html");
    }catch (PDOException $e){
        
        header("Location: ../front/erro.html");
    }
}
function readInstrutor($con){
    $stmt = $con->query("SELECT * FROM Instrutores");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    createAlunos($con);
}elseif ($rota === "alunos"){
    readAlunos($con);
}elseif ($rota === "instrutores"){
    readInstrutor($con);
}else {
    teste();
}

?>