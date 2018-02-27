# Testes do SALIC

### Como estão organizados os testes?

Os testes estão localizados na pasta app/tests. Nessa pasta, podemos ver:
```
   application   -> as rotinas de teste ficam aqui
   bin           -> script para executar os testes
   log           -> logs e relatórios de cobertura
```
Na pasta application, há um arquivo Bootstrap.php, que inicializa o sistema para a suite de testes e uma pasta 'modules'. Dentro da pasta 'modules', cada módulo a ser testado possui uma pasta separada entre controllers e models. Por hora, estamos testando apenas backend.

### Requisitos:
* Composer atualizado
* Definir os parametros ```test.params.login = 'XXXXXXXXXXX'```(CPF) e ```test.params.password = 'xxxxx'```(senha) no arquivo de configuração ```Application/configs/application.ini```

### Testes Essenciais:
* ```dispatch()``` e ```assertUrl()``` -> Respectivamente carrega uma action e verifica se a url foi carregada
* ```assertResponseCode('200');``` -> Assegura que o código da página carregada foi o informado 

### Padrões de nomenclatura
* Métodos de teste que testam actions devem terminar seu nome com "Action";

### Metas - Curto Prazo
* Eliminar erros ou falhas dos testes atuais

### O que testar?


### Como testar?


