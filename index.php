<?php

use App\Entity\Vaga;

require __DIR__ .'/vendor/autoload.php';

$vagas = Vaga::getVagas();

include  __DIR__.'/includes/header.php';


include __DIR__ .'/includes/listagem.php';


include  __DIR__.'/includes/footer.php';

?>

