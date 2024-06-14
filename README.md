# 📝 Teste Motoca Systems - Desenvolvedor Back-End

### Arquitetura 

- PHP 8.3
- Laravel 11.9
- Postgres:15.3
- Docker

### Instalação (Com Docker)
**Passo 1: Clonar o Repositório**

```sh
git clone https://github.com/eduardohor/teste-motocaSystems-backEnd.git
```
**Passo 2: Entrar na Pasta do Projeto**

```sh
cd teste-motocaSystems-backEnd/motoca-systems
```
**Passo 3: Criar Imagens e Subir a Aplicação**

```sh
docker-compose up -d
```
**Passo 4: Configurar o Banco de Dados no pgAdmin4**

Acesse o pgAdmin4 em: http://localhost:8080

- Entre com:
   - E-mail: admin@admin.com
   - Senha: admin
     
- Adicione um novo servidor com nome de preferencia e com as seguintes conexões
   - Host: postgress
   - Porta: 5432
   - Maintenance Database: postgres
   - Username: postgres
   - Senha: password

**Passo 5: Entrar no Container da Aplicação para Instalar Dependências**
```sh
docker-compose exec app bash
```
**Passo 6: Instalar Dependências no Container**
```sh
composer install
```
Passo 7: Configurar o Arquivo .env

Duplique o arquivo .env.example e renomeie a cópia para .env:
```sh
cp .env.example .env
```
**Passo 8: Gerar Nova Chave do Laravel**
```
php artisan key:generate
```
**Passo 9: Configurar o Banco de Dados no Arquivo .env**

Edite o arquivo .env com as informações do seu banco de dados local. Exemplo de configuração:
- DB_CONNECTION=pgsql
- DB_HOST=postgress
- DB_PORT=5432
- DB_DATABASE=postgres
- DB_USERNAME=postgres
- DB_PASSWORD=password
     
**Passo 10: Executar as Migrações**
```
php artisan migrate
```
**Passo 11: Verificar se o Servidor Laravel Está Funcionando**

Acesse: http://localhost:8989

**Passo 12: Testar a API**

Você pode realizar os testes na API usando um cliente HTTP como o Postman. Endpoint basse é http://localhost:8989/api:

**Documentação da API**

A documentação completa da API pode ser encontrada no Postman. [Clique aqui para abrir em uma nova guia](https://documenter.getpostman.com/view/36316654/2sA3XQgMcr)




