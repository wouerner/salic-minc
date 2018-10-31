# Documentação Avaliação de Resultados

## Como acessar o Laudo Final no perfil Coordenador Geral

* Primeiro passo precisa esta logado como Coordenador Geral de Prestação de Contas. 
* Segundo passo vá em avaliação de resultados->Analisar laudo final.

### Avaliação de Resultados: Laudo Final 
* Na página do Laudo Final tem um Painel com as abas 'Em Analise', 'Assinar', 'Em Assinatura' e 'Finalizados'.  
* Cada aba vai ter uma tabela com a listagem dos projetos de acordo com o estado atual.
* Conforme o estado, a ação no projeto muda.
 <!-- ![Painel do Laudo] -->
### Tabela dos projetos
* A tabela é montada com os itens 'PRONAC', 'Nome do projeto', 'Manifestação', 'Devolver' e 'Ação'.
* Nos itens 'PRONAC' e 'Manifestação', são executadas ações comum a todas as abas do painel.

### Consultar Dados do Projeto
* Ao clicar no número do Pronac o usuário é redirecionado para o módulo de Projetos: dados do projeto.
 <!-- ![Clique item pronac] -->

### Visulizar o Parecer técnico
* Clique na manifestação do projeto para visualizar o parecer emitido pelo técnico.

 ![Clique item manifestação](https://raw.githubusercontent.com/culturagovbr/salic-minc/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/comprovar_item.png)
 ![Tela Visualizar Parecer](https://raw.githubusercontent.com/culturagovbr/salic-minc/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/comprovar_item.png)

#### Em Análise 
* Na primeira aba do painel, Em Análise, são listados os projetos que ainda não possui um documento de laudo final gerado.
* No item devolver da tabela é feita a devolução do parecer técnico.
* Na ação é possível emitir o laudo final.

##### Devolver Parecer Técnico
* Na aba Em análise, clique no botão devolver.
![Clique item devolver parecer](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela1.png?raw=true)
* Vai abrir uma modal para que o usuário confirme a devolução.
![modal confirmar devolver](https://raw.githubusercontent.com/culturagovbr/salic-minc/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela_situacao.png)
* Se confirmada a devolução, o parecer do técnico é invalidado o e projeto volta pra Avaliação de Resultados: Analisar Parecer, finalizando o fluxo do projeto no laudo final.

##### Emitir Laudo Final
* Clique na ação da aba Em Análise.
![Clique ação emitir laudo](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela_indentificacao.png?raw=true)
* Uma modal vai abrir para que o usuário crie o laudo final.
![tela form laudo final](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela_cadastro1.png?raw=true)
* É necessário o preenchimento de todos os campos para que o laudo seja gerado.
* O usuário tem duas opções no canto superior direito: salvar, criando assim apenas um rascunho do laudo e finalizar, que estaria salvando, gerando o documento do laudo final e mudando o estado do projeto para iniciar o fluxo de assinaturas.
![finalizar laudo final](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela_cadastro1.png?raw=true)


#### Assinar
* Segunda aba do painel, são listados os projetos que já possuem um laudo final gerado porém não teve nenhuma assinatura ainda, o primeiro a assinar é o próprio coordenador geral, criador do documento.
* No item devolver da tabela, o usuário vai poder devolver o laudo final. 
* A ação disponível nessa aba é para o Coordenador Geral assinar o documento.

##### Devolver Laudo Final
* Segue o mesmo fluxo do devolver<!--ref: Devolver Parecer Técnico--> da aba Em Analise porém o documento devolvido é o Laudo Final.
* Confirmada a devolução, o Laudo Final é invalidado, o estado do projeto muda e ele volta para a aba Em Análise para ser criado um novo laudo, reiniciando o fluxo do projeto no laudo final.

##### Assinar Laudo
* Ao clicar na ação da aba Assinar o sistema redireciona para o módulo de assinatura onde será assinado o documento do laudo final.
![Clique ação assinar](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela1.png?raw=true)

#### Em Assinatura
* Terceira aba do painel, a listagem apresenta os projetos que já possuem um laudo final emitido e este já foi assinado pelo menos pelo Coordenador Geral, mas ainda não tem todas as assinaturas.
* O item Devolver tem a mesma intenção do devolver da aba Assinar.
* A ação é para visualizar o laudo final.

##### Visualizar Laudo
* Clique na ação da aba Em Assinatura.
![Clique ação visualizar laudo](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela1.png?raw=true)
* Uma modal vai abrir apresentado um visualização do laudo final emitido.
![Tela visualizar laudo](https://github.com/culturagovbr/salic-minc/blob/f/prestacao-contas/dev-marcos/application/modules/prestacao-contas/docs/imagens/tela1.png?raw=true)

#### Finalizados
* Ultima aba do painel com a listagem dos projetos finalizados, ou seja, projetos que já possuem um laudo final emitido e este foi assinado por todos os responsáveis.
* O item Devolver e a ação nessa aba são as mesmas da aba Em assinatura.