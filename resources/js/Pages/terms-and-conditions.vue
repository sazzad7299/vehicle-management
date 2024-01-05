<template>
    <div>
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative">
                <div class="container">
                    <div class="hero-text-box text-center">
                        <h1 class="text-primary hero-title display-4 fw-bold">One dashboard to manage all your businesses
                        </h1>
                        <h2 class="hero-sub-title h6 mb-4 pb-1">
                            Production-ready &amp; easy to use Admin Template<br class="d-none d-lg-block">
                            for Reliability and Customizability.
                        </h2>
                        <div class="landing-hero-btn d-inline-block position-relative">
                            <span class="hero-btn-item position-absolute d-none d-md-flex text-heading">Join community
                                <img :src="asset('backend/assets/img/illustrations/Join-community-arrow.png')"
                                    alt="Join community arrow" class="scaleX-n1-rtl">
                            </span>
                            <router-link :to="{ name:'login' }" class="btn btn-primary">Login</router-link>  <router-link :to="{name:'register'}" class="btn btn-primary">Register</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="landingFeatures" class="py-5 landing-features bg-light">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">Useful Features</span>
                </div>
                <h3 class="text-center mb-1">
                    <span class="section-title">Everything you need</span> to start your next project
                </h3>
                <p class="text-center mb-3 mb-md-5 pb-3">
                    Not just a set of tools, the package includes ready-to-deploy conceptual application.
                </p>
                <div class="features-icon-wrapper row gx-0 gy-4 g-sm-5">
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <!-- <img src="../../assets/img/front-pages/icons/laptop.png" alt="laptop charging"> -->
                        </div>
                        <h5 class="mb-3">Quality Code</h5>
                        <p class="features-icon-description">
                            Code structure that all developers will easily understand and fall in love with.
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <!-- <img src="../../assets/img/front-pages/icons/rocket.png" alt="transition up"> -->
                        </div>
                        <h5 class="mb-3">Continuous Updates</h5>
                        <p class="features-icon-description">
                            Free updates for the next 12 months, including new demos and features.
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <!-- <img src="../../assets/img/front-pages/icons/paper.png" alt="edit"> -->
                        </div>
                        <h5 class="mb-3">Stater-Kit</h5>
                        <p class="features-icon-description">
                            Start your project quickly without having to remove unnecessary features.
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <!-- <img src="../../assets/img/front-pages/icons/check.png" alt="3d select solid"> -->
                        </div>
                        <h5 class="mb-3">API Ready</h5>
                        <p class="features-icon-description">
                            Just change the endpoint and see your own data loaded within seconds.
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <!-- <img src="../../assets/img/front-pages/icons/user.png" alt="lifebelt"> -->
                        </div>
                        <h5 class="mb-3">Excellent Support</h5>
                        <p class="features-icon-description">An easy-to-follow doc with lots of references and code
                            examples.</p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img :src="asset('backend/assets/img/illustrations/keyboard.png')" alt="google docs">
                        </div>
                        <h5 class="mb-3">Well Documented</h5>
                        <p class="features-icon-description">An easy-to-follow doc with lots of references and code
                            examples.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-py bg-body landing-pricing">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">Pricing Plans</span>
                </div>
                <h3 class="text-center mb-1"><span class="section-title">Tailored pricing plans</span> designed for you</h3>
                <p class="text-center mb-4 pb-3">
                    All plans include 40+ advanced tools and features to boost your product.<br>Choose the best plan to fit
                    your needs.
                </p>
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block pt-3 pt-md-0">
                        <div
                            class="d-flex align-items-center justify-content-center flex-wrap gap-2 pb-5 pt-3 mb-0 mb-md-4">
                            <label class="d-flex align-items-center justify-content-center gap-2">
                                <span class="switch-label px-3">Monthly</span>
                                <span class="form-check form-switch form-switch-lg">
                                    <input class="form-check-input switch-lg" type="checkbox" v-model="buystatus">
                                </span>
                                <span class="switch-label px-3">Annual</span>
                            </label>
                            <div class="mt-n5 ms-n5 ml-2 mb-2 d-none d-sm-inline-flex align-items-start">
                                <img :src="asset('backend/assets/img/illustrations/pricing-arrow-light.png')">
                                <span class="badge badge-sm bg-label-primary">Save upto 10%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gy-4 pt-lg-3">
                    <div v-for="(plan, index) in planlist" class="col-xl-4 col-lg-6 mx-auto">
                        <div class="card border border-primary shadow-lg">
                            <div class="card-header">
                                <div class="text-center">
                                    <img :src="asset('backend/assets/img/illustrations/paper-airplane.png')"
                                        alt="plane icon" class="mb-4 pb-2 scaleX-n1-rtl">
                                    <h4 class="mb-1">{{ plan.name }}</h4>
                                    <p class="text-center">{{ plan.description }}</p>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                            <h1 class="price-toggle price-yearly display-4 text-primary mb-0"
                                                v-show="!buystatus">{{
                                                    plan.monthly }}</h1>
                                            <h1 class="price-toggle price-monthly display-4 text-primary mb-0"
                                                v-show="buystatus">{{
                                                    plan.annually }}</h1>
                                            <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal"
                                                v-show="!buystatus">/month</sub>
                                            <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal"
                                                v-show="buystatus">/Yearly</sub>
                                        </div>
                                        <!-- <small class="price-yearly price-yearly-toggle text-muted" v-show="!buystatus">$ {{
                                            plan.annually }} / year</small>
                                        <small class="price-yearly price-yearly-toggle text-muted" v-show="buystatus">$ {{
                                            plan.monthly }} / monthly</small> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li v-for="feature in plan.features">
                                        <h5>
                                            <span class="badge badge-center rounded-pill bg-primary p-0 me-2"><i
                                                    class="bx bx-check bx-xs"></i></span>
                                            {{ feature.title }}
                                        </h5>
                                    </li>

                                </ul>
                                <div class="d-grid mt-4 pt-3">
                                    <router-link :to="{ name: 'plan.myplan' }" class="btn btn-primary">Get
                                        Started</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="landingFunFacts" class="section-py bg-light">
            <div class="landing-fun-facts">
                <div class="container">
                    <div class="row gy-3">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card border border-primary shadow-none">
                                <div class="card-body text-center">
                                    <img :src="asset('backend/assets/img/illustrations/laptop.png')" alt="laptop"
                                        class="mb-2">
                                    <h5 class="h2 mb-1">7.1k+</h5>
                                    <p class="fw-medium mb-0">
                                        Support Tickets<br>
                                        Resolved
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card border border-success shadow-none">
                                <div class="card-body text-center">
                                    <img :src="asset('backend/assets/img/illustrations/user-success.png')" alt="laptop"
                                        class="mb-2">
                                    <h5 class="h2 mb-1">7.1k+</h5>
                                    <p class="fw-medium mb-0">
                                        Join creatives<br>
                                        community
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card border border-info shadow-none">
                                <div class="card-body text-center">
                                    <img :src="asset('backend/assets/img/illustrations/diamond-info.png')" alt="laptop"
                                        class="mb-2">
                                    <h5 class="h2 mb-1">7.1k+</h5>
                                    <p class="fw-medium mb-0">
                                        Highly Rated<br>
                                        Reviewed
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card border border-warning shadow-none">
                                <div class="card-body text-center">
                                    <img :src="asset('backend/assets/img/illustrations/check-warning.png')" alt="laptop"
                                        class="mb-2">
                                    <h5 class="h2 mb-1">7.1k+</h5>
                                    <p class="fw-medium mb-0">
                                        Money Back <br> Guarantee
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-py">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
                        <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
                            <ul class="nav nav-align-left nav-pills flex-column" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment"
                                        aria-selected="true" role="tab">
                                        <i class="bx bx-credit-card faq-nav-icon me-1"></i>
                                        <span class="align-middle">Payment</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivery"
                                        aria-selected="false" role="tab" tabindex="-1">
                                        <i class="bx bx-shopping-bag faq-nav-icon me-1"></i>
                                        <span class="align-middle">Delivery</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancellation"
                                        aria-selected="false" role="tab" tabindex="-1">
                                        <i class="bx bx-rotate-left faq-nav-icon me-1"></i>
                                        <span class="align-middle">Cancellation &amp; Return</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders"
                                        aria-selected="false" role="tab" tabindex="-1">
                                        <i class="bx bx-cube faq-nav-icon me-1"></i>
                                        <span class="align-middle">My Orders</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product"
                                        aria-selected="false" role="tab" tabindex="-1">
                                        <i class="bx bx-cog faq-nav-icon me-1"></i>
                                        <span class="align-middle">Product &amp; Services</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <router-link :to="{ name: 'login' }">
                                        <button class="nav-link">
                                            <i class='bx bx-log-in-circle me-1'></i>
                                            <span class="align-middle">Back To Login</span>
                                        </button>
                                    </router-link>
                                </li>
                            </ul>
                            <div class="d-none d-md-block">
                                <div class="mt-5">
                                    <img :src="asset('backend/assets/img/illustrations/sitting-girl-with-laptop-light.png')"
                                        class="img-fluid w-px-200" alt="FAQ Image"
                                        data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                                        data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="tab-content py-0">
                            <div class="tab-pane fade active show" id="payment" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div>
                                        <span class="badge bg-label-primary rounded-2">
                                            <i class="bx bx-credit-card bx-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">
                                            <span class="align-middle">Payment</span>
                                        </h4>
                                        <span>Get help with payment</span>
                                    </div>
                                </div>
                                <div id="accordionPayment" class="accordion">
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" aria-expanded="false"
                                                data-bs-target="#accordionPayment-1" aria-controls="accordionPayment-1">
                                                When is payment taken for my order?
                                            </button>
                                        </h2>

                                        <div id="accordionPayment-1" class="accordion-collapse collapse" style="">
                                            <div class="accordion-body">
                                                Payment is taken during the checkout process when you pay for your order.
                                                The
                                                order
                                                number that appears on the confirmation screen indicates payment has been
                                                successfully processed.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionPayment-2"
                                                aria-controls="accordionPayment-2">
                                                How do I pay for my order?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                We accept Visa®, MasterCard®, American Express®, and PayPal®. Our servers
                                                encrypt
                                                all information submitted to them, so you can be confident that your credit
                                                card
                                                information will be kept
                                                safe and secure.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionPayment-3"
                                                aria-controls="accordionPayment-3">
                                                What should I do if I'm having trouble placing an order?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                For any technical difficulties you are experiencing with our website, please
                                                contact
                                                us at our
                                                <a href="javascript:void(0);">support portal</a>, or you can call us
                                                toll-free
                                                at
                                                <strong>1-000-000-000</strong>, or email us at
                                                <a href="javascript:void(0);">order@companymail.com</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionPayment-4"
                                                aria-controls="accordionPayment-4">
                                                Which license do I need for an end product that is only accessible to paying
                                                users?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-4" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                If you have paying users or you are developing any SaaS products then you
                                                need
                                                an
                                                Extended License. For each products, you need a license. You can get free
                                                lifetime
                                                updates as well.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionPayment-5"
                                                aria-controls="accordionPayment-5">
                                                Does my subscription automatically renew?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-5" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                No, This is not subscription based item.Pastry pudding cookie toffee bonbon
                                                jujubes
                                                jujubes powder topping. Jelly beans gummi bears sweet roll bonbon muffin
                                                liquorice.
                                                Wafer lollipop
                                                sesame snaps.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="delivery" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div>
                                        <span class="badge bg-label-primary rounded-2">
                                            <i class="bx bx-cart bx-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">
                                            <span class="align-middle">Delivery</span>
                                        </h4>
                                        <span>Get help with delivery</span>
                                    </div>
                                </div>
                                <div id="accordionDelivery" class="accordion">
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                aria-expanded="true" data-bs-target="#accordionDelivery-1"
                                                aria-controls="accordionDelivery-1">
                                                How would you ship my order?
                                            </button>
                                        </h2>

                                        <div id="accordionDelivery-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                For large products, we deliver your product via a third party logistics
                                                company
                                                offering you the “room of choice” scheduled delivery service. For small
                                                products, we
                                                offer free parcel
                                                delivery.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionDelivery-2"
                                                aria-controls="accordionDelivery-2">
                                                What is the delivery cost of my order?
                                            </button>
                                        </h2>
                                        <div id="accordionDelivery-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">The cost of scheduled delivery is $69 or $99 per
                                                order,
                                                depending on the destination postal code. The parcel delivery is free.</div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionDelivery-4"
                                                aria-controls="accordionDelivery-4">
                                                What to do if my product arrives damaged?
                                            </button>
                                        </h2>
                                        <div id="accordionDelivery-4" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                We will promptly replace any product that is damaged in transit. Just
                                                contact
                                                our
                                                <a href="javascript:void(0);">support team</a>, to notify us of the
                                                situation
                                                within
                                                48 hours of product arrival.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cancellation" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div>
                                        <span class="badge bg-label-primary rounded-2">
                                            <i class="bx bx-revision bx-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0"><span class="align-middle">Cancellation &amp; Return</span></h4>
                                        <span>Get help with cancellation &amp; return</span>
                                    </div>
                                </div>
                                <div id="accordionCancellation" class="accordion">
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                aria-expanded="true" data-bs-target="#accordionCancellation-1"
                                                aria-controls="accordionCancellation-1">
                                                Can I cancel my order?
                                            </button>
                                        </h2>

                                        <div id="accordionCancellation-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <p>
                                                    Scheduled delivery orders can be cancelled 72 hours prior to your
                                                    selected
                                                    delivery date for full refund.
                                                </p>
                                                <p class="mb-0">
                                                    Parcel delivery orders cannot be cancelled, however a free return label
                                                    can
                                                    be
                                                    provided upon request.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionCancellation-2"
                                                aria-controls="accordionCancellation-2">
                                                Can I return my product?
                                            </button>
                                        </h2>
                                        <div id="accordionCancellation-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                You can return your product within 15 days of delivery, by contacting our
                                                <a href="javascript:void(0);">support team</a>, All merchandise returned
                                                must be
                                                in
                                                the original packaging with all original items.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" aria-controls="accordionCancellation-3"
                                                data-bs-target="#accordionCancellation-3">
                                                Where can I view status of return?
                                            </button>
                                        </h2>
                                        <div id="accordionCancellation-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <p>Locate the item from Your <a href="javascript:void(0);">Orders</a></p>
                                                <p class="mb-0">Select <strong>Return/Refund</strong> status</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="orders" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div>
                                        <span class="badge bg-label-primary rounded-2">
                                            <i class="bx bx-box bx-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">
                                            <span class="align-middle">My Orders</span>
                                        </h4>
                                        <span>Order details</span>
                                    </div>
                                </div>
                                <div id="accordionOrders" class="accordion">
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                aria-expanded="true" data-bs-target="#accordionOrders-1"
                                                aria-controls="accordionOrders-1">
                                                Has my order been successful?
                                            </button>
                                        </h2>

                                        <div id="accordionOrders-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <p>
                                                    All successful order transactions will receive an order confirmation
                                                    email
                                                    once
                                                    the order has been processed. If you have not received your order
                                                    confirmation
                                                    email within 24 hours,
                                                    check your junk email or spam folder.
                                                </p>
                                                <p class="mb-0">
                                                    Alternatively, log in to your account to check your order summary. If
                                                    you do
                                                    not
                                                    have a account, you can contact our Customer Care Team on
                                                    <strong>1-000-000-000</strong>.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionOrders-2"
                                                aria-controls="accordionOrders-2">
                                                My Promotion Code is not working, what can I do?
                                            </button>
                                        </h2>
                                        <div id="accordionOrders-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">If you are having issues with a promotion code,
                                                please
                                                contact us at <strong>1 000 000 000</strong> for assistance.</div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionOrders-3"
                                                aria-controls="accordionOrders-3">
                                                How do I track my Orders?
                                            </button>
                                        </h2>
                                        <div id="accordionOrders-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <p>
                                                    If you have an account just sign into your account from
                                                    <a href="javascript:void(0);">here</a> and select <strong>“My
                                                        Orders”</strong>.
                                                </p>
                                                <p class="mb-0">
                                                    If you have a a guest account track your order from
                                                    <a href="javascript:void(0);">here</a> using the order number and the
                                                    email
                                                    address.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div>
                                        <span class="badge bg-label-primary rounded-2">
                                            <i class="bx bx-camera bx-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">
                                            <span class="align-middle">Product &amp; Services</span>
                                        </h4>
                                        <span>Get help with product &amp; services</span>
                                    </div>
                                </div>
                                <div id="accordionProduct" class="accordion">
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                aria-expanded="true" data-bs-target="#accordionProduct-1"
                                                aria-controls="accordionProduct-1">
                                                Will I be notified once my order has shipped?
                                            </button>
                                        </h2>

                                        <div id="accordionProduct-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                Yes, We will send you an email once your order has been shipped. This email
                                                will
                                                contain tracking and order information.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionProduct-2"
                                                aria-controls="accordionProduct-2">
                                                Where can I find warranty information?
                                            </button>
                                        </h2>
                                        <div id="accordionProduct-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                We are committed to quality products. For information on warranty period and
                                                warranty services, visit our Warranty section <a
                                                    href="javascript:void(0);">here</a>.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#accordionProduct-3"
                                                aria-controls="accordionProduct-3">
                                                How can I purchase additional warranty coverage?
                                            </button>
                                        </h2>
                                        <div id="accordionProduct-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                For the peace of your mind, we offer extended warranty plans that add
                                                additional
                                                year(s) of protection to the standard manufacturer’s warranty provided by
                                                us. To
                                                purchase or find out more
                                                about the extended warranty program, visit Extended Warranty section <a
                                                    href="javascript:void(0);">here</a>.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="landingContact" class="section-py bg-light landing-contact">
            <div class="container">
                <div class="text-center mb-3 pb-1">
                    <span class="badge bg-label-primary">Contact US</span>
                </div>
                <h3 class="text-center mb-1"><span class="section-title">Let's work</span> together</h3>
                <p class="text-center mb-4 mb-lg-5 pb-md-3">Any question or remark? just write us a message</p>
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div class="contact-img-box position-relative border p-2 h-100">
                            <img :src="('backend/assets/img/illustrations/contact-customer-service.png')"
                                alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl img-fluid">
                            <div class="pt-3 px-4 pb-1">
                                <div class="row gy-3 gx-md-4">
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge bg-label-primary rounded p-2 me-2"><i
                                                    class="bx bx-envelope bx-sm"></i></div>
                                            <div>
                                                <p class="mb-0">Email</p>
                                                <h5 class="mb-0">
                                                    <a href="mailto:example@gmail.com"
                                                        class="text-heading">example@gmail.com</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge bg-label-success rounded p-2 me-2">
                                                <i class="bx bx-phone-call bx-sm"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0">Phone</p>
                                                <h5 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">+1234 568
                                                        963</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-1">Send a message</h4>
                                <p class="mb-4">
                                    If you would like to discuss anything related to payment, account, licensing,<br
                                        class="d-none d-lg-block">
                                    partnerships, or have pre-sales questions, you’re at the right place.
                                </p>
                                <form>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact-form-fullname">Full Name</label>
                                            <input type="text" class="form-control" id="contact-form-fullname"
                                                placeholder="john">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact-form-email">Email</label>
                                            <input type="text" id="contact-form-email" class="form-control"
                                                placeholder="johndoe@gmail.com">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="contact-form-message">Message</label>
                                            <textarea id="contact-form-message" class="form-control" rows="9"
                                                placeholder="Write a message"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Send inquiry</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                planlist: {},
                status: null,
                statuses: [
                    { value: 1, name: 'Active' },
                    { value: 2, name: 'Inactive' },
                ],
                buystatus: true,
                yourPostDataHere: { /* your post data */ },
                cart_json: {
                    amount: '',
                    status: '',
                    userId: '',
                },
                endpoint: "/api/pay-via-ajax",
            }
        },
        methods: {
            planList() {
                axios.get('/plan', { params: { paginate: false } })
                    .then((response) => {
                        this.loader(false);
                        this.planlist = response.data.result;
                    })
                    .catch((error) => {
                        this.loader(false);
                        toastr.error(error);
                    })
            },
        },
        mounted() {
            this.planList();
        }
    }
</script>
<style scoped>
.form-check-input {
    width: 60px !important;
    height: 30px !important;
}

li {
    list-style: none;
}

.section-py {
    padding: 6.25rem 0
}

@media(max-width: 1199.98px) {
    .section-py {
        padding: 5rem 0
    }
}

@media(max-width: 767.98px) {
    .section-py {
        padding: 3rem 0
    }
}

.landing-hero {
    border-radius: 0 0 3.5rem 3.5rem;
    padding: 10.2rem 0;
}

.landing-hero::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1
}

@media(min-width: 992px) {
    .landing-hero .hero-text-box {
        max-width: 34.375rem;
        margin: 0 auto
    }
}

.landing-hero .hero-title {
    background: linear-gradient(to right, #28c76f 0%, #5a4aff 47.92%, #ff3739 100%);
    background-size: 200% auto;
    color: #566a7f;
    background-clip: text;
    line-height: 1.2;
    text-fill-color: rgba(0, 0, 0, 0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: rgba(0, 0, 0, 0);
    animation: shine 2s ease-in-out infinite alternate
}

.landing-hero .hero-sub-title {
    line-height: 28px
}

.landing-hero .landing-hero-btn .hero-btn-item {
    inset-inline-start: -102%;
    top: 50%
}

.landing-hero .hero-animation-img {
    margin-bottom: -32rem
}

@media(max-width: 1199.98px) {
    .landing-hero .hero-animation-img {
        margin-bottom: -20rem
    }
}

@keyframes shine {
    0% {
        background-position: 0% 50%
    }

    80% {
        background-position: 50% 90%
    }

    100% {
        background-position: 91% 100%
    }
}

.landing-features .features-icon-wrapper .features-icon-box .features-icon-description {
    max-width: 19.25rem;
    margin: 0 auto
}

.landing-fun-facts {
    border-radius: 0 0 3.5rem 3.5rem;
}

.landing-reviews .landing-reviews-btns .reviews-btn {
    padding: .45rem
}

.landing-pricing .pricing-plans-item {
    inset-inline-end: -60%;
    bottom: 0
}

@media(max-width: 767.98px) {
    .landing-pricing .pricing-plans-item {
        inset-inline-end: 0;
        bottom: 1rem
    }
}

.landing-pricing .price-yearly-toggle {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%)
}

.landing-pricing .card .card-header,
.landing-pricing .card .card-body {
    padding: 2rem
}

.landing-faq {
    border-top-left-radius: 3.75rem;
    border-top-right-radius: 3.75rem
}

.landing-faq .faq-image {
    max-width: 20rem;
    width: 80%
}

.landing-cta {
    background-repeat: no-repeat;
    background-size: cover
}

.landing-contact .text-heading {
    overflow-wrap: anywhere
}

.landing-contact .contact-img-box,
.landing-contact .contact-img-box .contact-img {
    border-radius: 3.75rem .375rem .375rem .375rem
}

.landing-contact .contact-img-box::before {
    content: url("backend/assets/img/illustrations/contact-border.png");
    position: absolute;
    inset-block-start: -2.5rem;
    inset-inline-start: -2.8125rem
}

@media(max-width: 767.98px) {
    .landing-contact .contact-img-box::before {
        display: none
    }
}

.light-style .landing-hero {
    background: linear-gradient(138.18deg, #eae8fd 0%, #fce5e6 94.44%)
}

.light-style .landing-hero::after {
    background-color: #fff
}

.light-style .landing-cta {
    background-image: url("../../../img/front-pages/backgrounds/cta-bg.png")
}

.dark-style .landing-hero {
    background: #1e2130
}

.dark-style .landing-hero::after {
    background-color: #2b2c40
}

.dark-style .landing-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    height: 100%;
    background: url("../../../img/front-pages/backgrounds/hero-bg-dark.png") center no-repeat;
    background-size: contain
}

.dark-style .landing-cta {
    background-image: url("../../../img/front-pages/backgrounds/cta-bg-dark.png")
}

[dir=rtl] .landing-team .team-image-box .card-img-position {
    transform: translateX(50%) !important
}

[dir=rtl] .landing-reviews .landing-reviews-btns {
    flex-direction: row-reverse;
    justify-content: start
}

[dir=rtl] .landing-reviews .landing-reviews-btns .reviews-btn {
    padding: .45rem
}

[dir=rtl] .landing-pricing .switch .switch-label {
    padding-right: 0
}

[dir=rtl] .landing-pricing .switch .switch-label:first-child {
    padding-left: .5rem
}

[dir=rtl] .landing-pricing .switch .switch-input~.switch-label {
    padding-right: 3rem
}

[dir=rtl] .landing-contact .contact-img-box {
    border-radius: .375rem 3.75rem .375rem .375rem
}

[dir=rtl] .landing-contact .contact-img-box::before {
    inset-block-start: -1.875rem;
    inset-inline-start: -3.125rem;
    transform: rotate(90deg)
}</style>
