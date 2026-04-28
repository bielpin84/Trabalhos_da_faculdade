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
    <script src="script.js" defer></script>
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
                    <li class="nav-item"><a class="nav-link" href="./index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="./publicar.php">Publicar</a></li>
                    <li class="nav-item"><a class="nav-link active" href="./contato.php">Contato</a></li>
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
      
      <!-- Formulário -->
      <h2 class="mb-4 montserrat text-center">Fale com a gente</h2>
      <?php
      $mensagemEnviada = false;
      $erros = [];
      
      // Verificar se o formulário foi enviado
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Validar nome
          if (empty($_POST["nome"])) {
              $erros["nome"] = "Por favor, preencha seu nome.";
          } else {
              $nome = htmlspecialchars(trim($_POST["nome"]), ENT_QUOTES, 'UTF-8');
          }
          
          // Validar email
          if (empty($_POST["email"])) {
              $erros["email"] = "Informe um e-mail válido.";
          } else {
              $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $erros["email"] = "Formato de e-mail inválido.";
              }
          }
          
          // Validar telefone
          if (empty($_POST["telefone"])) {
              $erros["telefone"] = "Informe um telefone válido.";
          } else {
              $telefone = htmlspecialchars(trim($_POST["telefone"]), ENT_QUOTES, 'UTF-8');
          }
          
          // Validar mensagem
          if (empty($_POST["mensagem"])) {
              $erros["mensagem"] = "Por favor, escreva sua mensagem.";
          } else {
              $mensagem = htmlspecialchars(trim($_POST["mensagem"]), ENT_QUOTES, 'UTF-8');
          }
          
          // Se não houver erros, processar o formulário
          if (empty($erros)) {
              // Aqui você pode enviar email, salvar no banco de dados, etc.
              $mensagemEnviada = true;
          }
      }
      ?>

        <?php if ($mensagemEnviada): ?>
          <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.
          </div>
        <?php else: ?>
          <form id="contatoForm" class="mx-auto" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control <?php echo isset($erros['nome']) ? 'is-invalid' : ''; ?>" 
                    id="nome" name="nome" 
                    value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>" required>
              <div class="invalid-feedback"><?php echo isset($erros['nome']) ? $erros['nome'] : 'Por favor, preencha seu nome.'; ?></div>
            </div>
        
            <div class="mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input type="email" class="form-control <?php echo isset($erros['email']) ? 'is-invalid' : ''; ?>" 
                    id="email" name="email" 
                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
              <div class="invalid-feedback"><?php echo isset($erros['email']) ? $erros['email'] : 'Informe um e-mail válido.'; ?></div>
            </div>
        
            <div class="mb-3">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="tel" class="form-control <?php echo isset($erros['telefone']) ? 'is-invalid' : ''; ?>" 
                    id="telefone" name="telefone" 
                    value="<?php echo isset($telefone) ? htmlspecialchars($telefone) : ''; ?>"
                    pattern="\(\d{2}\)\s?\d{4,5}-\d{4}" placeholder="(11) 91234-5678" required>
              <div class="invalid-feedback"><?php echo isset($erros['telefone']) ? $erros['telefone'] : 'Informe um telefone válido no formato (99) 99999-9999.'; ?></div>
            </div>
        
            <div class="mb-3">
              <label for="mensagem" class="form-label">Mensagem</label>
              <textarea class="form-control <?php echo isset($erros['mensagem']) ? 'is-invalid' : ''; ?>" 
                      id="mensagem" name="mensagem" rows="5" required><?php echo isset($mensagem) ? htmlspecialchars($mensagem) : ''; ?></textarea>
              <div class="invalid-feedback"><?php echo isset($erros['mensagem']) ? $erros['mensagem'] : 'Por favor, escreva sua mensagem.'; ?></div>
            </div>
        
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Enviar</button>
              <button type="reset" class="btn btn-secondary">Limpar</button>
            </div>
          </form>
        <?php endif; ?>
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
            <li><a href="contato.php" class="text-white text-decoration-none">Contato</a></li>
          </ul>
        </div>

        <!-- Redes Sociais -->
        <div class="col-md-4 mb-3">
          <h5 class="montserrat">Siga-nos</h5>
            <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i> Facebook</a><br>
            <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i> Instagram</a><br>
            <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i> Twitter</a>
          </div>

      </div>

      <div class="text-center mt-3 border-top pt-3 small">
        © 2025 Livraria Livro Livre. Todos os direitos reservados.
      </div>
    </div>
  </footer>
</body>
</html>