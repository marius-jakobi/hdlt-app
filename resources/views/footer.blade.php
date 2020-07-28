<footer class="footer mt-3 d-print-none">
    <div class="bg-secondary p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <p>
                        &copy; {{ date('Y') }} Herbst Drucklufttechnik GmbH
                    </p>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right">
                    <p><a href="{{ route('legal.imprint') }}" class="footer-link">Impressum</a></p>
                    <p><a href="{{ route('legal.data-protection') }}" class="footer-link">Datenschutz</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>