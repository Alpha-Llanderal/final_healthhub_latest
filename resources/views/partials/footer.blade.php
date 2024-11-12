<!-- FOOTER -->
<footer class="footer bg-light text-dark py-3">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- CONTACT DETAILS -->
            <div class="col-md-8">
                <div class="contact-details d-flex flex-wrap align-items-center">
                    <span class="me-3 fw-bold text-primary">Contact Us:</span>
                    <div class="d-flex align-items-center me-3">
                        <i class="bi bi-pin-map-fill text-primary me-1" aria-label="Address icon"></i>
                        <span>Lahug, Cebu City, Cebu, Visayas 6000</span>
                    </div>
                    <div class="d-flex align-items-center me-3">
                        <i class="bi bi-telephone-fill text-primary me-1" aria-label="Phone icon"></i>
                        <span>(888) 422-7974</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope-at-fill text-primary me-1" aria-label="Email icon"></i>
                        <span>support@healthhub.com</span>
                    </div>
                </div>
            </div>
            
            <!-- SOCIAL MEDIA ICONS -->
            <div class="col-md-4 text-end">
                <div class="social-links">
                    <a href="https://www.facebook.com/healthhubconnect" 
                       target="_blank" 
                       class="text-primary me-3" 
                       aria-label="Facebook">
                        <i class="bi bi-facebook fs-4 hover-scale" data-bs-toggle="tooltip" title="Follow us on Facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/healthhubconnect" 
                       target="_blank" 
                       class="text-danger me-3" 
                       aria-label="Instagram">
                        <i class="bi bi-instagram fs-4 hover-scale" data-bs-toggle="tooltip" title="Follow us on Instagram"></i>
                    </a>
                    <a href="https://www.healthhub.com" 
                       target="_blank" 
                       class="text-success" 
                       aria-label="Website">
                        <i class="bi bi-globe fs-4 hover-scale" data-bs-toggle="tooltip" title="Visit our Website"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>