<?php
    $homePath = 'workspace/Informatica/Biblioteca/';
    $currentPage = rtrim(str_replace($homePath, '', $_SERVER['SCRIPT_NAME']), '/');
    if($currentPage == "/index.php")
    {
        echo '<span class="selectedLink">Home</span>';
        echo '<a class="link" href="catalogo.php">Catalogo</a>';
    }
    if($currentPage == "/catalogo.php")
    {
        echo '<a class="link" href="index.php">Home</a>';
        echo '<span class="selectedLink">Catalogo</span>';
    }
?>