describe('Testes dos Sub-menu Execucao', function () {
    it('Verifica se há pelo menos um item no sub-menu - "pedido-prorrogacao" ', function () {
        cy.get('#pronac').type('171313{enter}');
        cy.get(':nth-child(6) > .collapsible > .bold > .collapsible-header > span').click();
        cy.get(':nth-child(6) > .collapsible > .bold > .collapsible-body > ul > :nth-child(5) > .waves-effect').click();

        cy.get('.m9 > h1').should('not.be.empty').contains('Pedido de Prorrogação');
    });
});