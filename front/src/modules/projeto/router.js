import DadosProjeto from './DadosProjeto'
import Proponente from '../agente/Proponente'

export default [
    {
        path: '/projeto',
        name: 'DadosProjeto',
        component: DadosProjeto,
        title: 'Dados do Projeto',
        children: [
            {
                path: 'proponente',
                name: 'proponente',
                component: Proponente,
            }
        ],
    },
];
