<?php $meta_title = "Thank You!"; ?>

<?php $meta_discription = "Thank you for contacting AppVerra! Our team will get back to you shortly to discuss your app development project."; ?>

<?php $page_class = "thankyou-page"; ?>

<?php include("header.php"); ?>

<section class="hero_banner thankyou_banner">

	<div class="container text-center light d-flex justify-content-center align-items-center">

		<div class="col-lg-6 col-md-7 mx-auto">

			<h1 class="heading70px">Thank You!</h1>

			<p><span class="primeColor"><?= $sitename ?></span> will be contacting you shortly in order to discuss your project requirements.</p>

			<span class="btn_wrap"  data-aos="fade-up" data-aos-delay="600">

                <a href="/" class="theme_btn">

                    <span class="iconCircle">

                        <span class="iconWrap">

                            <i data-feather="arrow-left"></i>

                            <i data-feather="arrow-left"></i>

                        </span>

                    </span>

                    <span class="btnTextWrap">

                        <span>Go Back</span>

                        <span>Go Back</span>

                    </span>

                </a>

            </span>

		</div>

	</div>

</section>



<style>

	.caption {background-color: #00000021; padding: 30px; border-radius: 20px; }

	section.homeBanner {height: 76vh; display: flex; align-items: center; justify-content: center; }

</style>

<?php include("footer.php"); ?>