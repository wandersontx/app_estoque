<?php



use App\Model\Categoria;
use App\Model\Cliente;
use App\Model\Funcionario;
use App\Model\Produto;

require './vendor/autoload.php';


if(isset($_GET['restrito']) || isset($_POST['restrito'])) {


    if(isset($_GET['logout'])) {
        setcookie("auth");
        setcookie("nome");
        header("location: index.php");
    }
     
    
    if(!isset($_COOKIE['auth']) || !$_COOKIE['auth']) { 


        $funcionario = new Funcionario;
        if(isset($_POST['matricula'])) {
            $dados = [
                'matricula' => $_POST['matricula'],
                'senha'     => $_POST['senha'],
            ];
                $auth = $funcionario->verificarAutenticacao($dados);
               if(isset($auth['nome'])) {
                setcookie("auth" , true);
                $nome = explode(" ",$auth['nome']);
                setcookie("nome" , $nome[0]);
                header("location: index.php?restrito=1");
            }
        }
    
        require 'App/Resource/Page/Restrito/loginrestrito.php';


    } else {   
        require 'App/Resource/Template/TemplateRestrito.php';    

        if(isset($_GET['rota'])) {
            $url = $_GET;
    
            switch($url['rota']) {
                case 'categoria':
                    $categoria = new Categoria;
                    if(isset($url['acao']) && $url['acao'] == 'remover') {
                        if(!$categoria->remove($url['idcategoria'])){
                            $alert = file_get_contents('App/Resource/alertwarning.inc');
                            $alert = str_replace("msg"," Não é permitido remover uma categoria que possui produtos cadastrados", $alert);
                            print $alert;
                        }
                    } elseif (isset($url['acao']) && $url['acao'] == 'salvar') {
                        $categoria->save($url['nome']);
                    }
                    require 'App/Resource/Page/Restrito/categoriapage.php';
                    break;
        
                case 'produto' :
                    $produto = new Produto;
                    if(isset($url['acao']) && $url['acao'] == 'cadastrar') {
                        require 'App/Resource/Page/Restrito/CadastroProduto.php';
                    } elseif (isset($url['acao']) && $url['acao'] == 'salvar') {
                        $dados = [
                            'idcategoria' => $url['idcategoria'],
                            'nome'        => $url['nome'],
                            'preco'       => $url['preco'],
                            'estoque'     => $url['estoque'],
                        ];
                        if(isset($url['codproduto']) && $url['codproduto'] != '')
                            $dados['codproduto'] = $url['codproduto'];
                        if($produto->salvar($dados)) {
                            $alert = file_get_contents('App/Resource/alertsuccess.inc');
                            $alert = str_replace("msg", 'Dados salvos com sucesso!',$alert);
                            print $alert;
                        }
                       
        
                    } elseif (isset($url['acao']) && $url['acao'] == 'listar') {
                        require 'App/Resource/Page/Restrito/ListaProdutos.php';       
                    } elseif (isset($url['acao']) && $url['acao'] == 'remover') {
                        if(!$produto->remover($url['codproduto'])) {
                            $alert = file_get_contents('App/Resource/alertwarning.inc');
                            $alert = str_replace("msg"," Não é permitido remover produtos que fazem parte de um pedido", $alert);
                            print $alert;   
                                           
                        }
                        require 'App/Resource/Page/Restrito/ListaProdutos.php';
                       
                    }
                    break;
                case 'funcionario':
                    $funcionario = new Funcionario;
                    if(isset($url['acao']) && $url['acao'] == 'cadastrar') {
                        require 'App/Resource/Page/Restrito/CadastroFuncionario.php';
        
                    } elseif (isset($url['acao']) && $url['acao'] == 'salvar') {
                        $dados = [
                            'nome'  => $url['nome'],
                            'senha' => md5($url['senha']),
                        ];
                        if ($url['cadastrado'] == '1') {
                            $dados['matricula'] = $url['matricula'];
                        }
                            
                        $matricula = $funcionario->salvar($dados);
                        $alert = file_get_contents('App/Resource/alertsuccess.inc');
                        if($matricula && $url['cadastrado'] != '1')                  
                            $alert = str_replace("msg","dados salvos com sucesso. Matricula gerada <strong>$matricula</strong>.", $alert);
                        else 
                            $alert = str_replace("msg","dados salvos com sucesso.", $alert);
                        print $alert;
        
                    }
                    break;
            }
        }
       
    }
    
    
} else {

    require 'App/Resource/Template/TemplateVenda.php';


    if(isset($_GET['cliente']) && $_GET['cliente'] == 'telacadastro') {
        require 'App/Resource/Page/Venda/CadastroCliente.php';
        
    }elseif(isset($_POST['cliente']) && $_POST['cliente'] == 'salvar') {
        $cliente = new Cliente;
        $dados = [
            'nome'  => $_POST['nome'],
            'email'  => $_POST['email'],
            'senha' => md5($_POST['senha']),
        ];
        $cliente->salvar($dados);
        $alert = file_get_contents('App/Resource/alertsuccess.inc');
        $alert = str_replace("msg"," Cadastro realizado com sucesso, acesse o menu e faça o login.", $alert);
        print $alert;   
      
    }elseif(isset($_GET['cliente']) && $_GET['cliente'] == 'telalogin') {
        require 'App/Resource/Page/Venda/LoginCliente.php';

      
    }elseif(isset($_POST['cliente']) && $_POST['cliente'] == 'logar') {
        $cliente = new Cliente;
        $dados = [
            'email'  => $_POST['email'],
            'senha' => md5($_POST['senha']),
        ];
        $result = $cliente->verificarAutenticacao($dados);
        if(isset($result['nome'])) {
            $nome = explode(" ",$result['nome']);
            setcookie("user_auth" , true);
            setcookie("idcliente" ,$result['idcliente']);
            setcookie("nome" , $nome[0]);
            header("location: index.php");
        }
       

    }elseif(isset($_GET['cliente']) && $_GET['cliente'] == 'logout') {
        setcookie("user_auth");
        setcookie("idcliente");
        setcookie("nome");
        header("location: index.php");
      
    }elseif(isset($_GET['cliente']) && $_GET['cliente'] == 'carrinho') {
        require 'App/Resource/Page/Venda/Carrinho.php';
        

    }elseif(isset($_GET['cliente']) && $_GET['cliente'] == 'cancelarCarrinho') {
        setcookie('carrinho');
        header("location: index.php");
    }elseif(isset($_GET['cliente']) && $_GET['cliente'] == 'fecharvenda') {
        if(isset($_COOKIE['user_auth'])) {
            require 'App/Resource/Page/Venda/FecharVenda.php';
            setcookie('carrinho');
            $alert = file_get_contents('App/Resource/alertsuccess.inc');
            $alert = str_replace("msg","Pedido realizado com sucesso.", $alert);
            print $alert;             
        } else {
            $alert = file_get_contents('App/Resource/alertwarning.inc');
            $alert = str_replace("msg","Favor realizar login antes de concluir sua compra.", $alert);
            print $alert;   
            require 'App/Resource/Page/Venda/Carrinho.php';          
        }               
    }elseif(isset($_GET['cliente']) && $_GET['cliente'] == 'meuspedidos') {
        require 'App/Resource/Page/Venda/MeusPedidos.php';          
    }else {
        require 'App/Resource/Page/Venda/ListagemProdutos.php';

    }
}


/*





 
*/



