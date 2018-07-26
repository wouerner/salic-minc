import * as getters from './getters';

describe('Projeto getters', () => {
    let state;

    beforeEach(() => {
        state = {
            projeto: {},
        };
    });

    test('projeto', () => {
        const result = getters.projeto(state);
        expect(result).toEqual(state.projeto);
    });
});
