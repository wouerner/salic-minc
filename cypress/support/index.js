// Import commands.js using ES2015 syntax:
import './commands'

before(() => {
    cy.visit('localhost');
    var login = cy.get('#Login').type('239.691.561-49'); // Login
    var senha = cy.get('#Senha').type('123456'); // Senha
    cy.get('form').submit();

    cy.visit('http://localhost/principal');

    
    // cy.mockDadosSALIC();
    // cy.mockProjetosInicio()
    cy.wait(2000);

});
// Alternatively you can use CommonJS syntax:
// require('./commands')
