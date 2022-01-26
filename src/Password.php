<?php

/**
 * Zyra Password
 *
 * @package  Password
 * @author   Kadu Velasco (@kaduvelasco) <kadu.velasco@gmail.com>
 * @url      <https://github.com/kaduvelasco/zyra-password>
 * @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
 */

declare(strict_types=1);

namespace Zyra;

class Password
{
    /**
     * @var bool
     */
    protected bool $has_error = false;

    /**
     * @var array<mixed>
     */
    protected array $error_list = [];

    /**
     * @var array<mixed>
     */
    protected array $error_messages = [
        'min_length' => 'The password must be at least %s characters long.',
        'max_length' => 'The password must have a maximum of $s characters.',
        'min_numbers' => 'The password must contain at least %s numbers.',
        'min_lowercase' => 'The password must contain at least %s lowercase characters.',
        'min_uppercase' => 'The password must contain at least %s uppercase characters.',
        'not_symbols' => 'Symbols are not allowed in the password.',
        'min_symbols' => 'The password must contain at least %s symbols.',
        'max_symbols' => 'Password must contain at most %s symbols.',
        'allowed_symbols' => 'The %s symbol is not allowed in the password.'
    ];

    /**
     * @var int
     */
    protected int $min_length = 7;

    /**
     * @var int
     */
    protected int $max_length = 15;

    /**
     * @var int
     */
    protected int $min_numbers = 1;

    /**
     * @var int
     */
    protected int $min_lowercase = 1;

    /**
     * @var int
     */
    protected int $min_uppercase = 1;

    /**
     * @var int
     */
    protected int $min_symbols = 1;

    /**
     * @var int
     */
    protected int $max_symbols = 3;

    /**
     * @var array<string>
     */
    protected array $allowed_symbols = ['#', '@', '_', '!'];

    /**
     * @var int
     */
    protected int $algorithm = 0;

    /**
     * @var int
     */
    protected int $pass_cost = 10;

    /**
     * @var int
     */
    protected int $argon2_memory_cost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST;

    /**
     * @var int
     */
    protected int $argon2_time_cost = PASSWORD_ARGON2_DEFAULT_TIME_COST;

    /**
     * @var int
     */
    protected int $argon2_threads = PASSWORD_ARGON2_DEFAULT_THREADS;

    /**
     * @var array<mixed>
     */
    protected array $algorithms = [
        0 => 'PASSWORD_DEFAULT',
        1 => 'PASSWORD_BCRYPT',
        2 => 'PASSWORD_ARGON2I',
        3 => 'PASSWORD_ARGON2ID'
    ];

    /**
     * @var string
     */
    protected string $lower_letters = 'aeiubdghjmnpqrstvxyz';

    /**
     * @var string
     */
    protected string $upper_letters = 'AEUBDGHJLMNPQRSTVWXYZ';

    /**
     * @var string
     */
    protected string $numbers = '23456789';

    /**
     * @param array<mixed>|null $config
     */
    public function __construct(?array $config = null)
    {
        if (!is_null($config)) {
            $this->setConfig($config);
        }
    }

    /**
     * Evita que a classe seja clonada.
     *
     * @return void
     */
    private function __clone()
    {
        die('This class cannot be cloned.');
    }

    /**
     * Define a quantidade mínima de caracteres que a senha deve possuir.
     *
     * @param int $min_length
     *
     * @return void
     */
    public function setMinLength(int $min_length): void
    {
        $this->min_length = $min_length;
    }

    /**
     * Define a quantidade máxima de caracteres que a senha deve possuir.
     *
     * @param int $max_length
     *
     * @return void
     */
    public function setMaxLength(int $max_length): void
    {
        $this->max_length = $max_length;
    }

    /**
     * Define a quantidade mínima de números que a senha deve possuir.
     *
     * @param int $min_numbers
     *
     * @return void
     */
    public function setMinNumbers(int $min_numbers): void
    {
        $this->min_numbers = $min_numbers;
    }

    /**
     * Define a quantidade mínima de caracteres em minúsculo que a senha deve possuir.
     *
     * @param int $min_lowercase
     *
     * @return void
     */
    public function setMinLowercase(int $min_lowercase): void
    {
        $this->min_lowercase = $min_lowercase;
    }

    /**
     * Define a quantidade mínima de caracteres em maiúsculo que a senha deve possuir.
     *
     * @param int $min_uppercase
     *
     * @return void
     */
    public function setMinUppercase(int $min_uppercase): void
    {
        $this->min_uppercase = $min_uppercase;
    }

    /**
     * Define a quantidade mínima de símbolos que a senha deve possuir.
     *
     * @param int $min_symbols
     *
     * @return void
     */
    public function setMinSymbols(int $min_symbols): void
    {
        $this->min_symbols = $min_symbols;
    }

    /**
     * Define a quantidade máxima de símbolos que a senha deve possuir.
     *
     * @param int $max_symbols
     *
     * @return void
     */
    public function setMaxSymbols(int $max_symbols): void
    {
        $this->max_symbols = $max_symbols;
    }

    /**
     * Define os símbolos permitidos para utilização na senha.
     *
     * @param array<mixed> $allowed_symbols
     *
     * @return void
     */
    public function setAllowedSymbols(array $allowed_symbols): void
    {
        $this->allowed_symbols = $allowed_symbols;
    }

    /**
     * Define o custo de algoritmo que deve ser usado.
     * Utilizado quando os algorítmos DEFAULT e BCRYPT são utilizados.
     *
     * @param int $pass_cost
     *
     * @return void
     */
    public function setPassCost(int $pass_cost): void
    {
        $this->pass_cost = $pass_cost;
    }

    /**
     * Define o máximo de memória (em bytes) que pode ser utilizado para computar o hash Argon2.
     *
     * @param int $memory_cost
     *
     * @return void
     */
    public function setArgon2MemoryCost(int $memory_cost): void
    {
        $this->argon2_memory_cost = $memory_cost;
    }

    /**
     * Quantidade máxima de tempo que pode levar para computar o hash Argon2.
     *
     * @param int $time_cost
     *
     * @return void
     */
    public function setArgon2TimeCost(int $time_cost): void
    {
        $this->argon2_time_cost = $time_cost;
    }

    /**
     * Número de threads para computar o hash Argon2.
     *
     * @param int $threads
     *
     * @return void
     */
    public function setArgon2Threads(int $threads): void
    {
        $this->argon2_threads = $threads;
    }

    /**
     * Define o algorítmo que será utilizado.
     *
     * @param int $algorithm
     *
     * @return void
     */
    public function setAlgorithm(int $algorithm): void
    {
        if (!in_array($algorithm, $this->algorithms)) {
            die('The given algorithm is not supported');
        }

        $this->algorithm = $algorithm;
    }

    /**
     * Define as mensagens de erro.
     *
     * @param array<mixed> $messages
     *
     * @return void
     */
    public function setErrorMessages(array $messages): void
    {
        $this->error_messages = $messages;
    }

    /**
     * Define todas as configurações.
     *
     * @param array<mixed> $config
     *
     * @return void
     */
    private function setConfig(array $config): void
    {
        foreach ($config as $k => $v) {
            switch ($k) {
                case 'min_length':
                    $this->setMinLength($v);
                    break;
                case 'max_length':
                    $this->setMaxLength($v);
                    break;
                case 'min_numbers':
                    $this->setMinNumbers($v);
                    break;
                case 'min_lowercase':
                    $this->setMinLowercase($v);
                    break;
                case 'min_uppercase':
                    $this->setMinUppercase($v);
                    break;
                case 'min_symbols':
                    $this->setMinSymbols($v);
                    break;
                case 'max_symbols':
                    $this->setMaxSymbols($v);
                    break;
                case 'allowed_symbols':
                    $this->setAllowedSymbols($v);
                    break;
                case 'pass_cost':
                    $this->setPassCost($v);
                    break;
                case 'argon2_memory_cost':
                    $this->setArgon2MemoryCost($v);
                    break;
                case 'argon2_time_cost':
                    $this->setArgon2TimeCost($v);
                    break;
                case 'argon2_threads':
                    $this->setArgon2Threads($v);
                    break;
                case 'algorithm':
                    $this->setAlgorithm($v);
                    break;
                case 'error_messages':
                    $this->setErrorMessages($v);
                    break;
            }
        }
    }

    /**
     * Utiliza as configurações definidas na classe para gerar uma senha aleatória que passe na validação.
     * Para isso, utiliza certas práticas, como não utilizar a letra 'o' ou o número '0'
     *
     * @param bool|null $use_max
     *
     * @return string
     */
    public function generatePassword(?bool $use_max = null): string
    {
        $password = '';

        // Adiciona a quantidade definida de caracteres minúsculos.
        for ($i = 0; $i < $this->min_lowercase; $i++) {
            $password .= $this->lower_letters[(rand() % strlen($this->lower_letters))];
        }

        // Adiciona a quantidade definida de caracteres maiúsculos.
        for ($i = 0; $i < $this->min_uppercase; ++$i) {
            $password .= $this->upper_letters[(rand() % strlen($this->upper_letters))];
        }

        // Adiciona a quantidade definida de números.
        for ($i = 0; $i < $this->min_numbers; ++$i) {
            $password .= $this->numbers[(rand() % strlen($this->numbers))];
        }

        // Adiciona a quantidade definida de símbolos.
        // É definido gerando um número aleatório entre o mínimo e o máximo definido.
        $total = mt_rand($this->min_symbols, $this->max_symbols);
        $symbols = implode('', $this->allowed_symbols);
        for ($i = 0; $i < $total; ++$i) {
            $password .= $symbols[(rand() % strlen($symbols))];
        }

        // Ajusta o tamanho da senha.
        // Utiliza o parâmetro $use_max para definir o tamanho da senha
        $total = ((is_null($use_max))
            ? mt_rand($this->min_length, $this->max_length)
            : ($use_max)) ? $this->max_length : $this->min_length;

        $characters = $this->lower_letters . $this->upper_letters . $this->numbers;

        while (strlen($password) < $total) {
            $password .= $characters[(rand() % strlen($characters))];
        }

        // Misture os caracteres da senha.
        return str_shuffle($password);
    }

    /**
     * Verifica se a senha informada contempla todas as definições da classe.
     *
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        $return = true;

        // Verifica se a senha é menor do que a quantidade máxima de caracteres permitidos.
        if (strlen($password) < $this->min_length) {
            $this->has_error = true;
            $this->error_list[] = sprintf($this->error_messages['min_length'], $this->min_length);
            $return = false;
        }

        // Verifica se a senha é maior do que a quantidade máxima de caracteres permitidos.
        if (strlen($password) > $this->max_length) {
            $this->has_error = true;
            $this->error_list[] = sprintf($this->error_messages['max_length'], $this->min_length);
            $return = false;
        }

        // Verifica se a senha possui a quantidade mínima de números definidos.
        $numbers = preg_replace('/([^0-9]*)/', '', $password);
        if (is_null($numbers) || (strlen($numbers) < $this->min_numbers)) {
            $this->has_error = true;
            $this->error_list[] = sprintf($this->error_messages['min_numbers'], $this->min_length);
            $return = false;
        }

        // Verifica se a senha possui a quantidade mínima de caracteres minúsculos.
        $lowercase = preg_replace('/([^a-z]*)/', '', $password);
        if ((is_null($lowercase) || strlen($lowercase) < $this->min_lowercase)) {
            $this->has_error = true;
            $this->error_list[] = sprintf($this->error_messages['min_lowercase'], $this->min_length);
            $return = false;
        }

        // Verifica se a senha possui a quantidade mínima de caracteres maiúsculos.
        $uppercase = preg_replace('/([^A-Z]*)/', '', $password);
        if ((is_null($uppercase)) || (strlen($uppercase) < $this->min_uppercase)) {
            $this->has_error = true;
            $this->error_list[] = sprintf($this->error_messages['min_uppercase'], $this->min_length);
            $return = false;
        }

        // Símbolos
        $symbols = preg_replace('/([a-zA-Z0-9]*)/', '', $password);
        if ((0 === $this->min_symbols) || (0 === $this->max_symbols)) {
            if ((is_null($symbols)) || (strlen($symbols) > 0)) {
                $this->has_error = true;
                $this->error_list[] = sprintf($this->error_messages['not_symbols'], $this->min_length);
                $return = false;
            }
        } else {
            // Verifica se a senha possui a quantidade mínima de símbolos definidos.
            if ((is_null($symbols)) || (strlen($symbols) < $this->min_symbols)) {
                $this->has_error = true;
                $this->error_list[] = sprintf($this->error_messages['min_symbols'], $this->min_length);
                $return = false;
            }

            // Verifica se a senha possuir mais símbolos do que o permitido.
            if ((is_null($symbols)) || (strlen($symbols) > $this->max_symbols)) {
                $this->has_error = true;
                $this->error_list[] = sprintf($this->error_messages['max_symbols'], $this->min_length);
                $return = false;
            }

            // Verifica se os símbolos presentes na senha são permitidos.
            $count = (is_null($symbols)) ? 0 : strlen($symbols);

            $arr_symbols = str_split($symbols); /** @phpstan-ignore-line */

            for ($i = 0; $i < $count; $i++) {
                if (!in_array($arr_symbols[$i], $this->allowed_symbols)) {
                    $this->has_error = true;
                    $this->error_list[] = sprintf($this->error_messages['max_symbols'], $this->min_length);
                    $return = false;
                }
            }
        }

        return $return;
    }

    /**
     * Retorna os erros armazenados.
     *
     * @return array<mixed>
     */
    public function getErrors(): array
    {
        return $this->error_list;
    }


    /**
     * Gera um hash para a senha informada.
     *
     * @param string $password
     *
     * @return bool|string
     */
    public function makeHash(string $password)
    {
        switch ($this->algorithm) {
            case 0:
                $options = ['cost' => $this->pass_cost];
                return password_hash($password, PASSWORD_DEFAULT, $options);
            case 1:
                $options = ['cost' => $this->pass_cost];
                return password_hash($password, PASSWORD_BCRYPT, $options);
            case 2:
                $options = [
                    'memory_cost' => $this->argon2_memory_cost,
                    'time_cost' => $this->argon2_time_cost,
                    'threads' => $this->argon2_threads
                ];
                return password_hash($password, PASSWORD_ARGON2I, $options);
            case 3:
                $options = [
                    'memory_cost' => $this->argon2_memory_cost,
                    'time_cost' => $this->argon2_time_cost,
                    'threads' => $this->argon2_threads
                ];
                return password_hash($password, PASSWORD_ARGON2ID, $options);
        }
        return false;
    }

    /**
     * Verifica se uma senha á válida.
     *
     * @param string $password
     * @param string $hash
     *
     * @return bool
     */
    public function verifyHash(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Retorna as informações da hash informada.
     *
     * @param string $hash
     *
     * @return array<mixed>
     */
    public function hashInfo(string $hash): array
    {
        return password_get_info($hash);
    }

    /**
     * Realiza o benchmark do servidor para determinar o custo ideal para o algoritmo.
     *
     * @param int $time_target
     * @param int $initial_cost
     *
     * @return int
     */
    public function idealCost(int $time_target = 50, int $initial_cost = 8): int
    {
        $time = $time_target / 1000;
        $cost = $initial_cost;

        do {
            $cost++;
            $start = microtime(true);
            password_hash('test', PASSWORD_DEFAULT, ['cost' => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $time);

        return $cost;
    }
}
