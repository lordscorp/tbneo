import ListaProjetos from './components/ListaProjetos.vue';
import EditaProjeto from './components/EditaProjeto.vue';

export const routes = [
    {
        name: 'Listar Projetos',
        path: '/lista-projetos',
        component: ListaProjetos
    },
    {
        name: 'Editar Projeto',
        path: '/edita-projeto/:id?',
        component: EditaProjeto
    }
];
