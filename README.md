Sistema de Gerenciamento de Empréstimos de Patrimônios

Aplicação web desenvolvida em Laravel para controle de empréstimos de patrimônios entre estabelecimentos conveniados.

O projeto foi desenvolvido como parte de uma avaliação técnica, utilizando PostgreSQL 14 e seguindo a arquitetura MVC do Laravel com uma camada de serviços para centralizar as regras de negócio.

 Objetivo

O sistema tem como objetivo substituir o controle manual feito em papel por uma aplicação web capaz de registrar estabelecimentos, patrimônios e empréstimos.

A aplicação valida regras importantes do processo, como impedir empréstimos entre estabelecimentos de tipos diferentes, bloquear patrimônios baixados e respeitar o prazo máximo de empréstimo definido para o estabelecimento.

## Tecnologias

PHP 8  
Laravel 12  
PostgreSQL 14  
Docker  
Docker Compose  
Blade  
HTML  
CSS  

## Arquitetura

O projeto utiliza o padrão MVC do Laravel com Service Layer.

A divisão principal da aplicação é:

```txt
app
  Http
    Controllers
    Requests
  Models
  Services

database
  migrations

resources
  views

routes
  web.php
