# Documentação Avaliação de Resultados - Laudo Final

## Como acessar o Laudo Final no perfil Coordenador Geral

* Primeiro passo precisa esta logado como Coordenador Geral de Prestação de Contas. 
* Segundo passo vá em avaliação de resultados->Analisar laudo final.

### Avaliação de Resultados: Laudo Final 
* Na página do Laudo Final tem um Painel com as abas 'Em Analise', 'Assinar', 'Em Assinatura' e 'Finalizados'.  
* Cada aba vai ter uma tabela com a listagem dos projetos de acordo com o estado atual.

 ![Painel do Laudo](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/painel_laudo.png)
### Tabela dos projetos
* A tabela é montada com os itens 'PRONAC', 'Nome do projeto', 'Manifestação', 'Devolver' e 'Ação'.
* Nos itens 'PRONAC' e 'Manifestação', são executadas ações comum a todas as abas do painel.
* No item 'Devolver', a funcionalidade se difere apenas na primeira aba.
* Conforme o estado, a 'Ação' no projeto muda.

#### Consultar Dados do Projeto
* Ao clicar no número do Pronac o usuário é redirecionado para o módulo de Projetos: dados do projeto.
 ![Clique item pronac](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/dados_projeto.png)

#### Visulizar o Parecer técnico
* Clique na manifestação do projeto.
 ![Clique item manifestação](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/manifestacao.png)
* Ao clicar vai abrir uma modal para visualizar o parecer emitido pelo técnico

 ![Tela Visualizar Parecer](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/visualizar_parecer.png)


#### Devolver 
* Clique no botão devolver.
![Clique item devolver parecer](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/acao_devolver.png)
* Vai abrir uma modal para que o usuário confirme a devolução com o Pronac e o nome do projeto selecionado.
![modal confirmar devolver](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/modal_devolver.png)
##### Parecer Técnico
* Estará sendo feita a devolução do parecer tecnico quando clicado no botão Devolver da aba Em Análise.
* Se confirmada a devolução, o parecer do técnico é invalidado o e projeto volta pra Avaliação de Resultados: Analisar Parecer, finalizando o fluxo do projeto no laudo final.
##### Laudo final
* Estará sendo feita a devolução do laudo final quando clicado no botão Devolver das demais abas.
* Confirmada a devolução, o Laudo Final é invalidado, o estado do projeto muda e ele volta para a aba Em Análise para ser criado um novo laudo, reiniciando o fluxo do projeto no laudo final.

### Em Análise 
* Na primeira aba do painel, Em Análise, são listados os projetos que ainda não possui um documento de laudo final gerado.
 ![Aba em análise](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/aba_em_analise.png)
* Na ação é possível emitir o laudo final.

#### Emitir Laudo Final
* Clique na ação da aba Em Análise.

![Clique ação emitir laudo](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/acao_em_analise.png)

* Uma modal vai abrir para que o usuário crie o laudo final.
![tela form laudo final](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/tela_emitir_laudo.png)
* É necessário o preenchimento de todos os campos para que o laudo seja gerado.
* O usuário tem duas opções no canto superior direito: 1) Salvar, criando assim apenas um rascunho do laudo; 2) Finalizar, que estará salvando, gerando o documento do laudo final e mudando o estado do projeto para iniciar o fluxo de assinaturas.

![finalizar laudo final](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/opcoes_laudo.png)


### Assinar
* Segunda aba do painel onde são listados os projetos que já possuem um laudo final gerado porém não teve nenhuma assinatura ainda.
 ![Aba assinar](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/aba_assinar.png)
* A ação disponível nessa aba é para assinar o documento.

#### Assinar Laudo
* Ao clicar na ação da aba Assinar o sistema redireciona para o módulo de assinatura onde será assinado o documento do laudo final.
* Quem deve assinar é o próprio coordenador geral, criador do documento.

![Clique ação assinar](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/acao_assinar.png)

### Em Assinatura
* Terceira aba do painel, a listagem apresenta os projetos que já possuem um laudo final emitido e este já foi assinado pelo menos pelo Coordenador Geral, mas ainda não tem todas as assinaturas.
 ![Aba em assinatura](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/aba_em_assinatura.png)
* A ação é para visualizar o laudo final.

#### Visualizar Laudo
* Clique na ação da aba Em Assinatura.
![Clique ação visualizar laudo](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/acao_visualizar.png)
* Uma modal vai abrir apresentado um visualização do laudo final emitido.
![Tela visualizar laudo](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/visualizar_laudo.png)

### Finalizados
* Ultima aba do painel com a listagem dos projetos finalizados, ou seja, projetos que já possuem um laudo final emitido e este foi assinado por todos os responsáveis.
 ![Aba finalizados](https://github.com/culturagovbr/salic-minc/blob/f/ar/documentacao-laudo/application/modules/avaliacao-resultados/docs/imagens/aba_finalizados.png)
* A ação nessa aba é para visualizar o laudo final da mesma forma que na aba Em Assinatura.