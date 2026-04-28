<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <!-- outras Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Marketplace de livros novos e usados.">
    <meta name="keywords" content="livros, marketplace, comprar, vender, novos, usados">
    <meta name="author" content="Gabriel Guerra, Selma Maria, Guilherme Medeiros">
    <meta name="robots" content="index, follow">
    
    <!-- Título -->
    <title>Livro Livre - Marketplace de Livros</title>

    <!-- Favicon -->
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/v4-shims.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&amp;family=Roboto+Mono:ital,wght@0,100..700;1,100..700&amp;family=Special+Gothic+Expanded+One&amp;display=swap" rel="stylesheet">
    <!-- Meu CSS -->    
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-- Meu JS -->
    <script src="script.js" defer=""></script>
</head>
<body>

    <!-- Header fixo -->
    <header id="topo" class="navbar navbar-expand-lg fixed-top py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand special-gothic" href="./index.php">Livraria Livro Livre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="./index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="./publicar.php">Publicar</a></li>
                    <li class="nav-item"><a class="nav-link" href="./contato.php">Contato</a></li>
                </ul>
            </div>
        </div>
    </header>
  
    <main class="my-5 py-5 container">
  
      <!-- Carousel -->
      <section id="carousel" class="mb-4">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/oferta.png" class="d-block w-100" alt="Oferta de 40% de desconto sobre best-sellers"/>
            </div>
            <div class="carousel-item">
              <img src="img/lancamento.png" class="d-block w-100" alt="Lançamento do livro 'O Hobbit'"/>
            </div>
            <div class="carousel-item">
              <img src="img/redes.png" class="d-block w-100" alt="Siga nosssas redes sociais"/>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev" title="Previous Slide">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next" title="Next Slide">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </section>
  
      <!-- Livros Disponíveis - carregando do arquivo JSON -->
      <div class="row">
        <div class="col-lg-9">
          <h2 class="mb-3 montserrat">Livros Disponíveis</h2>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // Carregar os dados do arquivo JSON
            $jsonFile = file_get_contents('data/livros.json');
            $livros = json_decode($jsonFile, true);
            
            // Filtrar os livros que não são destaque
            $livrosNormais = array_filter($livros, function($livro) {
                return !$livro['destaque'];
            });
            
            // Exibir os livros
            foreach ($livrosNormais as $livro) {
                echo '
                <div class="col">
                  <div class="card h-100">
                    <img src="' . htmlspecialchars($livro['imagem']) . '" class="card-img-top" alt="' . htmlspecialchars($livro['titulo']) . '">
                    <div class="card-body">
                      <h5 class="card-title">' . htmlspecialchars($livro['titulo']) . '</h5>
                      <p class="small">' . htmlspecialchars($livro['autor']) . '</p>
                      <p class="card-text">' . htmlspecialchars($livro['descricao']) . '</p>
                      <div class="d-flex justify-content-between align-items-center">
                      <span class="fs-5">R$ ' . number_format($livro['preco'], 2, ',', '.') . '</span>
                      <a href="livro.php?id=' . $livro['id'] . '" class="btn btn-primary">Comprar</a>
                      </div>
                    </div>
                  </div>
                </div>';
                    }
                    ?>
          </div>
        </div>
        
        <!-- Aside com livro em destaque - carregando do arquivo JSON -->
        <div class="col-lg-3">
          <aside class="mt-4 mt-lg-0">
            <h4 class="montserrat">Livro em Destaque</h4>
            <?php
            // Encontrar o livro em destaque
            $livroDestaque = null;
            foreach ($livros as $livro) {
              if ($livro['destaque']) {
                $livroDestaque = $livro;
                break;
              }
            }
            
            // Exibir o livro em destaque
            if ($livroDestaque) {
              echo '
              <img src="' . htmlspecialchars($livroDestaque['imagem']) . '" class="img-fluid mb-2" alt="' . htmlspecialchars($livroDestaque['titulo']) . '">
              <h5>' . htmlspecialchars($livroDestaque['titulo']) . '</h5>
              <p class="small">' . htmlspecialchars($livroDestaque['autor']) . '</p>
              <p class="card-text">' . htmlspecialchars($livro['descricao']) . '</p>
              <p class="fw-bold">R$ ' . number_format($livroDestaque['preco'], 2, ',', '.') . '</p>
                <a href="livro.php?id=' . $livroDestaque['id'] . '" class="btn btn-outline-primary btn-sm">Ver mais</a>';
            } else {
                echo '<p>Nenhum livro em destaque no momento.</p>';
            }
            ?>
          </aside>
        </div>
      </div>
  
    </main>
    <!-- Rodapé -->
    <footer class="bg-dark text-white mt-5 pt-4 pb-3">
      <div class="container">
        <div class="row">

          <!-- Sobre -->
          <div class="col-md-4 mb-3">
            <h5 class="special-gothic">Livraria Livro Livre</h5>
            <p class="small">
              Conectando novos autores a leitores apaixonados por literatura independente. Publique, descubra e leia com a gente.
            </p>
          </div>

          <!-- Links rápidos -->
          <div class="col-md-4 mb-3">
            <h5 class="montserrat">Links úteis</h5>
            <ul class="list-unstyled">
              <li><a href="./index.php" class="text-white text-decoration-none">Início</a></li>
              <li><a href="./publicar.php" class="text-white text-decoration-none">Publicar</a></li>
              <li><a href="./contato.php" class="text-white text-decoration-none">Contato</a></li>
            </ul>
          </div>

          <!-- Redes Sociais -->
          <div class="col-md-4 mb-3">
            <h5 class="montserrat">Siga-nos</h5>
            <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i> Facebook</a><br>
            <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i> Instagram</a><br>
            <a href="#" class="text-white me-2"><i class="fab fa-twitter-x"></i> Twitter</a>
          </div>

        </div>

        <div class="text-center mt-3 border-top pt-3 small">
          © 2025 Livraria Livro Livre. Todos os direitos reservados.
        </div>
      </div>
    </footer>
  </body>
  </html>