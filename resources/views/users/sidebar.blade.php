
<div class="col-md-2">
    <div class="row">
        <div class="col-md-12">
            <p>Menu</p>
            <!-- Icons -->
            <ul class="list-group list-group-icons-meta">
                <li class="list-group-item list-group-item-action {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard">
                        <div class="media">
                            <div class="d-flex mr-3">
                                <i data-feather="user"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="tx-inverse">Profil</h6>

                            </div>
                        </div>
                    </a>
                </li>
                <li class="list-group-item list-group-item-action {{ Request::is('myorder') ? 'active' : '' }}">

                    <a href="/myorder">
                    <div class="media">
                        <div class="d-flex mr-3">
                            <i data-feather="truck"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-inverse">Pesanan saya</h6>

                        </div>
                    </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
