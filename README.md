# 🛒 Sistema de Gestão de Produtos (Laravel 10)

Sistema web para gerenciamento de produtos, categorias e marcas com controle de acesso baseado em permissões de usuário.

---

## ⚙️ Requisitos do Sistema

### Backend
- PHP 8.1 ou superior
- Composer 2.5+
- MySQL 8.0+ (ou outro banco compatível)
- Extensões PHP obrigatórias:
  - `mbstring`
  - `openssl`
  - `pdo_mysql`
  - `tokenizer`
  - `xml`
  - `ctype`
  - `json`

### Frontend
- HTML, CSS e JavaScript 
- Bootstrap
- Font Awesome 6.5.0 (via CDN)
- jQuery 3.7.1 (via CDN)

---

## 🚀 Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/BrunojeanDev/gestao-produtos.git
cd gestao-produtos
cp .env.example .env
```

### 2. Configurar variáveis de ambiente

Edite o arquivo `.env` com suas credenciais do banco de dados:

```
DB_DATABASE=gestaoProdutos
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 3. Instalar as dependências do backend

```bash
composer install
```

### 4. Gerar a chave da aplicação e rodar as migrações com seed

```
⚠️ Atenção: Antes de continuar, verifique se o usuário do banco de dados configurado no .env possui permissões adequadas para:

Criar banco de dados e tabelas

Inserir, atualizar e excluir dados
```

```bash
php artisan key:generate
php artisan migrate --seed
```

### 5. Iniciar o servidor de desenvolvimento

```bash
php artisan serve
```

Acesse a aplicação em: [http://localhost:8000](http://localhost:8000)

---

## 👥 Usuários Pré-Cadastrados

| Email            | Senha    | Tipo          | Permissões         |
|------------------|----------|---------------|---------------------|
| adm@gmail.com    | 12345@   | Administrador | Todas               |
| common@gmail.com | 123456   | Usuário comum | Nenhuma (atribuível via admin) |

---

## 🔐 Fluxo de Autenticação

- Acesso inicial redireciona para a tela de login (`/login`).
- Após autenticação:
  - **Administradores** são direcionados ao painel completo.
  - **Usuários comuns** acessam um dashboard básico (com restrições conforme permissões atribuídas).
