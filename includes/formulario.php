<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabela = $_POST['tabela'];

    $query = "DESCRIBE $tabela";
    $result = $conn->query($query);

    ?>
<link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Estilo -->
    <style>
        .custom-hover:hover{
            background-color:#004AAD;
        }
        .svg:hover path{
            fill: white;
        }
        body{
            background-color: black;
        }
        form,table,label,li,a,h2,hr,h3,h1{
            color: white;
        }
        .custom-badge{
            background-color:#004AAD;
        }
        .carousel-item img {
            width: auto;
            height: 300px; /* Garante que a imagem preencha o contêiner */
            object-fit: cover; /* Faz com que a imagem preencha o contêiner, cortando-a se necessário */
            border: 2px solid #ccc; /* Adiciona uma borda fina */
            border-radius: 5px; /* Deixa os cantos levemente arredondados */
        }
        .carousel-container {
            width:auto; /* Define a largura do contêiner */
            height: 300px; /* Define a altura do contêiner para manter o tamanho consistente */
            margin: 50px auto 0; /* Margem superior ajustável e centraliza horizontalmente */
            overflow: hidden; /* Garante que nada saia da área visível do contêiner */
            position: relative; /* Permite que o contêiner se posicione corretamente no documento */
        }
        .carousel-indicators button {
            background-color: #000; /* Cor dos botões indicadores */
            border: none; /* Remove bordas dos botões */
        }
        .carousel-indicators button.active {
            background-color: #fff; /* Cor dos botões indicadores ativos */
        }
        body {
            margin: 0; /* Remove margens padrão do body */
        }
    </style>
</head>
<body>
<div class="container-block">
        <div class="row">
            <div class="col-sm-auto sticky-top d-flex flex-row flex-nowrap">
                <!--Usuário-->
                <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top col-sm-auto">
                    <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap text-center justify-content-between w-100 px-3 align-items-center custom-hover svg">
                    <a href="" class="nav-link py-3 px-2 button" title="User">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#004AAD" class="bi bi-person rounded-circle" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                              </svg>
                        </a>
                    </ul>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <!--Home-->
                    <ul class="nav nav-pills nav-flush flex-sm-column text-center justify-content-between w-100 px-3 align-items-center  custom-hover svg">
                        <li class="nav-item">
                            <a href="Moderador-Home.php" class="nav-link py-3 px-2 button" title="Home">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#004AAD" class="bi bi-house" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <!--Atualizar e Deletar Cadastros-->
                    <ul class="nav nav-pills nav-flush flex-sm-column text-center w-100 px-3 align-items-center  custom-hover svg">
                        <li class="nav-item">
                            <a href="Moderador-AtualizarEDeletarCADs.php" class="nav-link py-3 px-2 button" title="Data-UPD-DEL">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#004AAD" class="bi bi-database-gear" viewBox="0 0 16 16">
                                    <path d="M12.096 6.223A5 5 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.5 4.5 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-.813-.927Q8.378 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.6 4.6 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10q.393 0 .774-.024a4.5 4.5 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777M3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4"/>
                                    <path d="M11.886 9.46c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                  </svg>
                            </a>
                        </li>
                    </ul>
                    <!--Novos Cadastros-->
                    <ul class="nav nav-pills nav-flush flex-sm-column text-center justify-content-between w-100 px-3 align-items-center  custom-hover svg">
                        <li class="nav-item">
                            <a href="Moderador-Cadastrar.php" class="nav-link py-3 px-2 button" title="Data-ADD">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#004AAD" class="bi bi-database-add" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0"/>
                                    <path d="M12.096 6.223A5 5 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.5 4.5 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-.813-.927Q8.378 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.6 4.6 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10q.393 0 .774-.024a4.5 4.5 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777M3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4"/>
                                  </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm p-3 min-vh-100">
                <?php 
                    if ($result->num_rows > 0) {
                        echo "<h1>Cadastro na Tabela $tabela</h1>";
                        echo "<form method='POST' action='processa_cadastro.php'>";
                        echo "<input type='hidden' name='tabela' value='$tabela'>";
                        while ($row = $result->fetch_assoc()) {
                            $field = $row['Field'];
                            echo "$field: <input type='text' name='$field'><br>";
                        }
                        echo "<button type='submit'>Cadastrar</button>";
                        echo "</form>";
                    } else {
                        echo "A tabela selecionada não possui atributos.";
                    }
                } else {
                    echo "Método de requisição inválido.";
                }
                echo "<button onclick='history.back()'>Voltar</button>";
                ?>
            </div>
