# Sistema de Gerenciamento PetShop AUmigos

Este projeto foi desenvolvido para organizar o fluxo de atendimento da **PetShop AUmigos**, permitindo o controle completo dos clientes e seus respectivos pets. 

O sistema resolve o problema de registros desorganizados ao centralizar todas as informações em um banco de dados relacional (MySQL), garantindo que nenhum pet fique sem um responsável vinculado.

---

## Funcionalidades Principais

  **Gestão de Clientes:** Cadastro, edição, exclusão e listagem de responsáveis.
  **Gestão de Animais:** Cadastro, edição, exclusão e listagem de pets com indicação clara de quem é o seu dono.
  **Vínculo Obrigatório:** Impossibilidade de cadastrar um animal sem associá-lo a um cliente existente.
  **Visão Detalhada (Desafio):** Tela exclusiva do cliente que exibe seus dados de contato e a lista completa de todos os seus animais cadastrados de forma organizada (ex: *Thor — Cachorro — Labrador — 5 anos*).

---

## Tecnologias Utilizadas

* **PHP 8** (com extensão PDO para conexão segura)
* **MySQL** (com suporte a chaves estrangeiras e integridade referencial)
* **HTML5**

---

## Estrutura do Projeto

```text
PETSHOP/
├── database/
│   └── database.sql          # Script de criação das tabelas e relacionamentos
├── infra/
│   └── conexao.php           # Configuração da conexão via PDO
├── public/
│   ├── animais/              # Telas do CRUD de animais
│   ├── clientes/             # Telas do CRUD de clientes + Detalhes
│   └── index.php             # Página inicial do sistema
└── README.md