describe('Testes da Tela Inicial do Sistema', function() {
    it('Renderização da tela de login', function() {
        cy.visit('localhost');
    });
    it('Login no sistema', function() {
        cy.visit('localhost');

        var login = cy.get('form div div').find('input').eq(0);
        login.type('');
        var senha = cy.get('form div div').find('input').eq(1);
        senha.type('');

        cy.get('form').submit();

    });

  });