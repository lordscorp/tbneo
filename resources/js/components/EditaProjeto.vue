<template>
    <div class="container">
        <div class="inner-header card my-3 px-3">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-2">                        
                        <button @click="salvar()" class="btn btn-success"><i class="bi bi-save"></i> Confirmar</button>
                    </div>
                    <div class="col">
                        <div v-if="avisoAtual" :class="'text-center alert alert-'+(avisoAtual.tipo)">{{avisoAtual.texto}}</div>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-secondary" href="/lista-projetos"><i class="bi bi-x"></i> Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item" v-for="(aba, key) in abas" :key="key">
                        <a :class="'nav-link' + (aba === abaAtual ? ' active' : '')" @click="abaAtual = aba" style="cursor: pointer">{{capitalize(aba)}}</a>
                    </li>
                </ul>
            </div>
            <!-- Aba Geral -->
            <div v-if="abaAtual === 'geral'">
                <!-- Informações Gerais -->
            <div class="card-body">
                <div class="card">
                    <div class="card-header">Informações Gerais</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="id_projeto">ID</label>
                                <input type="text" id="id_projeto" class="form-control" v-model="projeto.id" disabled>
                            </div>
                            <div class="col">
                                <label for="nome_projeto">Nome *</label>
                                <input type="text" id="nome_projeto" class="form-control" v-model="projeto.nome_projeto">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="descricao">Descrição</label>
                                <input type="text" id="descricao" class="form-control" v-model="projeto.descricao">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="criado_por">Criado Por</label>
                                <input type="text" id="criado_por" class="form-control" :value="nomePorId(projeto.criado_por)" disabled>
                            </div>

                            <div class="col">
                                <label for="created_at">Em</label>
                                <input type="text" id="created_at" class="form-control" :value="formataTimestamp(projeto.created_at)" disabled>
                            </div>

                            <div class="col">
                                <label for="atualizado_por">Atualizado Por</label>
                                <input type="text" id="atualizado_por" class="form-control" :value="nomePorId(projeto.atualizado_por)" disabled>
                            </div>

                            <div class="col">
                                <label for="updated_at">Em</label>
                                <input type="text" id="updated_at" class="form-control" :value="formataTimestamp(projeto.updated_at)" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dados do projeto -->
            <div class="card-body">
                <div class="card">
                    <div class="card-header">Dados do Projeto</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="url_jira">URL Jira</label>
                                <div class="btn-group">
                                    <input type="text" id="url_jira" class="form-control" v-model="projeto.url_jira"><a :href="projeto.url_jira" title="Abrir link" target="_blank"><button class="btn btn-danger"><i class="bi bi-box-arrow-up-right"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Aba Features -->
            <div v-if="abaAtual === 'features'" class="card-container">
                <div class="card">
                    <div class="card-header">Features</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="filtroFeatures" placeholder="Digite para filtrar">
                                    <button @click="filtroFeatures = ''" class="btn btn-secondary">Limpar</button>
                                </div>
                            </div>
                        </div>
                        <!-- Tabela de features -->
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Nome</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(feature, key) in featuresFiltradas" :key="key">
                                            <td>
                                                <a :href="feature.url">{{feature.nome_feature}}</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Paginação -->
                        <div class="row my-3">
                        <div class="col-2">
                            <nav aria-label="Paginação">
                                <ul class="pagination">
                                    <li class="page-item"><a href="#" @click="buscaFeatures(respostaAPI.first_page_url)" class="page-link">&lt;&lt;</a></li>
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
            <!-- Aba Log -->
            <div v-if="abaAtual === 'log'" class="card-container">
                <div class="card">
                    <div class="card-header">Log (Horários de Brasília)</div>
                    <div class="card-body">
                        <div class="card m-2" v-for="(log, key) in logs" :key="key">
                            <div class="card-body">
                                <span><strong>{{formataTimestamp(log.created_at)}}</strong></span>
                                <p>
                                    O valor do campo <u>{{log.propriedade_alterada}}</u> foi {{log.alteracao_realizada}} <span v-if="log.alteracao_realizada === 'preenchido'"> como <u>{{log.valor_novo}}</u></span> por <span class="font-italic">{{usuarios[log.alterado_por].name}}</span>.
                                </p>
                                <span class="font-weight-bold">Valor antigo: </span><span>{{log.valor_anterior}}</span>
                            </div>
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
            filtroFeatures: "",
            projeto: {
                nome_projeto: "",
                descricao: "",
                url_jira: ""
            },
            projetoRaw: {},
            respostaAPI: {},
            usuario: {},
            usuarios: [],
            abas: ['geral', 'features', 'log'],
            abaAtual: 'geral',
            logs: [],
            features: [],
            avisos: {
                sucesso: {
                    tipo: "success",
                    texto: "Informações foram salvas com sucesso!"
                },
                erro: {
                    tipo: "danger",
                    texto: "Não foi possível gravar as informações. Por favor, verifique as informações preenchidas."
                },
                nome: {
                    tipo: "warning",
                    texto: "É necessário informar o nome do projeto."
                }
            },
            avisoAtual: false,
            camposEditaveis: ['nome_projeto', 'descricao', 'url_jira']
        };
    },
    mounted() {
        this.buscaUsuarios();
        if(this.$route.params.id)
            this.buscaProjeto();
    },
    computed: {
        featuresFiltradas: function() {
            return this.features?.filter((feature) => {
                return feature.nome_feature.toUpperCase().includes(this.filtroFeatures.toUpperCase())
            })
        }
    },
    methods: {
        buscaProjeto: function () {
            axios
                .get("/api/projeto/" + this.$route.params.id)
                .then((response) => {
                    this.projetoRaw = response.data;
                    this.projeto = {...response.data};
                    this.buscaFeatures();
                    this.buscaLog();
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        buscaFeatures: function (urlPagina = false) {
            const getUrl = urlPagina ? urlPagina : "/api/projeto/"+this.$route.params.id+"/features"
            axios
                .get(getUrl)
                .then((response) => {
                    this.respostaAPI = response.data;
                    this.features = this.respostaAPI.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        buscaLog: function () {
            axios
                .get("/api/projeto/"+this.$route.params.id+"/log")
                .then((response) => {
                    this.logs = response.data;
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
                    // Para fins de simplificação do projeto, será atribuído o usuário "1", 
                    // mas esse dado poderia facilmente ser obtido pelo login do sistema
                    this.usuario = this.usuarios[1] // Aqui, atribuido ao primeiro usuario cadastrado no sistema
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        capitalize: function (texto) {
            return texto.charAt(0).toUpperCase() + texto.slice(1);
        },
        formataTimestamp: function (tstamp) {
            if(!tstamp)
                return "";
            let formatado = new Date(tstamp).toLocaleString();
            return formatado;
        },
        mostraAviso: function(aviso) {
            this.avisoAtual = aviso;
            window.setTimeout(() => {
                this.avisoAtual = false
            }, 10000);
        },
        nomePorId: function (idUsuario) {
            let nome = this.usuarios[idUsuario]?.name;
            return typeof(nome) === "string" ? nome : "";
        },
        salvar: function() {
            // Valida nome (obrigatório)
            if(!this.projeto.nome_projeto){
                this.mostraAviso(this.avisos.nome);
                document.querySelector('#nome_projeto').focus()
                return;
            }

            if(this.$route.params.id) {     // Atualiza dados do projeto atual
                // Verifica quais campos foram alterados para enviar somente alterações
                let dados = {
                    atualizado_por: this.usuario.id
                };
                for (let i in this.camposEditaveis) {
                    let propriedade = this.camposEditaveis[i];
                    if(this.projeto[propriedade] !== this.projetoRaw[propriedade])
                        dados[propriedade] = this.projeto[propriedade]
                }

                axios
                .put("/api/projeto/"+this.$route.params.id, {projeto: dados})
                .then((response) => {
                    this.mostraAviso(this.avisos.sucesso);
                    this.buscaProjeto();
                })
                .catch((err) => {
                    console.log(err);
                    this.mostraAviso(this.avisos.erro);
                })

            }
            else {      // Grava novo projeto
                this.projeto.criado_por = this.usuario.id;
                this.projeto.atualizado_por = this.usuario.id;
                axios
                .post("/api/projeto/store", {projeto: this.projeto})
                .then((response) => {
                    this.mostraAviso(this.avisos.sucesso);
                })
                .catch((err) => {
                    console.log(err);
                    this.mostraAviso(this.avisos.erro);
                })
            }
        }
    },
};
</script>