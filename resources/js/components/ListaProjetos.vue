<template>
    <div class="container">
        <div class="inner-header card my-3 px-3">
            <div class="card-body p-3">
                <button class="btn btn-success">Novo</button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Projetos</div>
            <div class="card-body">
                <div class="form-row">
                    <div id="filtro" class="col input-group w-25">
                        <input
                            type="text"
                            class="form-control"
                            v-model="filtroNome"
                            placeholder="Digite para filtrar"
                            @keyup="buscaProjetos"
                        />
                        <button class="btn btn-secondary" @click="limpaFiltro">
                            Limpar
                        </button>
                    </div>
                </div>
                <div class="row">
                    <!-- Lista de projetos -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Atualizado por</th>
                                <th scope="col">Atualizado em</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(projeto, key) in projetos" :key="key">
                                <td><a :href="projeto.url_jira">{{projeto.nome_projeto}}</a></td>
                                <td>{{ projeto.descricao }}</td>
                                <td>{{ usuarios[projeto.atualizado_por].name }}</td>
                                <td>{{ formataTimestamp(projeto.updated_at) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" :id="'dropdownMenuButton'+key" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</button>
                                        <div class="dropdown-menu" :aria-labelledby="'dropdownMenuButton'+key">
                                            <a :href="'/edita-projeto/'+projeto.id" class="dropdown-item">Editar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            filtroNome: "",
            projetos: [],
            respostaAPI: {},
            usuarios: [],
        };
    },
    mounted() {
        this.buscaUsuarios();
    },
    methods: {
        buscaProjetos: function () {
            axios
                .get("/api/projetos/" + this.filtroNome)
                .then((response) => {
                    this.respostaAPI = response.data;
                    this.projetos = this.respostaAPI.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        buscaUsuarios: function () {
            axios
                .get("/api/usuarios")
                .then((response) => {
                    let usuarios = response.data;
                    for (let i in usuarios) {
                        let idUsuario = usuarios[i].id;
                        this.usuarios[idUsuario] = usuarios[i];
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        limpaFiltro: function () {
            this.filtroNome = "";
        },
        formataTimestamp: function (tstamp) {
            let formatado = new Date(tstamp).toLocaleString();
            return formatado;
        },
    },
};
</script>