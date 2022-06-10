<?php
require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Vaga;

define('TITLE', 'Editar vaga');

//VALIDAÇÃO DO ID
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

//CONSULTA A VAGA
$obVaga = Vaga::getVaga($_GET['id']);

//VALIDAÇÃO DA VAGA
if (!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}


//VALIDAR FORMULARIO
if (isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'], $_POST['titulo'],)) {
    
    $obVaga->titulo = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo = $_POST['ativo'];
    $obVaga->atualizar();

    header("location: index.php?status=success");
    exit;
}

include  __DIR__ . '/includes/header.php';


include __DIR__ . '/includes/formulario.php';


include  __DIR__ . '/includes/footer.php';
