<div class="sidebar">
    <nav class="sidebar-nav ">
        <ul class="nav">
            <li @click='menu=4' class="nav-item">
                <a class="nav-link active " href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title ">Mantenimiento
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle  " href="#"><i class="fa fa-user-md" aria-hidden="true"></i>
                    Almacén</a>
                <ul class="nav-dropdown-items  ">
                    <li @click='menu=1' class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-hospital-o" aria-hidden="true"></i> Casa
                            Farmacéutica</a>
                    </li>
                    <li @click='menu=2' class="nav-item ">
                        <a class="nav-link" href="#"><i class="fa fa-ambulance" aria-hidden="true"></i>
                            Gramaje</a>
                    </li>
                    <li @click='menu=3' class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-sitemap" aria-hidden="true"></i>Medicamentos</a>
                    </li>

                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown" href="#" @click='menu=4' class="nav-item"><i class="fa fa-user-md"
                        aria-hidden="true"></i> Inventario</a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i>Entradas</a>
                <ul class="nav-dropdown-items">
                    <li @click='menu=5' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Ingresos</a>
                    </li>
                    <li @click='menu=6' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Proveedores</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i>Salidas</a>
                <ul class="nav-dropdown-items">
                    <li @click='menu=7' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Salidas</a>
                    </li>
                    <li @click='menu=8' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Clientes</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                <ul class="nav-dropdown-items">
                    <li @click='menu=11' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ingresos</a>
                    </li>
                    <li @click='menu=12' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Salidas</a>
                    </li>
                    <li @click='menu=13' class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i>Repor_Medicamentos</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown negro borde-b">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i> Ayuda-Manuales</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-bag"></i>Usuario<span class="badge badge-danger">PDF</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="nav-link" href="#">
                    <i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
            </li>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>