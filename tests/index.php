<?php

require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

echo '<h1>Zyra Password</h1>';

$pwd = new \Zyra\Password();


// Gera uma senha.
$pass = $pwd->generatePassword();
echo '<p>Password gerado: ' . $pass . '</p>';

// Gera um hash. Nos exemplos abaixo utilizamos todos os algorítmos possíveis.
$pwd->setAlgorithm(0);
$hash1 = $pwd->makeHash($pass);
echo '<p>Hash default: ' . $hash1 . '</p>';

$pwd->setAlgorithm(1);
$hash2 = $pwd->makeHash($pass);
echo '<p>Hash bcrypt: ' . $hash2 . '</p>';

$pwd->setAlgorithm(2);
$hash3 = $pwd->makeHash($pass);
echo '<p>Hash Argon2i: ' . $hash3 . '</p>';

$pwd->setAlgorithm(3);
$hash4 = $pwd->makeHash($pass);
echo '<p>Hash Argon2id: ' . $hash4 . '</p>';

echo '<p>-------------------------------------------</p>';

// Verificando se uma senha á válida. Para o exemplo, vamos criar a senha e o hash novamente.
$pass = $pwd->generatePassword();
echo '<p>Password gerado: ' . $pass . '</p>';

$pwd->setAlgorithm(0);
$hash1 = $pwd->makeHash($pass);
echo '<p>Hash default: ' . $hash1 . '</p>';

// Para verificar se a senha é válida, devemos passar a senha informada pelo usuário e o hash armazenado:
echo ($pwd->verifyHash($pass, $hash1)) ? '<p>Senha válida</p>' : '<p>Senha inválida</p>';
echo ($pwd->verifyHash($pass . '1', $hash1)) ? '<p>Senha válida</p>' : '<p>Senha inválida</p>';

// Informações da Hash
echo '<pre>';
var_dump($pwd->hashInfo($hash1));
echo '</pre>';

echo '<p>-------------------------------------------</p>';

$pwd->validatePassword('abcd');

echo '<pre>';
var_dump($pwd->getErrors());
echo '</pre>';

echo '<p>-------------------------------------------</p>';
$pwd->idealCost();

echo '<p>Tudo certo até aqui</p>';
