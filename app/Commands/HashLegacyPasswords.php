<?php

namespace App\Commands;

use App\Models\LoginModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;

class HashLegacyPasswords extends BaseCommand
{
    protected $group       = 'Security';
    protected $name        = 'security:hash-legacy-passwords';
    protected $description = 'Converts any legacy plain-text login passwords to password_hash values.';
    protected $usage       = 'security:hash-legacy-passwords --confirm';
    protected $options     = [
        '--confirm' => 'Apply the conversion to the login table.',
    ];

    public function run(array $params)
    {
        if (!CLI::getOption('confirm')) {
            CLI::error('This command changes every legacy password in the login table.');
            CLI::write('Back up the database, then rerun with --confirm.');

            return EXIT_ERROR;
        }

        $model = new LoginModel();
        $db    = $model->db;
        $db->transBegin();
        $migrated = 0;
        $alreadyHashed = 0;
        $empty = 0;

        try {
            foreach ($model->findAll() as $user) {
                $password = (string) ($user['Senha'] ?? '');

                if ($password === '') {
                    $empty++;
                    continue;
                }

                $passwordInfo = password_get_info($password);
                if (($passwordInfo['algoName'] ?? 'unknown') !== 'unknown') {
                    $alreadyHashed++;
                    continue;
                }

                if (!$model->update($user['LoginId'], [
                    'Senha' => password_hash($password, PASSWORD_DEFAULT),
                ])) {
                    throw new RuntimeException('A atualização de uma senha falhou.');
                }
                $migrated++;
            }

            if (!$db->transStatus()) {
                throw new RuntimeException('A transação de atualização de senhas falhou.');
            }

            $db->transCommit();
        } catch (\Throwable $exception) {
            $db->transRollback();
            CLI::error('Nenhuma senha foi confirmada: ' . $exception->getMessage());

            return EXIT_ERROR;
        }

        CLI::write('Senhas convertidas para hash: ' . $migrated, 'green');
        CLI::write('Senhas já protegidas: ' . $alreadyHashed);
        CLI::write('Contas sem senha preenchida: ' . $empty, 'yellow');

        return EXIT_SUCCESS;
    }
}
