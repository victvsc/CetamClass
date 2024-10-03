<?php
session_start();
include('../../../includes/db.php');

if (isset($_SESSION['user_id'])) {
  // Verifica se o id_usuario é igual a 3 (moderador)
  if ($_SESSION['user_id'] != 1) {
      // Se não for, redireciona para a página de login
      header("Location: ../../geral-pages/html/Login.php");
      exit();
  }
} else {
  // Se não estiver logado, redireciona para a página de login
  header("Location: ../../geral-pages/html/Login.php");
  exit();
}
function exibirNomeUsuario() {
  return isset($_SESSION['nome']) ? $_SESSION['nome'] : "Usuário não logado";
}
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
  <meta charset="UTF-8">
  <title>CetamClass - Aluno</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
</head>
<style>
  .custom-badge{
            background-color:#0052c5;
        }

  .custom-btn {
    border-radius: 0.375rem;
    border: 2px solid #1e90ff;
    background-color: #1e90ff;
    color: white;
    transition: background-color 0.3s, color 0.3s;
  }

  .custom-btn:hover {
    background-color: #1c86ee;
    border-color: #1c86ee;
    color: white;
  }

  body {
    background-color: #f8f9fa;
  }

  /* Estilizando o cabeçalho da tabela */
  th {
    background-color: #007bff;
    color: white;
  }

  /* Estilizando os cabeçalhos dos módulos */
  .module-header {
    background-color: #e9ecef;
    font-weight: bold;
  }

  /* Estilizando a linha de total de carga horária */
  .total-load {
    background-color: #d1e7dd;
    font-weight: bold;
  }

  /* Estilizando as bordas das células da tabela */
  table.table-bordered td, table.table-bordered th {
    border: 1px solid #007bff;
  }

  /* Cor de fundo para as linhas alternadas da tabela */
  tbody tr:nth-child(odd) {
    background-color: #f0f8ff;
  }

  tbody tr:nth-child(even) {
    background-color: #ffffff;
  }
  </style>
<body>
<!-- partial:index.partial.html -->
<div id="nav-bar">
  <input id="nav-toggle" type="checkbox"/>
  <div id="nav-header"><a id="nav-title" href="https://codepen.io" target="_blank">Cetam<i></i>Class</a>
    <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
    <hr/>
  </div>
  <div id="nav-content">
    <div class="nav-button"><i class="fas fa-home"></i><span><a href="./index.php">Home</a></span></div>
    <div class="nav-button"><i class="fas fa-book"></i><span><a href="./informacoesacad.php">Informações Acadêmicas</a></span></div>
    <hr/>
    <div class="nav-button"><i class="fas fa-folder"></i><span><a href="./turvirt.php">Turma Virtual</a></span></div>
    <div class="nav-button"><i class="fas fa-table"></i><span><a href="./matrizcur.php">Matriz Curricular</a></span></div>
    <div class="nav-button"><i class="fas fa-book-open"></i><span><a href="./biblioteca.php">Biblioteca</a></span></div>
    <div class="nav-button"><i class="fas fa-exclamation-circle"></i><span><a href="./avisos.php">Avisos</a></span></div>
    <hr/>
    <div id="nav-content-highlight"></div>
  </div>
  <input id="nav-footer-toggle" type="checkbox"/>
  <div id="nav-footer">
    <div id="nav-footer-heading">
      <div id="nav-footer-titlebox"><a id="nav-footer-title" href="https://codepen.io/uahnbu/pens/public" target="_blank"><?php echo exibirNomeUsuario($conn); ?></a><span id="nav-footer-subtitle">Aluno</span></div>
      <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
    </div>
    <div id="nav-footer-content">
                <button class="custom-btn" onclick="window.location.href='../../../includes/logout.php'">Sair</button>
            </div>
    <div id="nav-footer-content">
    </div>
  </div>
</div>
<!-- partial -->
<title>Tabela Curricular</title>
<div class="container mt-5">
    <h1 class="text-center mb-4">Módulos e Componentes Curriculares</h1>
    <div class="table-responsive w-75 ms-auto">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>COMPONENTE CURRICULAR</th>
                    <th>Carga Horária</th>
                </tr>
            </thead>
            <tbody>
                <tr class="module-header">
                    <td>Básico I</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Português Instrumental</td>
                    <td>60h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Informática, Sociedade e Meio Ambiente</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Legislação e Ética Profissional</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Inglês Aplicado à Informática</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Matemática Instrumental</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Fundamentos da Informática</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Lógica de Programação e Algoritmos</td>
                    <td>80h</td>
                </tr>
                <tr class="total-load">
                    <td>Carga Horária Módulo I:</td>
                    <td colspan="2">320h</td>
                </tr>
                <tr class="module-header">
                    <td>Específico I</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Linguagem de Programação I</td>
                    <td>80h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Banco de Dados I</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Fundamentos de Arquitetura de Computadores</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Fundamentos de Sistemas Operacionais</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Manutenção de Computadores</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Redes de Computadores</td>
                    <td>60h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Gestão de Help-Desk e Service-Desk</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Prática Profissional Supervisonada I – Manutenção de Computadores</td>
                    <td>60h</td>
                </tr>
                <tr class="total-load">
                    <td>Carga Horária Módulo II:</td>
                    <td colspan="2">370h</td>
                </tr>
                <tr class="module-header">
                    <td>Específico II</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Certificado de Operador e Monitorador de Computadores</td>
                    <td>690h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Segurança da Informação</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Linguagem de Programação II</td>
                    <td>80h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Banco de Dados II</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Sistemas Embarcados</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Prática Profissional Supervisonada II – Banco de Dados</td>
                    <td>80h</td>
                </tr>
                <tr class="total-load">
                    <td>Carga Horária Módulo III:</td>
                    <td colspan="2">270h</td>
                </tr>
                <tr class="module-header">
                    <td>Específico III</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Certificação de Programador de Sistemas da Informação</td>
                    <td>960h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Gestão Empreendedora e Novas Tecnologias</td>
                    <td>30h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Qualidade e Teste de Software</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Programação Front-End</td>
                    <td>40h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Linguagem de Programação III</td>
                    <td>110h</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Prática Profissional Supervisonada III – Projetos de Sistemas Computacionais Web</td>
                    <td>60h</td>
                </tr>
                <tr class="total-load">
                    <td>Carga Horária Módulo IV:</td>
                    <td colspan="2">270h</td>
                </tr>
                <tr class="total-load">
                    <td>Carga Horária Total do Curso:</td>
                    <td colspan="2">1230h</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../moderador-pages/js/codigos.js"></script>

</body>
</html>