# Intranet SEDUC — Dashboard e Agenda

Sistema web interno para acompanhar o atendimento de TI nas escolas: visão geral em dashboard, agenda de visitas e cadastro dos profissionais responsáveis por cada unidade.

> ⚠️ Projeto em desenvolvimento. Itens marcados com `[AJUSTAR]` devem ser revisados pela equipe antes de publicar.

---

## 📌 Sumário

- [Sobre o projeto](#-sobre-o-projeto)
- [Funcionalidades](#-funcionalidades)
- [Tecnologias](#-tecnologias)
- [Requisitos](#-requisitos)
- [Instalação](#-instalação)
- [Configuração](#-configuração)
- [Estrutura de pastas](#-estrutura-de-pastas)
- [Banco de dados](#-banco-de-dados)
- [Roadmap](#-roadmap)
- [Como contribuir](#-como-contribuir)
- [Segurança](#-segurança)
- [Autores](#-autores)

---

## 📖 Sobre o projeto

A intranet centraliza, em um só lugar, informações sobre as escolas atendidas pela equipe de tecnologia: quantas visitas foram feitas, o que está agendado, quem é o PROATI de cada escola e, futuramente, a situação da rede de cada unidade.

O objetivo é reduzir planilhas soltas e dar à equipe uma visão rápida do que está acontecendo no campo.

---

## ✨ Funcionalidades

**Já implementado**

- **Dashboard** com filtro por **mês/ano** e por **status** (botões de filtro).
- **Agenda** de visitas com os mesmos filtros de mês/ano e status.
- **Página de PROATIs**: lista os usuários da tabela `login` com perfil `PROATI`, exibindo o nome da escola vinculada.

**Planejado**

- Página individual por escola.
- Status em tempo real de conectividade dos Access Points e da internet de cada escola.

`[AJUSTAR]` Inclua aqui outras telas/módulos que já existam (login, perfis de acesso, relatórios etc.).

---

## 🛠 Tecnologias

| Camada | Tecnologia |
|---|---|
| Linguagem | PHP |
| Framework | CodeIgniter 4 |
| Banco de dados | `[AJUSTAR]` MySQL / MariaDB |
| Front-end | `[AJUSTAR]` HTML, CSS, JavaScript (Bootstrap?) |
| Gerenciador de dependências | Composer |

---

## ✅ Requisitos

- PHP 8.1 ou superior (com as extensões `intl`, `mbstring`, `json`, `mysqlnd` e `curl`)
- Composer
- MySQL ou MariaDB
- Git
- Servidor web (Apache/Nginx) **ou** o servidor embutido do CodeIgniter para desenvolvimento

---

## 🚀 Instalação

```bash
# 1. Clonar o repositório
git clone https://github.com/[AJUSTAR-usuario]/[AJUSTAR-repositorio].git
cd [AJUSTAR-repositorio]

# 2. Instalar as dependências
composer install

# 3. Criar o arquivo de ambiente
cp env .env

# 4. Ajustar o .env (veja a seção Configuração)

# 5. Criar as tabelas
php spark migrate        # [AJUSTAR] se o projeto usar migrations
# ou importe o arquivo .sql do diretório /database

# 6. Subir o servidor de desenvolvimento
php spark serve
```

Depois acesse: <http://localhost:8080>

---

## ⚙️ Configuração

Edite o arquivo `.env` na raiz do projeto:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://web.local'

database.default.hostname = nome do supabase
database.default.database = nome_do_banco
database.default.username = usuario do supavase
database.default.password = senha do supabase
database.default.DBDriver = MySQLi
```

> **Nunca** faça commit do arquivo `.env`. Ele já deve estar listado no `.gitignore`.

---

## 📁 Estrutura de pastas

```
app/
├── Controllers/   # Lógica das páginas (Dashboard, Agenda, PROATIs...)
├── Models/        # Acesso ao banco de dados
├── Views/         # Telas (HTML/PHP)
├── Config/        # Rotas e configurações
└── Database/      # Migrations e seeds
public/            # Arquivos públicos (CSS, JS, imagens)
writable/          # Logs, cache e sessões (não versionar)
```

`[AJUSTAR]` Atualize conforme a estrutura real do projeto.

---

## 🗄 Banco de dados

Tabelas principais conhecidas até o momento:

| Tabela | Função |
|---|---|
| `login` | Usuários do sistema. O campo `perfil` define o tipo de acesso (ex.: `PROATI`). |
| `escolas` | Cadastro das escolas. |

**Relacionamento importante:** cada usuário PROATI possui o campo `EscolaId` (UUID), que é chave estrangeira para `escolas`. É assim que a página de PROATIs mostra o nome da escola.

`[AJUSTAR]` Adicione as tabelas de agenda/visitas e um diagrama ER, se houver.

---

## 🗺 Roadmap

- [x] Dashboard com filtros de mês/ano e status
- [x] Agenda com filtros de mês/ano e status
- [x] Página de PROATIs
- [ ] Página por escola
- [ ] Monitoramento de conectividade (APs e internet) em tempo real
- [ ] `[AJUSTAR]` Outras ideias da equipe

---

## 🤝 Como contribuir

1. Faça um *fork* do repositório (ou crie uma branch, se tiver acesso).
2. Crie uma branch para a sua alteração:
   ```bash
   git checkout -b feature/nome-da-funcionalidade
   ```
3. Faça commits pequenos e com mensagens claras:
   ```bash
   git commit -m "feat: adiciona filtro por escola na agenda"
   ```
4. Envie a branch e abra um **Pull Request** descrevendo o que mudou e como testar.

**Convenções**

- Siga o padrão de código do CodeIgniter 4 (PSR-12).
- Não suba senhas, tokens ou dados reais de escolas/usuários.
- Teste suas alterações localmente antes de abrir o PR.

---

## 🔒 Segurança

Este sistema lida com dados de uso interno. Por isso:

- Não publique o `.env`, dumps do banco ou listas reais de usuários.
- Use dados fictícios em prints, exemplos e testes.
- Encontrou uma falha? Avise a equipe diretamente, sem abrir uma *issue* pública com detalhes da vulnerabilidade.

---

## 👥 Autores

- **Igor** — desenvolvimento e infraestrutura
- `[AJUSTAR]` Demais colaboradores

---
