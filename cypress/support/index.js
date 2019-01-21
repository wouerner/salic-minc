// Import commands.js using ES2015 syntax:
import './commands'

before(() => {
    cy.visit('localhost');
    var login = cy.get('#Login').type('239.691.561-49'); // Login
    var senha = cy.get('#Senha').type('123456'); // Senha
    cy.get('form').submit();

    cy.visit('http://localhost/principal');

    cy.wait(1000);


    cy.server()
    cy.route({
      method: 'GET',      // Route all GET requests
      url: '/navegacao/menu-principal',
    }).as('menuPrincipal')

    cy.server()
    cy.route({
      method: 'GET',      // Route all GET requests
      url: '/avaliacao-resultados/fluxo-projeto?estadoid=5&idAgente=236',
    }).as('projetosInicio')
});


// Alternatively you can use CommonJS syntax:
// require('./commands')
