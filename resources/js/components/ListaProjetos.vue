<template>
    <div class="container">
        <div class="inner-header card my-3 px-3">
            <div class="card-body p-3">
                <a href="/editar-projeto"><button class="btn btn-success">Novo</button></a>
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
                            @keyup="buscaProjetos()"
                        />
                        <button class="btn btn-secondary" @click="limpaFiltro">
                            Limpar
                        </button>
                    </div>
                </div>
                <div class="row" style="overflow: auto; height: 50vh;">
                    <!-- Lista de projetos -->
                    <table v-if="projetos.length > 0" class="table table-striped">
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
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" :id="'dropdownMenuButton'+key" @click="toggle(key)" type="button">Opções</button>
                                        <div v-if="projetos[key].mostraOpcoes" class="dropdown-menu" style="display: block;">
                                            <a :href="'/edita-projeto/'+projeto.id" class="dropdown-item">Editar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="!projetos.length > 0" class="card">
                        <div class="card-body">
                            <div class="alert alert-secondary">Não foi localizado nenhum projeto. Deseja <a href="/editar-projeto">cadastrar um novo projeto</a> ?</div>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <!-- Paginação -->
                    <div class="col-2">
                        <nav aria-label="Paginação">
                            <ul class="pagination">
                                <li class="page-item"><a href="#" @click="buscaProjetos(respostaAPI.first_page_url)" class="page-link">&lt;&lt;</a></li>
                                <li :class="respostaAPI.prev_page_url ? 'page-item' : 'page-item disabled'"><a href="#" @click="buscaProjetos(respostaAPI.prev_page_url)" class="page-link">&lt;</a></li>
                                <li class="page-item disabled"><a href="#" class="page-link">{{respostaAPI.current_page}}</a></li>
                                <li :class="respostaAPI.next_page_url ? 'page-item' : 'page-item disabled'"><a href="#" @click="buscaProjetos(respostaAPI.next_page_url)" class="page-link">&gt;</a></li>
                                <li :class="respostaAPI.last_page_url ? 'page-item' : 'page-item disabled'"><a href="#" @click="buscaProjetos(respostaAPI.last_page_url)" class="page-link">&gt;&gt;</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col">

                    </div>
                    <div class="col-4">
                        <div class="input-group">
                            <div class="form-control">Total de registros:</div>
                            <div class="form-control" style="max-width: 5em;">{{respostaAPI.total}}</div>
                        </div>
                    </div>
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
        this.buscaProjetos();
    },
    methods: {
        buscaProjetos: function (urlPagina = false) {
            const getUrl = urlPagina ? urlPagina : "/api/projetos/" + this.filtroNome

            axios
                .get(getUrl)
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
            this.buscaProjetos();
        },
        formataTimestamp: function (tstamp) {
            let formatado = new Date(tstamp).toLocaleString();
            return formatado;
        },
        toggle: function(key) {
            this.projetos[key].mostraOpcoes = this.projetos[key].mostraOpcoes ? false : true;
            this.$forceUpdate();
        }
    },
};
</script>