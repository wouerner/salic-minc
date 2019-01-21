// Cypress.Commands.add("dismiss", { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This is will overwrite an existing command --
// Cypress.Commands.overwrite("visit", (originalFn, url, options) => { ... })

Cypress.Commands.add("mudarPerfil", (codGrupo, codOrgao) => {
  cy.request(`http://localhost/autenticacao/perfil/alterarperfil?codGrupo=${codGrupo}&codOrgao=${codOrgao}`);

  cy.visit('http://localhost/principal');

})


Cypress.Commands.add('projetosInicio', () => {
  // Mock Server
  // cy.request('http://localhost:4000/avaliacao-resultados/fluxo-projeto?estadoid=5&idAgente=236').then((response) => {
  //     var mock = response.body
  //   })

    cy.wait('@projetosInicio').then((response) => {
      response.body = {} // mock 
    })

});