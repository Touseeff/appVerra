<?php require_once __DIR__ . '/includes/schema_helpers.php'; ?>

<?php
$meta_title       = "App Development by City — New York, LA, SF & More | Appverra";
$meta_discription = "Mobile app development across the USA. We work with startups and businesses in New York, Los Angeles, San Francisco, Chicago, Austin, Miami, Dallas, and Seattle — same-timezone, founder-led. 150+ apps shipped. From $7,997.";
$page_class       = "locationsHub-page testimonial_light";
$og_image         = "https://appverra.co/assets/images/logo.webp";
$canonical_override = "https://appverra.co/locations";

$breadcrumbs = [
    ['name' => 'Home',      'url' => 'https://appverra.co/'],
    ['name' => 'Locations', 'url' => 'https://appverra.co/locations'],
];

$schema_extra = [
    build_service_schema([
        'name'        => 'Mobile App Development by Location',
        'serviceType' => 'Mobile App Development',
        'url'         => 'https://appverra.co/locations',
        'description' => 'Mobile app development for startups and businesses across the United States, headquartered in New York City. Founder-led agency, 150+ apps shipped for 700+ customers. Same-timezone collaboration, fixed-bid pricing from $7,997.',
        'areaServed'  => ['US', 'CA', 'GB'],
    ]),
    build_breadcrumb_schema($breadcrumbs),
];
?>

<?php include __DIR__ . '/header.php'; ?>

<!-- ===================== HERO ===================== -->
<section class="hero_banner mainBanner innerBanner serviceBanner">
	<div class="container">
		<div class="row align-items-center position-relative">
			<div class="col-lg-9">
				<span class="revealUp d-inline-block mb-md-4 mb-sm-3 mb-2">
					<span class="heading26px light">Where We Work</span>
				</span>

				<?php include __DIR__ . '/breadcrumbs.php'; ?>

				<h1 class="heading70px m-0 light">
					<span class="revealUp"><span>App Development</span></span> <br>
					<span class="revealUp"><span class="secondColor">Across the USA</span></span>
				</h1>

				<svg class="animated_svg2 mb-3" width="672" height="36" viewBox="0 0 672 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 32C199.013 20.5125 606.673 -9.88059 663.31 11.341C719.946 32.5627 249.686 20.1834 7.47644 11.341" stroke="#B3FF00" stroke-width="7" stroke-linecap="round"/></svg>

				<p style="color: #C3C9CE;">We are headquartered in Tribeca, New York City, and we build apps for founders and businesses across the country — in your timezone, with the founder-engineer on the call. 150+ apps shipped, 700+ customers, millions of downloads. Pick your city to see how we work locally, or book a Discovery Sprint from anywhere in the US.</p>

				<div class="btn_set">
					<span class="btn_wrap" data-aos="fade-up" data-aos-delay="600">
						<a href="javascript:;" class="theme_btn pop_btn">
							<span class="btnTextWrap"><span>Get Started</span><span>Get Started</span></span>
							<span class="iconCircle"><span class="iconWrap"><i data-feather="arrow-right"></i><i data-feather="arrow-right"></i></span></span>
						</a>
					</span>
					<span class="btn_wrap" data-aos="fade-up" data-aos-delay="600">
						<a href="tel:<?= $tel ?>" class="theme_btn">
							<span class="btnTextWrap"><span>Call Now</span><span>Call Now</span></span>
							<span class="iconCircle"><span class="iconWrap"><i data-feather="phone"></i><i data-feather="phone"></i></span></span>
						</a>
					</span>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ============ CITIES ============ -->
<section class="py-lg-5 py-4">
	<div class="container">
		<div class="row">
			<div class="col-lg-10">
				<h2 class="heading55px dark" data-aos="fade-up">Cities we <span class="secondColor">build in</span></h2>
				<p data-aos="fade-up" data-aos-delay="100">Local pages for the metros where we work most. Not listed? We work with US founders everywhere — same timezone, no offshore handoff.</p>
			</div>
		</div>
		<div class="row g-3 mt-2">
			<div class="col-md-6 col-lg-3" data-aos="fade-up"><a href="/locations/new-york-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">New York</h3><p class="m-0">Our HQ — Tribeca, NYC.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="60"><a href="/locations/los-angeles-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">Los Angeles</h3><p class="m-0">DTC, media, and marketplace apps.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="120"><a href="/locations/san-francisco-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">San Francisco</h3><p class="m-0">Funded startups and SaaS.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="180"><a href="/locations/chicago-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">Chicago</h3><p class="m-0">Logistics, fintech, and B2B.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up"><a href="/locations/austin-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">Austin</h3><p class="m-0">Startups and creator products.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="60"><a href="/locations/miami-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">Miami</h3><p class="m-0">Fintech, crypto, and LATAM-facing.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="120"><a href="/locations/dallas-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">Dallas</h3><p class="m-0">Enterprise and services apps.</p></a></div>
			<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="180"><a href="/locations/seattle-app-development" class="d-block bg-light p-4 rounded h-100" style="text-decoration:none;color:inherit;"><h3 class="heading24px dark m-0">Seattle</h3><p class="m-0">Cloud, commerce, and product apps.</p></a></div>
		</div>
	</div>
</section>

<?php include __DIR__ . '/cta-section.php'; ?>
<?php include __DIR__ . '/contact-us-section.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>
