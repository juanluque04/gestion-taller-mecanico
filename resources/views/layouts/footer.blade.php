<footer class="mt-auto pt-4 pb-4" style="background:#0f172a; border-top:1px solid #1e293b; color:#cbd5e1;">

    <div class="container-fluid px-5 d-flex justify-content-center">
        
        <div style="max-width: 800px; width: 100%;">

            <div class="row justify-content-center">

                <div class="col-md-4 mb-4">
                    <h6 class="text-uppercase fw-bold mb-3" data-bs-toggle="collapse" style="color:#f1f5f9;">Información</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fa-solid fa-circle-info me-2 text-success"></i>Ayuda</li>
                        <li class="mb-2"><i class="fa-solid fa-file-contract me-2 text-success"></i>Términos de uso</li>
                        <li class="mb-2"><i class="fa-solid fa-shield-halved me-2 text-success"></i>Privacidad</li>
                        <li class="mb-2"><i class="fa-solid fa-envelope me-2 text-success"></i>Contacto</li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h6 class="text-uppercase fw-bold mb-3" data-bs-toggle="collapse" style="color:#f1f5f9;">Sobre Nosotros</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('sobreNosotros') }}" class="text-decoration-none" style="color:#cbd5e1;">
                                <i class="fa-solid fa-user-tie me-2 text-success"></i>Quiénes somos
                            </a>
                        </li>
                        <li class="mb-2"><i class="fa-solid fa-rocket me-2 text-success"></i>Nuestra misión</li>
                        <li class="mb-2"><i class="fa-solid fa-people-group me-2 text-success"></i>Equipo</li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4" data-bs-toggle="collapse" style="color:#f1f5f9;" id="fol">Síguenos</h6>
                    <div class="d-flex gap-3 mb-3 justify-content-center">
                        <i class="fa-brands fa-facebook fa-xl"></i>
                        <i class="fa-brands fa-instagram fa-xl"></i>
                        <i class="fa-brands fa-x-twitter fa-xl"></i>
                        <i class="fa-brands fa-youtube fa-xl"></i>
                        <i class="fa-brands fa-tiktok fa-xl"></i>
                    </div>

                    <div class="d-flex gap-3 mt-3 justify-content-center">
                        <span><i class="fa-solid fa-location-dot me-1"></i> España</span>
                    </div>

                </div>

            </div>

            <hr style="border-color:#1e293b;">

            <div class="text-center small" style="color:#94a3b8;">
                © {{ date('Y') }} Gestor de Taller — Todos los derechos reservados.
            </div>

        </div>
    </div>
</footer>
