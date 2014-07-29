Estudo-Model-AR
===============

Estudo de Model usando Activive Record em PHP puro com PDO, o objetivo aqui é para estudos, da pra por em produção porém não me reponsabilizo por uso errado e inseguro do script, ele facilita a vida, mas é preciso tomar os cuidados com sanetização e SQL injection, use por sua conta e risco.

>Versão: Alpha 0.1.0

#####Como usar:

**Primeiro no arquivo bootstrap.php alterar a configuração do banco de dados**
```php
Banco::dInjector(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'dbname'    => 'seubanco',
    'user'      => 'root',
    'pass'      => 'sua senha'
));
```

**Criar no diretório model um arquivo com sua classe extendendo Model**
**Atenção o nome do arquivo *PRECISA* ter o mesmo nome da Classe!**
```php
<?php
class Usuario extends Model {
	protected static $tabela = 'tb_usuarios'; // nome da sua tabela que será mapeada nessa classe
  //protected static $id_column = 'cod_cli'; <- mudar caso a primary key ter um nome diferente de id
}
```

**Modo de uso no seu arquivo: *index.php* por exemplo**
```php
<?php
require 'bootstrap.php';

// Criar um novo registro
$usuario = new Usuario();

// Adicionando os valores do novo usuario
// nome da propriedade = 'nome coluna do banco'

// obs: devemos incluir todos os campos not null

$usuario->nome  = 'Foo';
$usuario->email = 'Bar';
$usuario->tel   = '5555-6666';
$usuario->end   = 'Rua farolhinha, 555 ap. 4';

// Gravando usuario no banco
if ($usuario->save()) {
  echo 'usuario gravado com sucesso';
}
```
**Recuperando dados:**
```php
<?php
require 'bootstrap.php';

// Retorna um objeto Usuario com os valores dos campos nas propriedades
$user = Usuario::getById(2);

// Para acessa-las basta chamar a propriedade
echo $user->nome;
```
**Recuperando mais de um usuário:**
```php
<?php
require 'bootstrap.php';

// Retorna um array de objetos com todos os registros da tabela 
// sendo a chave do array o #id do objeto
$users = Usuario::getAll();

var_dump($users);
```

**Para excluir um usuário:**
```php
<?php
require 'bootstrap.php';

// Retorna objeto Usuario com dados do registro id 5
// do banco de dados
$user = Usuario::getById(5);

// Deleta este usuario da tabela banco
$user->delete();
```
