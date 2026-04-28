<?php
// Caminho para o arquivo JSON
$jsonPath = 'data/livros.json';

// Funções para manipular o arquivo JSON
function carregarLivros() {
    global $jsonPath;
    if (file_exists($jsonPath)) {
        $jsonData = file_get_contents($jsonPath);
        return json_decode($jsonData, true);
    }
    return [];
}

function salvarLivros($livros) {
    global $jsonPath;
    // Garante que o diretório existe
    if (!file_exists(dirname($jsonPath))) {
        mkdir(dirname($jsonPath), 0755, true);
    }
    $jsonData = json_encode($livros, JSON_PRETTY_PRINT);
    file_put_contents($jsonPath, $jsonData);
}

function proximoId($livros) {
    $maxId = 0;
    foreach ($livros as $livro) {
        if ($livro['id'] > $maxId) {
            $maxId = $livro['id'];
        }
    }
    return $maxId + 1;
}

// Inicializa variáveis
$livros = carregarLivros();
$mensagem = '';
$tipoAlerta = '';
$livroAtual = [
    'id' => '',
    'titulo' => '',
    'autor' => '',
    'descricao' => '',
    'preco' => '',
    'imagem' => '',
    'destaque' => false
];

// Processamento das ações CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Criar novo livro
    if (isset($_POST['criar'])) {
        $novoLivro = [
            'id' => proximoId($livros),
            'titulo' => htmlspecialchars(trim($_POST['titulo']), ENT_QUOTES, 'UTF-8'),
            'autor' => htmlspecialchars(trim($_POST['autor']), ENT_QUOTES, 'UTF-8'),
            'descricao' => htmlspecialchars(trim($_POST['descricao']), ENT_QUOTES, 'UTF-8'),
            'preco' => floatval($_POST['preco']),
            'imagem' => htmlspecialchars(trim($_POST['imagem']), ENT_QUOTES, 'UTF-8'),
            'destaque' => isset($_POST['destaque']) ? true : false
        ];
        
        $livros[] = $novoLivro;
        salvarLivros($livros);
        $mensagem = 'Livro adicionado com sucesso!';
        $tipoAlerta = 'success';
    } 
    // Atualizar livro
    elseif (isset($_POST['atualizar']) && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        foreach ($livros as $key => $livro) {
            if ($livro['id'] === $id) {
                $livros[$key] = [
                    'id' => $id,
                    'titulo' => htmlspecialchars(trim($_POST['titulo']), ENT_QUOTES, 'UTF-8'),
                    'autor' => htmlspecialchars(trim($_POST['autor']), ENT_QUOTES, 'UTF-8'),
                    'descricao' => htmlspecialchars(trim($_POST['descricao']), ENT_QUOTES, 'UTF-8'),
                    'preco' => floatval($_POST['preco']),
                    'imagem' => htmlspecialchars(trim($_POST['imagem']), ENT_QUOTES, 'UTF-8'),
                    'destaque' => isset($_POST['destaque']) ? true : false
                ];
                
                salvarLivros($livros);
                $mensagem = 'Livro atualizado com sucesso!';
                $tipoAlerta = 'success';
                break;
            }
        }
    }
    // Excluir livro
    elseif (isset($_POST['excluir']) && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        foreach ($livros as $key => $livro) {
            if ($livro['id'] === $id) {
                array_splice($livros, $key, 1);
                salvarLivros($livros);
                $mensagem = 'Livro excluído com sucesso!';
                $tipoAlerta = 'success';
                break;
            }
        }
    }
    
    // Recarrega os livros após modificações
    $livros = carregarLivros();
}

// Carregar livro para edição
if (isset($_GET['editar']) && !empty($_GET['editar'])) {
    $id = intval($_GET['editar']);
    foreach ($livros as $livro) {
        if ($livro['id'] === $id) {
            $livroAtual = $livro;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <!-- outras Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Marketplace de livros novos e usados." />
    <meta name="keywords" content="livros, marketplace, comprar, vender, novos, usados" />
    <meta name="author" content="Gabriel Guerra, Selma Maria, Guilherme Medeiros" />
    <meta name="robots" content="index, follow" />

    <!-- Título -->
    <title>Gerenciar Livros - Livro Livre</title>

    <!-- Favicon -->
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/v4-shims.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&amp;family=Roboto+Mono:ital,wght@0,100..700;1,100..700&amp;family=Special+Gothic+Expanded+One&amp;display=swap" rel="stylesheet" />
    <!-- Meu CSS -->
    <link rel="stylesheet" href="style.css" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-- Meu JS -->
    <script src="script.js" defer></script>
  </head>
  <body>
    <!-- Header fixo -->
    <header id="topo" class="navbar navbar-expand-lg fixed-top py-3 shadow-sm">
      <div class="container-fluid">
        <a class="navbar-brand special-gothic" href="index.php">Livraria Livro Livre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="publicar.php">Publicar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contato.php">Contato</a>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <main class="my-5 py-5 container">
      
      <h1 class="mb-4">Gerenciar Catálogo de Livros</h1>
      <?php if (!empty($mensagem)): ?>
      <div class="alert alert-<?php echo $tipoAlerta; ?> alert-dismissible fade show" role="alert">
        <?php echo $mensagem; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php endif; ?>
      
      <div class="row">
        
      <!-- Formulário para criar/editar livros -->
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5><?php echo empty($livroAtual['id']) ? 'Adicionar Novo Livro' : 'Editar Livro'; ?></h5>
            </div>
            <div class="card-body">
              <form method="post" action="publicar.php">
                <?php if (!empty($livroAtual['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $livroAtual['id']; ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                  <label for="titulo" class="form-label">Título</label>
                  <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livroAtual['titulo']); ?>" required>
                </div>
                
                <div class="mb-3">
                  <label for="autor" class="form-label">Autor</label>
                  <input type="text" class="form-control" id="autor" name="autor" value="<?php echo htmlspecialchars($livroAtual['autor']); ?>" required>
                </div>
                
                <div class="mb-3">
                  <label for="descricao" class="form-label">Descrição</label>
                  <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?php echo htmlspecialchars($livroAtual['descricao']); ?></textarea>
                </div>
                
                <div class="mb-3">
                  <label for="preco" class="form-label">Preço (R$)</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="preco" name="preco" value="<?php echo $livroAtual['preco']; ?>" required>
                </div>
                
                <div class="mb-3">
                  <label for="imagem" class="form-label">Caminho da Imagem</label>
                  <input type="text" class="form-control" id="imagem" name="imagem" value="<?php echo htmlspecialchars($livroAtual['imagem']); ?>" required>
                </div>
                
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="destaque" name="destaque" <?php echo $livroAtual['destaque'] ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="destaque">Marcar como destaque</label>
                </div>
                
                <div class="d-grid gap-2">
                  <?php if (empty($livroAtual['id'])): ?>
                  <button type="submit" name="criar" class="btn btn-primary">Adicionar Livro</button>
                  <?php else: ?>
                  <button type="submit" name="atualizar" class="btn btn-success">Salvar Alterações</button>
                  <a href="publicar.php" class="btn btn-outline-secondary">Cancelar Edição</a>
                  <?php endif; ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        
        <!-- Lista de livros cadastrados -->
        <div class="col-lg-8">
          <div class="card book-list ">
            <div class="card-header">
              <h5>Livros Cadastrados</h5>
            </div>
            <div class="card-body p-0">
              <?php if (empty($livros)): ?>
              <div class="p-4 text-center">
                <p class="mb-0">Nenhum livro cadastrado ainda.</p>
              </div>
              <?php else: ?>
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Capa</th>
                      <th>Título</th>
                      <th class="d-none d-sm-table-cell">Autor</th>
                      <th class="d-none d-sm-table-cell">Preço</th>
                      <th class="d-none d-md-table-cell">Destaque</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($livros as $livro): ?>
                    <tr class="book-item">
                      <td class="book-cover">
                        <div class="book-cover-container">
                          <img src="<?php echo htmlspecialchars($livro['imagem']); ?>" class="book-image img-fluid" alt="Capa de <?php echo htmlspecialchars($livro['titulo']); ?>">
                        </div>
                      </td>
                      <td>
                        <div class="book-title fw-bold"><?php echo htmlspecialchars($livro['titulo']); ?></div>
                        <div class="book-desc small text-muted d-none d-md-block"><?php echo substr(htmlspecialchars($livro['descricao']), 0, 60); ?>...</div>
                      </td>
                      <td class="book-author d-none d-sm-table-cell"><?php echo htmlspecialchars($livro['autor']); ?></td>
                      <td class="book-price d-none d-sm-table-cell">R$ <?php echo number_format($livro['preco'], 2, ',', '.'); ?></td>
                      <td class="d-none d-md-table-cell">
                        <?php if ($livro['destaque']): ?>
                        <span class="book-featured badge bg-warning">Destaque</span>
                        <?php else: ?>
                        <span class="badge bg-light text-dark">Não</span>
                        <?php endif; ?>
                      </td>
                      <td class="book-actions">
                        <div class="d-flex gap-1">
                          <a href="publicar.php?editar=<?php echo $livro['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="fas fa-pencil-alt">editar</i>
                          </a>
                          <form method="post" action="publicar.php" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $livro['id']; ?>">
                            <button type="submit" name="excluir" class="btn btn-sm btn-outline-danger" title="Excluir"
                                   onclick="return confirm('Tem certeza que deseja excluir o livro \'<?php echo htmlspecialchars($livro['titulo']); ?>\'?')">
                              <i class="fas fa-trash-alt">excluir</i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php endif; ?>
            </div>
          </div>
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
              <li><a href="index.php" class="text-white text-decoration-none">Início</a></li>
              <li><a href="publicar.php" class="text-white text-decoration-none">Publicar</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>