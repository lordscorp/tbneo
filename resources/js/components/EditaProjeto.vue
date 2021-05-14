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
                        <a :class="'nav-link' + (aba === abaAtual ? ' active' : '')" @click="abaAtual = aba" href="#">{{capitalize(aba)}}</a>
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
                            <div class="col-3">
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
            filtroNome: "",
            projeto: {},
            projetoRaw: {},
            respostaAPI: {},
            usuario: {},
            usuarios: [],
            abas: ['geral', 'features', 'log'],
            abaAtual: 'geral',
            avisos: {
                sucesso: {
                    tipo: "success",
                    texto: "Informações foram salvas com sucesso!"
                },
                erro: {
                    tipo: "danger",
                    texto: "Não foi possível gravar as informações. Por favor, verifique as informações preenchidas."
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
    methods: {
        buscaProjeto: function () {
            axios
                .get("/api/projeto/" + this.$route.params.id)
                .then((response) => {
                    this.projetoRaw = response.data;
                    this.projeto = {...response.data};
                    this.buscaLog()
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
            if(this.$route.params.id) {
                // Atualiza dados do projeto atual
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
                    // Projeto cadastrado com sucesso. Cadastra features (se houver)
                    this.salvarFeatures(response.data.id);
                    this.mostraAviso(this.avisos.sucesso);
                    this.buscaProjeto();
                })

            }
            else {
                // Grava novo projeto
            }
        },
        salvarFeatures: function (idProjeto) {
            if(!idProjeto > 0) {
                return
            }
        }
    },
};
</script>