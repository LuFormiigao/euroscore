<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS Da Aplicação -->
  <link rel="stylesheet" href="./css/style.css">
  <title><?php echo $title; ?></title>
</head>

<body>
<header>
    <div class="container reset">
      <div class="header-menu1 reset">
        <img src="./img/logotitulo.png" width="100" height="50" alt="logo EuroScore">
        <nav>
          <ul>
            <li class="header-link"><a href="?page=home">Inicio</a></li>
            <li class="header-link"><a href="?page=champions">Competições</a></li>
            <li class="header-link"><a href="/">Partidas</a></li>
            <li class="header-link"><a href="/">Noticias</a></li>
          </ul>
        </nav>
      </div>
      <div class="header-menu2 reset">
        <div class="pesquisar"><img src="./img/icons/lupa.svg" width="30" alt="Lupa"></div>
        <a href="?page=login" class="login">Login</a>
      </div>
    </div>
  </header>