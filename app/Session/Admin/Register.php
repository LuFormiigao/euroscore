<?php

namespace App\Session\Admin;

class Register {

    /**
     * Método responsável por iniciar a sessão
     */
    private static function init() {
        // Verifica se a sessão não está ativa
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Método responsável por criar a sessão de registro
     * @param User $user
     */
    public static function register($user) {
        // Inicia a sessão
        self::init();

        // Define a sessão do usuário
        $_SESSION['admin']['register'] = [
            'id_usuario' => $user->id_usuario,
            'nome' => $user->nome,
            'email' => $user->email
        ];
    }

    /**
     * Método responsável por verificar se o usuário está registrado
     * @return boolean
     */
    public static function isRegistered() {
        // Inicia a sessão
        self::init();

        // Retorna a verificação
        return isset($_SESSION['admin']['register']);
    }

    /**
     * Método responsável por encerrar a sessão de registro
     */
    public static function logout() {
        // Inicia a sessão
        self::init();

        // Remove a sessão do usuário
        unset($_SESSION['admin']['register']);
    }

    /**
     * Método responsável por retornar os dados do usuário registrado
     * @return array
     */
    public static function getRegisterUser() {
        // Inicia a sessão
        self::init();

        // Retorna os dados do usuário
        return $_SESSION['admin']['register'] ?? null;
    }
}
