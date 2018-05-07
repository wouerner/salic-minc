# Salic API

## Passos iniciais

```
    composer update --ignore-platform-reqs
```

## Autenticação

Utilizamos o componente [jwt-auth](https://github.com/tymondesigns/jwt-auth) JSON Web Token (JWT) específico para Laravel e Lumen, para fornecer nosso método de autenticação.

### @todo
- Adicionar o comando ```composer update --ignore-platform-reqs``` no entry-point da imagem do php-fpm
- Adicionar Midware para JWT
- Criar estrutura básica para adicionar módulo inicial de "Autenticação"
- Atualizar documentação básica para utilização da API GraphQL

### @done
- Configurar Banco de dados
- Instalar o lumen