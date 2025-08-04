<section class="pt-5">
    <div class="mt-5 position-relative" data-aos="fade-left" data-aos-duration="1500">
        <img src="../main/images/services_section/services-image.png" alt="" class="service-img img-fluid"  data-aos="fade-left" data-aos-duration="1000">
        <div class="bg-primary h-auto text-md-end text-center p-5 service">
            <h4 class="text-light" data-aos="fade-left" data-aos-duration="1000">How it Works</h4>
            <h4 class="text-warning display-4 fw-bold" data-aos="fade-left" data-aos-duration="1000">SERVICES</h4>
        <div>
    </div>
</section>
<div id="services-container" class="container mt-5 pt-3 pb-5"></div>
<script>
const servicesContainerDiv = document.getElementById('services-container');
servicesContainerDiv.innerHTML = `
    ${services.map(service => `
        <div class="service-card border border-primary p-5 mb-3 rounded-5 text-primary" data-aos="fade-right" data-aos-duration="1500">
            <h4 class="fw-bold service-head my-auto">${service.head}</h4>
            <p class="service-body mt-2">${service.body}</p> 
        </div>
    `).join('')}
`;
</script>