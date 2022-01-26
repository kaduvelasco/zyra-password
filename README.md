# Zyra Password

<!-- Project Shields -->
[![OpenSource](https://img.shields.io/badge/OPEN-SOURCE-green?style=for-the-badge)](https://opensource.org/)
[![GitHub license](https://img.shields.io/github/license/kaduvelasco/zyra-password?style=for-the-badge)](https://github.com/kaduvelasco/zyra-password/blob/main/LICENSE)
[![PHP7.4](https://img.shields.io/badge/PHP-7.4-blue?style=for-the-badge)](https://www.php.net/)
[![PSR-12](https://img.shields.io/badge/PSR-12-orange?style=for-the-badge)](https://www.php-fig.org/psr/psr-12/)

> Classe auxiliar para utilização de senhas com o PHP.

>- [Começando](#-começando)
>- [Pré-requisitos](#-pré-requisitos)
>- [Instalação](#-instalação)
>- [Utilização](#-utilização)
>- [Colaborando](#-colaborando)
>- [Versão](#-versão)
>- [Autores](#-autores)
>- [Licença](#-licença)

## 🚀 Começando

Esta classe possui a finalidade de auxiliar no uso de senhas com o PHP.

## 📋 Pré-requisitos

- PHP 7.4 ou superior

## 🔧 Instalação

Utilizando um arquivo `composer.json`:

```json
{
    "require": {
        "kaduvelasco/zyra-password": "^1"
    }
}
```

Depois, execute o comando de instalação.

```
$ composer install
```

OU execute o comando abaixo.

```
$ composer require kaduvelasco/zyra-password
```

## 💻 Utilização

A classe Zyra Password permite:
- Criar senhas com base nas configurações definidas.
- Verificar se uma senha atende às configurações definidas.
- Criar um Hash de uma senha informada.
- Verificar se uma senha é válida comparando-a com o hash informado.

### Utilizando a Zyra Password em seu projeto

A utilização da classe é bem simples. Veja um exemplo:

```php
declare(strict_types=1);

namespace Zyra;

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$pwd = new Password();
```

### Definindo as configurações

As configurações podem ser feitas de duas formas. A primeira é através de um array informado no momento em que a classe é instanciada. O array deve ser como o mostrado abaixo.

```php
# Atenção:
# O tipo da variável e o valor padrão que ela possui na classe estão definidos no exemplo.
# Caso você não queira mudar o valor padrão, basta não definir a chave de configuração.

$config = [
    # Define a quantidade mínima de caracteres que a senha deve ter.
    'min_length' => 7,
    
    # Define a quantidade máxima de caracteres que a senha deve ter.
    'max_length' => 15,
    
    # Define a quantidade mínima de caracteres numéricos que a senha deve possuir.
    'min_numbers' => 1,
    
    # Define a quantidade mínima de caracteres minúsculos que a senha deve ter.
    'min_lowercase' => 1,

    # Define a quantidade mínima de caracteres maiúsculos que a senha deve ter.
    'min_uppercase' => 1,

    # Define a quantidade mínima de símbolos que a senha deve ter.
    'min_symbols' => 1,
    
    # Define a quantidade máxima de símbolos que a senha deve ter.
    'max_symbols' => 3,
    
    # Define os símbolos que serão permitidos para a senha.
    'allowed_symbols' = ['#', '@', '_', '!'],
    
    # Define qual algorítmo será utilizado. É possível:
    # 0 ::: PASSWORD_DEFAULT
    # 1 ::: PASSWORD_BCRYPT
    # 2 ::: PASSWORD_ARGON2I
    # 3 ::: PASSWORD_ARGON2ID
    'algorithm' => 0,
    
    # Define o custo do algorítmo.
    # Utilizado para configurar a criptografia utilizando o algoritmo DEFAULT e BCRYPT
    'pass_cost' => 10,
    
    # Máximo de memória (em bytes) que pode ser utilizado para computar o hash Argon2
    # Utilizado quando o algorítmo ARGON2 é selecionado.
    'argon2_memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
    
    # Quantidade máxima de tempo que pode levar para computar o hash Argon2
    # Utilizado quando o algorítmo ARGON2 é selecionado.
    'argon2_time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
    
    
    # Número de threads para computar o hash Argon2
    # Utilizado quando o algorítmo ARGON2 é selecionado.
    'argon2_threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
    
    # As mensagens de erro são mostradas, por padrão em inglês.
    # Você pode alterá-las para outro idioma aqui.
    'error_messages' => [
        'min_length' => 'The password must be at least %s characters long.',
        'max_length' => 'The password must have a maximum of $s characters.',
        'min_numbers' => 'The password must contain at least %s numbers.',
        'min_lowercase' => 'The password must contain at least %s lowercase characters.',
        'min_uppercase' => 'The password must contain at least %s uppercase characters.',
        'not_symbols' => 'Symbols are not allowed in the password.',
        'min_symbols' => 'The password must contain at least %s symbols.',
        'max_symbols' => 'Password must contain at most %s symbols.',
        'allowed_symbols' => 'The %s symbol is not allowed in the password.'
    ]
];

$pwd = new \Zyra\Password($config);
```

Outra forma é utilizando os métodos específicos de configuração:

```php
$pwd->setMinLength(int $min_length);
$pwd->setMaxLength(int $max_length);
$pwd->setMinNumbers(int $min_numbers);
$pwd->setMinLowercase(int $min_lowercase);
$pwd->setMinUppercase(int $min_uppercase);
$pwd->setMinSymbols(int $min_symbols);
$pwd->setMaxSymbols(int $max_symbols);
$pwd->setAllowedSymbols(array $allowed_symbols);
$pwd->setAlgorithm(int $algorithm);
$pwd->setPassCost(int $pass_cost);
$pwd->setArgon2MemoryCost(int $memory_cost);
$pwd->setArgon2TimeCost(int $time_cost);
$pwd->setArgon2Threads(int $threads);
$pwd->setErrorMessages(array $messages);
```

### Criando uma senha

Para criar uma senha, o método `generatePassword()` deve ser usado.

Este método utiliza as configurações definidas para gerar uma senha aleatória que passe na validação. Para isso, utiliza certas práticas, como não utilizar a letra 'o' ou o número '0'

O tamanho da senha será:
- Por padrão definido de forma randomica entre o mínimo e o máximo de caracteres configurados.
- Definido como o máximo de caracteres caso o parâmetro `use_max` do método for definido como `true`.
- Definido como o mínimo de caracteres caso o parâmetro `use_max` do método for definido como `false`.

```php
$pwd->generatePassword();
# Será criada uma senha entre 7 e 15 caracteres seguindo as configurações da classe

$pwd->generatePassword(true);
# Será criada uma senha com 15 caracteres seguindo as configurações da classe

$pwd->generatePassword(false);
# Será criada uma senha com 7 caracteres seguindo as configurações da classe
```

### Verificando uma senha 

Para verificar se uma senha contempla todas as configurações definidas, o método `validatePassword()` deve ser usado.

```php
$pwd->validatePassword('Adnj1dsd');
# Irá retornar false, pois não contempla todas as configurações da classe.

$pwd->validatePassword('Adnj1@dsd');
# Irá retornar true, pois contempla todas as configurações da classe.
```

### Criando um hash

Para gerar o hash de uma senha informada, o método `makeHash()` deve ser utilizado.

A classe irá utilizar as configurações definidas para gerar o resultado.

```php
$pwd->makeHash();
```

### Verificando se uma senha é válida

Para validar uma senha (verificar se a senha corresponde a um hash), o método `verifyHash()` deve ser utilizado.

```php
$pwd->verifyHash('senha', 'hash_armazenado');
# Retorna true ou false, dependendo do resultado.
```

### Informações sobre uma hash

Para saber as informações sobre uma hash utilize o método `hashInfo()`, ele retorna um array como o abaixo:

```php
array(3) {
  ["algo"]     => string(2) "2y"
  ["algoName"] => string(6) "bcrypt"
  ["options"]  => array(1) {
      ["cost"] => int(10)
  }
}
```

## 🤝 Colaborando

Por favor, leia o arquivo [CONDUCT.md][link-conduct] para obter detalhes sobre o nosso código de conduta e o arquivo [CONTRIBUTING.md][link-contributing] para detalhes sobre o processo para nos enviar pedidos de solicitação.

## 📌 Versão

Nós usamos [SemVer][link-semver] para controle de versão.

Para as versões disponíveis, observe as [tags neste repositório][link-tags].

O arquivo [VERSIONS.md][link-versions] possui o histórico de alterações realizadas no projeto.

## ✒ Autores
- **Kadu Velasco** / Desenvolvedor
  - [Perfil][link-profile]
  - [Email][link-email]

## 📄 Licença 

Esse projeto está sob licença MIT. Veja o arquivo [LICENSE][link-license] para mais detalhes ou acesse [mit-license.org](https://mit-license.org/).

[⬆ Voltar ao topo](#zyra-password)

<!-- links -->
[link-conduct]:https://github.com/kaduvelasco/zyra-password/blob/main/CONDUCT.md
[link-contributing]:https://github.com/kaduvelasco/zyra-password/blob/main/CONTRIBUTING.md
[link-license]:https://github.com/kaduvelasco/zyra-password/blob/main/LICENSE
[link-versions]:https://github.com/kaduvelasco/zyra-password/blob/main/VERSIONS.md
[link-tags]:https://github.com/kaduvelasco/zara-phptools/tags
[link-semver]:http://semver.org/
[link-profile]:https://github.com/kaduvelasco
[link-email]:mailto:kadu.velasco@gmail.com
