<?php
include("verifica_sessao.php");

// Recupera as variáveis de sessão
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
$senha = isset($_SESSION['senha']) ? $_SESSION['senha'] : '';
$carg = isset($_SESSION['cargo']) ? $_SESSION['cargo'] : '';

// Verifica se o usuário e a senha estão definidos
if (empty($usuario) || empty($senha)) {
    header("Location: error_page.php");
    exit;
}

// Determina o cargo baseado no valor da variável $carg
if (empty($carg)) {
    $cargo = "ERRO";
} else if ($carg == 1) {
    $cargo = "Funcionário";
} else if ($carg == 2) {
    $cargo = "Financeiro";
} else if ($carg == 3) {
    $cargo = "Supervisor";
} else {
    $cargo = "ERRO NO VALOR";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Lateral</title>
    <link rel="stylesheet" href="css/Menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar left-sidebar">
        <div class="logo"><img src="Icon/Logo_SSS.png"></div>
        <div class="menu-item info-item" onclick="changeTopButtons('menu')">Menus</div>
        <div class="menu-item" onclick="changeTopButtons('vendas')">
            <i class="fas fa-dollar-sign menu-icon"></i> Vendas
        </div>
        <div class="menu-item" onclick="changeTopButtons('relatorio')">
            <i class="fas fa-chart-line menu-icon"></i> Relatório
        </div>
        <div class="menu-item" onclick="changeTopButtons('clientes')">
            <i class="fas fa-user-friends menu-icon" ></i> Clientes
        </div>
        <div class="menu-item" id="linkConsultaProduto" onclick="changeTopButtons('produtos')">
            <i class="fas fa-box menu-icon"></i> Produtos
        </div>
        <!-- Add more menu items here -->
    </div>      
    <div class="content">
        <div class="top-buttons" id="top-buttons">
            <!-- Default top buttons -->
            <div class="button-item">Menu Principal</div>
            <div class="button-item">Sobre</div>
            <div class="button-item">Serviços</div>
            <div class="button-item">Contato</div>
            <div class="profile-section">
                 <img src="picture/user.png" alt="Profile Image" class="profile-img">
                <div class="profile-info">
                    <div class="user_nome">Usuario: <?php echo htmlspecialchars($usuario); ?></div>
                    <div class="user_cargo">Cargo: <?php echo htmlspecialchars($cargo); ?></div>
                </div>
                <?php
                // Verifica se há uma sessão de usuário definida
                if (isset($_SESSION['usuario'])) {
                echo '<form action="logout.php" method="POST">
                     <button type="submit" class="logout-btn">Logout
                         <i class="bx bx-log-out bx-lg"></i>
                    </button>
                </form>';
                }
                ?>
            </div>
        </div>
        <div class="exibi">
            <div class="iframe-wrapper">
                <iframe id="iframeExibicao" src="about:blank" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    
    <script>
function changeTopButtons(menu) {
    console.log(`Menu selecionado: ${menu}`);
    const topButtons = document.getElementById('top-buttons');
    topButtons.innerHTML = '';

    if (menu === 'vendas') {
        topButtons.innerHTML = `
            <div class="button-item" id="linkVenda">Vendas</div>
            <div class="button-item">Produto</div>
            <div class="button-item">Consulta vendas</div>
            <div class="profile-section">
                <img src="picture/user.png" alt="Profile Image" class="profile-img">
                <div class="profile-info">
                    <div class="user_nome">Usuario: <?php echo htmlspecialchars($usuario); ?></div>
                    <div class="user_cargo">Cargo: <?php echo htmlspecialchars($cargo); ?></div>
                </div>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Logout
                            <i class="bx bx-log-out bx-lg"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        `;
    } else if (menu === 'relatorio') {
        topButtons.innerHTML = `
            <div class="button-item" id="linkOverview">Overview</div>
            <div class="button-item" id="linkDashBoard">DashBoard</div>
            <div class="button-item" id="linkAnnual">Annual</div>
            <div class="button-item" id="linkCustom">Custom</div>
            <div class="profile-section">
                <img src="picture/user.png" alt="Profile Image" class="profile-img">
                <div class="profile-info">
                    <div class="user_nome">Usuario: <?php echo htmlspecialchars($usuario); ?></div>
                    <div class="user_cargo">Cargo: <?php echo htmlspecialchars($cargo); ?></div>
                </div>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Logout
                            <i class="bx bx-log-out bx-lg"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        `;
    } else if (menu === 'clientes') {
        topButtons.innerHTML = `
            <div class="button-item" id="linkAdicionar">Adicionar</div>
            <div class="button-item" id="linkAlterar">Alterar</div>
            <div class="button-item" id="linkConsulta">Consultar</div>
            <div class="profile-section">
                <img src="picture/user.png" alt="Profile Image" class="profile-img">
                <div class="profile-info">
                    <div class="user_nome">Usuario: <?php echo htmlspecialchars($usuario); ?></div>
                    <div class="user_cargo">Cargo: <?php echo htmlspecialchars($cargo); ?></div>
                </div>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Logout
                            <i class="bx bx-log-out bx-lg"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        `;
    } else if (menu === 'produtos') {
        topButtons.innerHTML = `
            <!-- <div class="button-item" id="linkConsultaProduto">Consulta</div> -->
            <div class="button-item" id="linkAdicionarProduto">Adicionar</div>
            <!--<div class="button-item" id="linkEditar">Editar</div>-->
            <div class="profile-section">
                <img src="picture/user.png" alt="Profile Image" class="profile-img">
                <div class="profile-info">
                    <div class="user_nome">Usuario: <?php echo htmlspecialchars($usuario); ?></div>
                    <div class="user_cargo">Cargo: <?php echo htmlspecialchars($cargo); ?></div>
                </div>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Logout
                            <i class="bx bx-log-out bx-lg"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        `;
    } else if (menu === 'menu') {
        topButtons.innerHTML = `
            <div class="button-item" id="linkMenuPrincipal">Menu Principal</div>
            <div class="button-item" id="linkSobre">Sobre</div>
            <div class="button-item" id="linkServicos">Serviços</div>
            <div class="button-item" id="linkContato">Contato</div>
            <div class="profile-section">
                <img src="picture/user.png" alt="Profile Image" class="profile-img">
                <div class="profile-info">
                    <div class="user_nome">Usuario: <?php echo htmlspecialchars($usuario); ?></div>
                    <div class="user_cargo">Cargo: <?php echo htmlspecialchars($cargo); ?></div>
                </div>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Logout
                            <i class="bx bx-log-out bx-lg"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        `;
    }

    setupEventListeners(); // Adicione isso aqui para configurar todos os listeners após atualizar o HTML
}

function setupEventListeners() {
    const iframeExibicao = document.getElementById("iframeExibicao");

    const linkConsulta = document.getElementById("linkConsulta");
    if (linkConsulta) {
        linkConsulta.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../System/Clientes/Consulta.php";
        });
    }

    const linkVenda = document.getElementById("linkVenda");
    if (linkVenda) {
        linkVenda.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../Vendas/pgvenda.php";
        });
    }

    const linkAdicionar = document.getElementById("linkAdicionar");
    if (linkAdicionar) {
        linkAdicionar.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../System/Clientes/AdicionaCliente.php";
        });
    }

    const linkAlterar = document.getElementById("linkAlterar");
    if (linkAlterar) {
        linkAlterar.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../System/Clientes/AlteraRegistro.php";
        });
    }

    const linkConsultaProduto = document.getElementById("linkConsultaProduto");
    if (linkConsultaProduto) {
        linkConsultaProduto.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../System/Produtos/ConsultaProduto.php";
        });
    }

    const linkAdicionarProduto = document.getElementById("linkAdicionarProduto");
    if (linkAdicionarProduto) {
        linkAdicionarProduto.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../System/Produtos/AdicionarProduto.php";
        });
    }

    const linkEditar = document.getElementById("linkEditar");
    if (linkEditar) {
        linkEditar.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "../System/Produtos/EditarProduto.php";
        });
    }

    const linkMenuPrincipal = document.getElementById("linkMenuPrincipal");
    if (linkMenuPrincipal) {
        linkMenuPrincipal.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "MenuPrincipal.php";
        });
    }

    const linkSobre = document.getElementById("linkSobre");
    if (linkSobre) {
        linkSobre.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "Sobre.php";
        });
    }

    const linkServicos = document.getElementById("linkServicos");
    if (linkServicos) {
        linkServicos.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "Servicos.php";
        });
    }

    const linkContato = document.getElementById("linkContato");
    if (linkContato) {
        linkContato.addEventListener("click", function(event) {
            event.preventDefault();
            iframeExibicao.src = "Contato.php";
        });
    }
}

document.addEventListener("DOMContentLoaded", function() {
    setupEventListeners(); // Configura os listeners quando o DOM estiver pronto
});

    </script>
</body>
</html>
