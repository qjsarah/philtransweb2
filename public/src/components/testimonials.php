<div class="vh-100" data-aos="fade-right" data-aos-duration="1500">
    <div id="testimonial" class=""></div>
</div>
<script >
    const testimonialDiv = document.getElementById('testimonial');
    testimonialDiv.innerHTML = `
    <section class="pt-5">
        <div class="mt-5 position-relative" data-aos="fade-right" data-aos-duration="1500">
            <div class="bg-primary h-auto text-lg-start  testimonial-header p-5">
                <h4 class="text-light" data-aos="fade-right" data-aos-duration="1500">What our Client Says</h4>
                <h4 class="text-warning display-4 fw-bold" data-aos="fade-right" data-aos-duration="1500">TESTIMONIALS</h4>
            <div>
            <img src="../../public/main/images/testimonial_section/testimonial_image.png" alt="" class="testimonial-img img-fluid" data-aos="fade-up" data-aos-duration="1000">
        </div>
    </section>
    <div class="mt-5">
        <div class="owl-carousel owl-theme justify-content-center mt-5 my-auto container">
            ${testimonials.map(test => `
            <div class="item text-center p-4 d-flex flex-column mt-5">
                <div class="img-area bg-light">
                    <p class="fw-bolder display-1 text-primary my-auto">"</p>
                </div>
                <p class="mb-3">"${test.text}"</p>
                <div class="text-warning">
                ${'★'.repeat(test.stars)}${'☆'.repeat(5 - test.stars)}
                </div><br>
                <div>
                    <strong>${test.name}</strong><br>
                    <small class="text-muted">${test.role}</small><br>
                </div>
            </div>
            `).join('')}
        </div>
    </div>
        `;
    $('.owl-carousel').owlCarousel({
        rtl: false,
        loop: true,
        margin: 20,
        center: true,
        smartSpeed: 1500,
        autoplay: true,
        autoplayTimeout: 1500,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 2,
                nav: false
            },
            960: {
                items: 3,
                nav: false
            }
        }
    });
</script>
