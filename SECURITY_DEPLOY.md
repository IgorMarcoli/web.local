# Checklist de segurança para deploy

## Ações obrigatórias antes de publicar

1. Faça backup do banco e execute a conversão de senhas legadas, a partir do diretório do projeto:

       php spark security:hash-legacy-passwords --confirm

   O comando converte valores ainda armazenados em texto puro para password_hash numa transação. Confira o resumo e investigue contas sem senha. O login não aceita mais senha em texto puro.

2. Configure o ambiente de produção em um arquivo .env fora do diretório público ou em variáveis seguras do servidor:

       CI_ENVIRONMENT = production
       app.baseURL = 'https://SEU_DOMINIO/'
       database.default.sslmode = require
       supabase.url = 'https://SEU_PROJETO.supabase.co'
       supabase.serviceKey = 'CHAVE_PRIVILEGIADA'
       painel.token = 'SEGREDO_ALEATORIO_COM_PELO_MENOS_32_CARACTERES'

   Não publique nem envie .env ao Git. A chave Supabase privilegiada deve ficar somente no servidor; se já foi exposta em algum lugar, revogue-a e gere outra.

3. Configure Apache/Nginx com public/ como raiz do site. Não use a raiz do repositório como document root. Garanta que writable/ não possa ser servido pela web e que writable/cache, writable/logs, writable/session e writable/uploads sejam graváveis apenas pela conta do PHP. No Nginx, aplique também as negações para demos e arquivos de desenvolvimento descritas em public/.htaccess.

4. Use PHP 8.2 ou superior, compatível com o CodeIgniter atualizado. No servidor PHP, configure display_errors=Off, display_startup_errors=Off e log_errors=On; deixe max_execution_time limitado e zend.assertions=-1 em produção. Instale as extensões intl, mbstring, pgsql, curl e fileinfo, aplique atualizações do PHP/servidor e force HTTPS também no proxy ou balanceador. Se houver proxy reverso, configure somente os IPs confiáveis em Config\App::$proxyIPs.

5. Revise no Supabase as políticas RLS e de Storage, permissões dos papéis, backups e acesso à rede. A chave serviceKey contorna RLS; o código a usa somente no servidor para enviar fotos. Confirme que o bucket perfil deve ser público antes de manter URLs públicas para as fotos.

6. Gere painel.token com pelo menos 32 caracteres aleatórios. Abra o painel de TV com o segredo no fragmento da URL (`/painel#t=...`); o painel envia o token no cabeçalho Authorization. Não use query string para esse segredo.
7. Migre fotos antigas de writable/uploads/perfil para o Storage do Supabase antes de criar um checkout limpo e atualize os registros correspondentes. Invalide as sessões ativas no deploy. Arquivos de sessão, debug toolbar e fotos que já tenham sido enviados ao remoto permanecem acessíveis no histórico Git; purge esse histórico antes de compartilhar/publicar o repositório.
8. Confirme que a tabela contatos existe no Supabase com os campos usados pelo módulo. Depois de instalar as dependências de produção com composer install --no-dev --classmap-authoritative, rode composer audit --no-dev e valide login, logout, troca de senha, upload de foto, CSRF, permissões por setor e fluxos CRUD no ambiente de homologação HTTPS.
9. Mantenha bibliotecas JavaScript de terceiros atualizadas e com versões fixas; prefira arquivos locais ou SRI nos recursos CDN. Confirme que cada origem externa usada pela intranet é necessária.

## Proteções incorporadas nesta revisão

- As duas telas de login compartilham limitação de tentativas por usuário e endereço IP; credenciais inválidas têm a mesma resposta.
- Senhas são aceitas somente quando verificadas com password_verify; a troca exige a senha atual, confirmação e ao menos 12 caracteres.
- A sessão antiga é removida ao regenerar o identificador, os tokens CSRF são randomizados e cookies de sessão ficam Secure no ambiente production.
- A leitura de fotos legadas valida o nome, o caminho real e o tipo MIME. O upload ao Supabase exige HTTPS, valida certificado e não segue redirecionamentos.
- As rotas continuam explícitas, o auto roteamento permanece desligado, CSRF é global e os cabeçalhos de segurança do CodeIgniter permanecem ativos.
- Documentação, demos, sourcemaps e arquivos de desenvolvimento da cópia do AdminLTE não são servidos pelo Apache.
- O painel de TV não envia mais o segredo em query string; o endpoint de dados exige um token longo no cabeçalho e respostas não são armazenadas em cache.
- O bootstrap de produção desativa a exibição de erros e mantém o registro em log, mesmo que o php.ini do servidor esteja permissivo.

## Limites desta verificação

O projeto não contém as configurações da conta Supabase, do proxy nem do servidor de produção. RLS, segredo ativo, política de Storage, diretório público, TLS, permissões de arquivos, backup e logs precisam ser confirmados no ambiente de deploy. Esta revisão não é um pentest externo.
