 <!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url( 'painel/paginas' ); ?>">
            Painel Codeigniter 3
        </a>
    </div>
    
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                &nbsp;<?php echo $this->session->userdata('user')['nome']; ?>&nbsp;
                <b class="caret"></b>
            </a>
            
            <ul class="dropdown-menu">
                <li>
                    <a href="<?php echo base_url( 'painel/usuarios/editar/' . strip_tags( addslashes( trim( $this->session->userdata('user')['hash'] ) ) ) ); ?>">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                        &nbsp;Perfil&nbsp;
                    </a>
                </li>
                        
                <li>
                    <a href="<?php echo base_url( 'painel/configuracoes' ); ?>">
                        <i class="fa fa-fw fa-gear" aria-hidden="true"></i> 
                        &nbsp;Settings&nbsp;
                    </a>
                </li>
                
                <li class="divider"></li>
                
                <li>
                    <a href="<?php echo base_url( 'painel/usuarios/sair' ); ?>">
                        <i class="fa fa-fw fa-power-off" aria-hidden="true"></i>
                        &nbsp;Sair&nbsp;
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Sidebar -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#midias">
                    <i class="fa fa-fw fa-picture-o" aria-hidden="true"></i>
                    &nbsp;Mídias&nbsp;
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>    

                <ul id="midias" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/midias' ); ?>">
                            Mídias
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/midias/create' ); ?>">
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#paginas">
                    <i class="fa fa-fw fa-file" aria-hidden="true"></i>
                    &nbsp;Páginas&nbsp;
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>                   
                </a>

                <ul id="paginas" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/paginas' ); ?>">
                            Páginas
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/paginas/cadastrar' ); ?>">
                            Cadastrar
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/paginas/reorder' ); ?>">
                            Reorder
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#categorias">
                    <i class="fa fa-fw fa-archive" aria-hidden="true"></i>
                    &nbsp;Categorias&nbsp; 
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>
                
                <ul id="categorias" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/categorias' ); ?>">
                            Categorias
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url( 'painel/categorias/cadastrar' ); ?>">
                            Cadastrar
                        </a>
                    </li>                    
                </ul>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts">
                    <i class="fa fa-fw fa-bookmark" aria-hidden="true"></i>
                    &nbsp;Posts&nbsp;
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>

                <ul id="posts" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/posts' ); ?>">
                            Posts
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/posts/cadastrar' ); ?>">
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#usuarios">
                    <i class="fa fa-fw fa-users" aria-hidden="true"></i>
                    &nbsp;Usuários&nbsp;
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>

                <ul id="usuarios" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/usuarios' ); ?>">
                            Usuários
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/usuarios/cadastrar' ); ?>">
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#configuracoes">
                    <i class="fa fa-fw fa-cog" aria-hidden="true"></i>
                    &nbsp;Configurações&nbsp;
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>

                <ul id="configuracoes" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/configuracoes' ); ?>">
                            Configurações
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/configuracoes/cadastrar' ); ?>">
                            Cadastrar
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#auditoria">
                    <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
                    Auditoria
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>

                <ul id="auditoria" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/auditoria' ); ?>">
                            Informações
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#views">
                    <i class="fa fa-fw fa-eye" aria-hidden="true"></i>
                    Views
                    <i class="fa fa-fw fa-caret-down" aria-hidden="true"></i>
                </a>

                <ul id="views" class="collapse">
                    <li>
                        <a href="<?php echo base_url( 'painel/views' ); ?>">
                            Informações
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url( 'painel/views/infos' ); ?>">
                            Views
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>