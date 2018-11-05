before( () => {
    cy.visit('localhost');
        
    var login = cy.get('form div div').find('input').eq(0).type('239.691.561-49'); // Login
    var senha = cy.get('form div div').find('input').eq(1).type('123456'); // Senha
    cy.get('form').submit();

    cy.visit('http://localhost/principal');

    cy.wait(1000)
});

// Import commands.js using ES2015 syntax:
import './commands'

// Alternatively you can use CommonJS syntax:
// require('./commands')
